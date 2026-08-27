<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

namespace mod_completionaggregator\completion;

use core_completion\activity_custom_completion;
use mod_completionaggregator\local\constants;
use mod_completionaggregator\local\evaluator;
use mod_completionaggregator\local\repository;

defined('MOODLE_INTERNAL') || die();

final class custom_completion extends activity_custom_completion {
    public static function get_defined_custom_rules(): array { return [constants::RULE]; }

    public function get_state(string $rule): int {
        global $DB;
        $this->validate_rule($rule);
        $instance = $DB->get_record('completionaggregator', ['id' => $this->cm->instance], '*', MUST_EXIST);
        [, , $complete] = evaluator::count_satisfied($instance, $this->userid);
        return $complete ? COMPLETION_COMPLETE : COMPLETION_INCOMPLETE;
    }

    public function get_custom_rule_descriptions(): array {
        global $DB;
        $instance = $DB->get_record('completionaggregator', ['id' => $this->cm->instance], '*', MUST_EXIST);
        $data = (object)['required' => $instance->requiredcount, 'total' => count(repository::get_source_ids($instance->id))];
        $key = $instance->conditiontype === constants::CONDITION_PASS ? 'rulepass' : 'rulecomplete';
        return [constants::RULE => get_string($key, 'completionaggregator', $data)];
    }

    public function get_sort_order(): array { return [constants::RULE]; }
}

