<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

defined('MOODLE_INTERNAL') || die();

class mod_completionaggregator_generator extends \testing_module_generator {
    public function create_instance($record = null, ?array $options = null) {
        $record = (object)(array)$record;
        $record->requiredcount = $record->requiredcount ?? 1;
        $record->conditiontype = $record->conditiontype ?? 'complete';
        $record->sourcecmids = $record->sourcecmids ?? [];
        return parent::create_instance($record, (array)$options);
    }
}

