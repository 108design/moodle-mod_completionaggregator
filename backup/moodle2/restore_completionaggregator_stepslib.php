<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

defined('MOODLE_INTERNAL') || die();

class restore_completionaggregator_activity_structure_step extends restore_activity_structure_step {
    protected function define_structure(): array {
        $paths = [
            new restore_path_element('completionaggregator', '/activity/completionaggregator'),
            new restore_path_element('completionaggregator_source', '/activity/completionaggregator/sources/source'),
        ];
        return $this->prepare_activity_structure($paths);
    }

    protected function process_completionaggregator($data): void {
        global $DB;
        $data = (object)$data;
        $data->course = $this->get_courseid();
        $newid = $DB->insert_record('completionaggregator', $data);
        $this->apply_activity_instance($newid);
    }

    protected function process_completionaggregator_source($data): void {
        global $DB;
        $data = (object)$data;
        $mappedcmid = $this->get_mappingid('course_module', $data->cmid, 0);
        if (!$mappedcmid) {
            return;
        }
        $DB->insert_record('completionaggregator_sources', (object)[
            'aggregatorid' => $this->get_new_parentid('completionaggregator'),
            'cmid' => $mappedcmid,
            'sortorder' => $data->sortorder,
        ]);
    }

    protected function after_execute(): void {
        $this->add_related_files('mod_completionaggregator', 'intro', null);
    }
}
