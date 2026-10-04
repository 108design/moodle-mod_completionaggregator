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
    /** @var array Source references awaiting the complete course-module mapping. */
    private array $pendingsources = [];

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
        $data = (object)$data;
        $this->pendingsources[] = (object)[
            'aggregatorid' => $this->get_new_parentid('completionaggregator'),
            'oldcmid' => (int)$data->cmid,
            'sortorder' => (int)$data->sortorder,
        ];
    }

    protected function after_execute(): void {
        $this->add_related_files('mod_completionaggregator', 'intro', null);
    }

    protected function after_restore(): void {
        global $DB;
        // A referenced activity can follow this aggregator in the restore plan.
        foreach ($this->pendingsources as $source) {
            $mappedcmid = $this->get_mappingid('course_module', $source->oldcmid, 0);
            if (!$mappedcmid) {
                continue; // A source excluded from this backup must stay excluded.
            }
            $DB->insert_record('completionaggregator_sources', (object)[
                'aggregatorid' => $source->aggregatorid,
                'cmid' => $mappedcmid,
                'sortorder' => $source->sortorder,
            ]);
        }
        $this->pendingsources = [];
    }
}
