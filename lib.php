<?php
/**
 * File documentation for lib.php.
 *
 * @package   mod_completionaggregator
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license   See LICENSE.md for the full terms.
 */
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

defined('MOODLE_INTERNAL') || die();

function completionaggregator_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
        case FEATURE_SHOW_DESCRIPTION:
        case FEATURE_BACKUP_MOODLE2:
        case FEATURE_COMPLETION_HAS_RULES:
            return true;
        case FEATURE_GRADE_HAS_GRADE:
            return false;
        default:
            return null;
    }
}

function completionaggregator_add_instance($data, $mform = null): int {
    global $DB;
    $now = time();
    $data->timecreated = $now;
    $data->timemodified = $now;
    $sources = array_values(array_unique(array_map('intval', (array)$data->sourcecmids)));
    if (!\mod_completionaggregator\local\repository::validate_sources(
            (int)$data->course, $sources, (int)($data->coursemodule ?? 0)) ||
            (int)$data->requiredcount < 1 || (int)$data->requiredcount > count($sources)) {
        throw new moodle_exception('errorinvalidsource', 'completionaggregator');
    }
    unset($data->sourcecmids);
    $transaction = $DB->start_delegated_transaction();
    $id = $DB->insert_record('completionaggregator', $data);
    \mod_completionaggregator\local\repository::replace_sources($id, $sources);
    $transaction->allow_commit();
    return $id;
}

function completionaggregator_update_instance($data, $mform = null): bool {
    global $DB, $CFG;
    require_once($CFG->libdir . '/completionlib.php');
    $data->id = $data->instance;
    $data->timemodified = time();
    $sources = array_values(array_unique(array_map('intval', (array)$data->sourcecmids)));
    if (!\mod_completionaggregator\local\repository::validate_sources(
            (int)$data->course, $sources, (int)($data->coursemodule ?? 0)) ||
            (int)$data->requiredcount < 1 || (int)$data->requiredcount > count($sources) ||
            \mod_completionaggregator\local\repository::introduces_cycle((int)$data->instance, $sources)) {
        throw new moodle_exception('errorinvalidsource', 'completionaggregator');
    }
    unset($data->sourcecmids);
    $transaction = $DB->start_delegated_transaction();
    $result = $DB->update_record('completionaggregator', $data);
    \mod_completionaggregator\local\repository::replace_sources($data->id, $sources);
    $transaction->allow_commit();
    rebuild_course_cache($data->course, true);
    $cm = get_coursemodule_from_instance('completionaggregator', $data->id, $data->course, false, MUST_EXIST);
    (new completion_info(get_course($data->course)))->reset_all_state($cm);
    return $result;
}

function completionaggregator_delete_instance($id): bool {
    global $DB;
    if (!$DB->record_exists('completionaggregator', ['id' => $id])) {
        return false;
    }
    $transaction = $DB->start_delegated_transaction();
    $DB->delete_records('completionaggregator_sources', ['aggregatorid' => $id]);
    $DB->delete_records('completionaggregator', ['id' => $id]);
    $transaction->allow_commit();
    return true;
}

function completionaggregator_get_coursemodule_info($coursemodule) {
    global $DB;
    $instance = $DB->get_record('completionaggregator', ['id' => $coursemodule->instance], '*', IGNORE_MISSING);
    if (!$instance) {
        return null;
    }
    $info = new cached_cm_info();
    $info->name = $instance->name;
    if ($coursemodule->completion == COMPLETION_TRACKING_AUTOMATIC) {
        $info->customdata['customcompletionrules'][\mod_completionaggregator\local\constants::RULE] = 1;
    }
    return $info;
}

function completionaggregator_cm_info_dynamic(cm_info $cm): void {
    if (!has_capability('mod/completionaggregator:view', context_module::instance($cm->id))) {
        $cm->set_user_visible(false);
    }
}

/**
 * Record an authorised native module view without changing the aggregation rule.
 *
 * @param stdClass $instance Aggregator instance.
 * @param stdClass $course Owning course.
 * @param stdClass $cm Course module.
 * @param context_module $context Module context.
 */
function completionaggregator_view(stdClass $instance, stdClass $course, stdClass $cm, context_module $context): void {
    require_capability('mod/completionaggregator:view', $context);
    if ((int)$cm->instance !== (int)$instance->id || (int)$cm->course !== (int)$course->id
            || (int)$context->instanceid !== (int)$cm->id) {
        throw new invalid_parameter_exception('Activity view context does not match its instance.');
    }
    $event = \mod_completionaggregator\event\course_module_viewed::create([
        'objectid' => $instance->id, 'context' => $context,
    ]);
    $event->add_record_snapshot('course', $course);
    $event->add_record_snapshot('course_modules', $cm);
    $event->add_record_snapshot('completionaggregator', $instance);
    $event->trigger();
}

/** Native navbar help on the authorised activity and its edit form. */
function mod_completionaggregator_render_navbar_output(\renderer_base $renderer): string {
    return \mod_completionaggregator\local\context_help::navbar($renderer);
}
