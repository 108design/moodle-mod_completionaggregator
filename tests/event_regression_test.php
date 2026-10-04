<?php
// This file is part of a 108design source-available software product.
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
// See LICENSE.md for the full terms.

namespace mod_completionaggregator;

use mod_completionaggregator\local\repository;

defined('MOODLE_INTERNAL') || die();

/** Exercise native completion events, including chained aggregators. */
final class event_regression_test extends \advanced_testcase {
    public function test_native_completion_events_propagate_completion_and_reversal(): void {
        global $CFG;
        require_once($CFG->libdir . '/completionlib.php');
        $this->resetAfterTest();
        [$course, $user, $page, $first, $second] = $this->create_chain();
        $completion = new \completion_info($course);
        $sourcecm = get_coursemodule_from_instance('page', $page->id);
        $completion->update_state($sourcecm, COMPLETION_COMPLETE, $user->id);
        $this->assert_state($first->cmid, $user->id, COMPLETION_COMPLETE);
        $this->assert_state($second->cmid, $user->id, COMPLETION_COMPLETE);
        $completion->update_state($sourcecm, COMPLETION_INCOMPLETE, $user->id);
        $this->assert_state($first->cmid, $user->id, COMPLETION_INCOMPLETE);
        $this->assert_state($second->cmid, $user->id, COMPLETION_INCOMPLETE);
    }

    public function test_deleting_source_keeps_threshold_and_recalculates_chain(): void {
        global $CFG, $DB;
        require_once($CFG->libdir . '/completionlib.php');
        require_once($CFG->dirroot . '/course/lib.php');
        $this->resetAfterTest();
        [$course, $user, $page, $first, $second] = $this->create_chain();
        (new \completion_info($course))->update_state(get_coursemodule_from_instance('page', $page->id),
            COMPLETION_COMPLETE, $user->id);
        $this->assert_state($second->cmid, $user->id, COMPLETION_COMPLETE);
        if (method_exists(\core_courseformat\local\cmactions::class, 'delete')) {
            \core_courseformat\formatactions::cm($course->id)->delete($page->cmid, false);
        } else {
            course_delete_module($page->cmid, false);
        }
        $this->assertSame([], repository::get_source_ids($first->id));
        $this->assertSame(1, (int)$DB->get_field('completionaggregator', 'requiredcount', ['id' => $first->id]));
        $this->assert_state($first->cmid, $user->id, COMPLETION_INCOMPLETE);
        $this->assert_state($second->cmid, $user->id, COMPLETION_INCOMPLETE);
    }

    public function test_edit_rejects_dependency_cycle_without_changing_sources(): void {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/mod/completionaggregator/lib.php');
        $this->resetAfterTest();
        [, , $page, $first, $second] = $this->create_chain();
        $data = $DB->get_record('completionaggregator', ['id' => $first->id], '*', MUST_EXIST);
        $data->instance = $first->id;
        $data->coursemodule = $first->cmid;
        $data->sourcecmids = [$second->cmid];
        try {
            completionaggregator_update_instance($data);
            $this->fail('A dependency cycle must be rejected.');
        } catch (\moodle_exception $exception) {
            $this->assertSame('errorinvalidsource', $exception->errorcode);
        }
        $this->assertSame([(int)$page->cmid], repository::get_source_ids($first->id));
    }

    private function create_chain(): array {
        $this->setAdminUser();
        $generator = $this->getDataGenerator();
        $course = $generator->create_course(['enablecompletion' => 1]);
        $user = $generator->create_and_enrol($course, 'student');
        $page = $generator->create_module('page', ['course' => $course->id],
            ['completion' => COMPLETION_TRACKING_MANUAL]);
        $first = $generator->create_module('completionaggregator',
            ['course' => $course->id, 'requiredcount' => 1, 'sourcecmids' => [$page->cmid]],
            ['completion' => COMPLETION_TRACKING_AUTOMATIC]);
        $second = $generator->create_module('completionaggregator',
            ['course' => $course->id, 'requiredcount' => 1, 'sourcecmids' => [$first->cmid]],
            ['completion' => COMPLETION_TRACKING_AUTOMATIC]);
        return [$course, $user, $page, $first, $second];
    }

    private function assert_state(int $cmid, int $userid, int $expected): void {
        global $DB;
        $this->assertSame($expected, (int)$DB->get_field('course_modules_completion', 'completionstate',
            ['coursemoduleid' => $cmid, 'userid' => $userid]));
    }
}
