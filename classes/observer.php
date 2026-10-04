<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

namespace mod_completionaggregator;

use mod_completionaggregator\local\repository;

defined('MOODLE_INTERNAL') || die();

final class observer {
    public static function completion_updated(\core\event\course_module_completion_updated $event): void {
        $userid = (int)($event->relateduserid ?: ($event->other['userid'] ?? 0));
        if (!$userid) {
            return;
        }
        self::update_dependants((int)$event->contextinstanceid, $userid);
    }

    private static function update_dependants(int $sourcecmid, int $userid): void {
        global $CFG;
        require_once($CFG->libdir . '/completionlib.php');
        foreach (repository::get_dependants($sourcecmid) as $aggregator) {
            $cm = get_coursemodule_from_instance('completionaggregator', $aggregator->id, $aggregator->course, false, MUST_EXIST);
            $completion = new \completion_info(get_course($aggregator->course));
            if ($completion->is_enabled($cm)) {
                $completion->update_state($cm, COMPLETION_UNKNOWN, $userid);
            }
        }
    }

    public static function course_module_deleted(\core\event\course_module_deleted $event): void {
        global $DB, $CFG;
        require_once($CFG->libdir . '/completionlib.php');
        $sourcecmid = (int)$event->contextinstanceid;
        $dependants = repository::get_dependants($sourcecmid);
        if (!$dependants) {
            return;
        }
        $DB->delete_records('completionaggregator_sources', ['cmid' => $sourcecmid]);
        foreach ($dependants as $aggregator) {
            $cm = get_coursemodule_from_instance('completionaggregator', $aggregator->id, $aggregator->course, false, IGNORE_MISSING);
            if ($cm) {
                $completion = new \completion_info(get_course($aggregator->course));
                $userids = $DB->get_fieldset_select('course_modules_completion', 'userid',
                    'coursemoduleid = :cmid', ['cmid' => $cm->id]);
                foreach ($completion->get_tracked_users() as $user) {
                    $userids[] = $user->id;
                }
                $completion->reset_all_state($cm);
                // Reset can leave an incomplete state without emitting an update
                // event. Recalculate direct dependants explicitly in that case;
                // their normal completion events propagate through further chains.
                foreach (array_unique(array_map('intval', $userids)) as $userid) {
                    self::update_dependants((int)$cm->id, $userid);
                }
            }
        }
    }
}
