<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/completionaggregator/backup/moodle2/backup_completionaggregator_stepslib.php');

class backup_completionaggregator_activity_task extends backup_activity_task {
    protected function define_my_settings(): void {}
    protected function define_my_steps(): void {
        $this->add_step(new backup_completionaggregator_activity_structure_step('completionaggregator_structure', 'completionaggregator.xml'));
    }
    public static function encode_content_links($content) { return $content; }
}

