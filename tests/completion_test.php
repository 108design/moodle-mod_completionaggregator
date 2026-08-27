<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

namespace mod_completionaggregator;

use mod_completionaggregator\local\constants;
use mod_completionaggregator\local\evaluator;
use mod_completionaggregator\local\repository;

defined('MOODLE_INTERNAL') || die();

final class completion_test extends \advanced_testcase {
    public function test_complete_and_pass_semantics_and_regression(): void {
        global $DB;
        $this->resetAfterTest();
        $course = $this->getDataGenerator()->create_course(['enablecompletion' => 1]);
        $user = $this->getDataGenerator()->create_and_enrol($course, 'student');
        $pages = [];
        foreach (range(1, 3) as $number) {
            $page = $this->getDataGenerator()->create_module('page', ['course' => $course->id],
                ['completion' => COMPLETION_TRACKING_MANUAL]);
            $pages[] = get_coursemodule_from_instance('page', $page->id)->id;
        }
        $aggregator = $this->getDataGenerator()->create_module('completionaggregator', [
            'course' => $course->id, 'requiredcount' => 2, 'conditiontype' => constants::CONDITION_COMPLETE,
            'sourcecmids' => $pages,
        ], ['completion' => COMPLETION_TRACKING_AUTOMATIC]);
        $DB->insert_record('course_modules_completion', (object)[
            'coursemoduleid' => $pages[0], 'userid' => $user->id, 'completionstate' => COMPLETION_COMPLETE_PASS,
            'timemodified' => time(),
        ]);
        $DB->insert_record('course_modules_completion', (object)[
            'coursemoduleid' => $pages[1], 'userid' => $user->id, 'completionstate' => COMPLETION_COMPLETE_FAIL,
            'timemodified' => time(),
        ]);
        [, , $complete] = evaluator::count_satisfied($aggregator, $user->id);
        $this->assertTrue($complete);
        $aggregator->conditiontype = constants::CONDITION_PASS;
        $this->assertFalse(evaluator::count_satisfied($aggregator, $user->id)[2]);
        $DB->set_field('course_modules_completion', 'completionstate', COMPLETION_INCOMPLETE,
            ['coursemoduleid' => $pages[0], 'userid' => $user->id]);
        $aggregator->conditiontype = constants::CONDITION_COMPLETE;
        $this->assertFalse(evaluator::count_satisfied($aggregator, $user->id)[2]);
    }

    public function test_cycle_detection(): void {
        $this->resetAfterTest();
        $course = $this->getDataGenerator()->create_course(['enablecompletion' => 1]);
        $page = $this->getDataGenerator()->create_module('page', ['course' => $course->id], ['completion' => 1]);
        $pagecmid = get_coursemodule_from_instance('page', $page->id)->id;
        $a = $this->getDataGenerator()->create_module('completionaggregator', [
            'course' => $course->id, 'sourcecmids' => [$pagecmid],
        ], ['completion' => COMPLETION_TRACKING_AUTOMATIC]);
        $acmid = get_coursemodule_from_instance('completionaggregator', $a->id)->id;
        $b = $this->getDataGenerator()->create_module('completionaggregator', [
            'course' => $course->id, 'sourcecmids' => [$acmid],
        ], ['completion' => COMPLETION_TRACKING_AUTOMATIC]);
        $bcmid = get_coursemodule_from_instance('completionaggregator', $b->id)->id;
        $this->assertTrue(repository::introduces_cycle($a->id, [$bcmid]));
        $this->assertFalse(repository::introduces_cycle($b->id, [$pagecmid]));
    }
}

