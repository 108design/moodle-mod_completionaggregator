<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/completionaggregator/backup/moodle2/restore_completionaggregator_stepslib.php');

class restore_completionaggregator_activity_task extends restore_activity_task {
    protected function define_my_settings(): void {}
    protected function define_my_steps(): void {
        $this->add_step(new restore_completionaggregator_activity_structure_step('completionaggregator_structure', 'completionaggregator.xml'));
    }
    public static function define_decode_contents(): array {
        return [new restore_decode_content('completionaggregator', ['intro'], 'completionaggregator')];
    }
    public static function define_decode_rules(): array { return []; }
}

