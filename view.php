<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

require_once(__DIR__ . '/../../config.php');

$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('completionaggregator', $id, 0, false, MUST_EXIST);
$course = get_course($cm->course);
$instance = $DB->get_record('completionaggregator', ['id' => $cm->instance], '*', MUST_EXIST);
require_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/completionaggregator:view', $context);

$PAGE->set_url('/mod/completionaggregator/view.php', ['id' => $cm->id]);
$PAGE->set_title(format_string($instance->name));
$PAGE->set_heading(format_string($course->fullname));
echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($instance->name));
$sources = \mod_completionaggregator\local\repository::get_source_ids($instance->id);
$data = (object)['required' => $instance->requiredcount, 'total' => count($sources)];
$rulekey = $instance->conditiontype === \mod_completionaggregator\local\constants::CONDITION_PASS ? 'rulepass' : 'rulecomplete';
echo html_writer::tag('p', get_string($rulekey, 'completionaggregator', $data));
if ((int)$instance->requiredcount > count($sources)) {
    echo $OUTPUT->notification(get_string('invalidconfiguration', 'completionaggregator'), 'notifyproblem');
}
echo $OUTPUT->heading(get_string('sources', 'completionaggregator'), 3);
$items = [];
$modinfo = get_fast_modinfo($course);
foreach ($sources as $sourceid) {
    if (isset($modinfo->cms[$sourceid])) {
        $items[] = format_string($modinfo->cms[$sourceid]->name);
    }
}
echo html_writer::alist($items);
echo $OUTPUT->footer();

