<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

defined('MOODLE_INTERNAL') || die();

class backup_completionaggregator_activity_structure_step extends backup_activity_structure_step {
    protected function define_structure() {
        $aggregator = new backup_nested_element('completionaggregator', ['id'], [
            'name', 'intro', 'introformat', 'requiredcount', 'conditiontype', 'timecreated', 'timemodified',
        ]);
        $sources = new backup_nested_element('sources');
        $source = new backup_nested_element('source', ['id'], ['cmid', 'sortorder']);
        $aggregator->add_child($sources);
        $sources->add_child($source);
        $aggregator->set_source_table('completionaggregator', ['id' => backup::VAR_ACTIVITYID]);
        $source->set_source_table('completionaggregator_sources', ['aggregatorid' => backup::VAR_PARENTID], 'sortorder, id');
        $aggregator->annotate_files('mod_completionaggregator', 'intro', null);
        $source->annotate_ids('course_module', 'cmid');
        return $this->prepare_activity_structure($aggregator);
    }
}

