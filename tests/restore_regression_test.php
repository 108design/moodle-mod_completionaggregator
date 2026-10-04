<?php
// This file is part of a 108design source-available software product.
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
// See LICENSE.md for the full terms.

namespace mod_completionaggregator;

use mod_completionaggregator\local\repository;

defined('MOODLE_INTERNAL') || die();

/** Native backup/import must preserve source order regardless of restore order. */
final class restore_regression_test extends \advanced_testcase {
    public function test_course_import_keeps_sources_restored_after_aggregator(): void {
        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();
        $course = $this->getDataGenerator()->create_course(['enablecompletion' => 1]);
        $before = $this->getDataGenerator()->create_module('page', ['course' => $course->id, 'name' => 'Before'],
            ['completion' => COMPLETION_TRACKING_MANUAL]);
        $aggregator = $this->getDataGenerator()->create_module('completionaggregator',
            ['course' => $course->id, 'name' => 'Aggregate', 'requiredcount' => 1, 'sourcecmids' => [$before->cmid]],
            ['completion' => COMPLETION_TRACKING_AUTOMATIC]);
        $after = $this->getDataGenerator()->create_module('page', ['course' => $course->id, 'name' => 'After'],
            ['completion' => COMPLETION_TRACKING_MANUAL]);
        repository::replace_sources($aggregator->id, [$after->cmid, $before->cmid]);
        $DB->set_field('completionaggregator', 'requiredcount', 2, ['id' => $aggregator->id]);
        $target = $this->import($course->id);
        $restored = $DB->get_record('completionaggregator', ['course' => $target->id, 'name' => 'Aggregate'], '*', MUST_EXIST);
        $newbefore = $DB->get_record('page', ['course' => $target->id, 'name' => 'Before'], '*', MUST_EXIST);
        $newafter = $DB->get_record('page', ['course' => $target->id, 'name' => 'After'], '*', MUST_EXIST);
        $beforecm = get_coursemodule_from_instance('page', $newbefore->id);
        $aftercm = get_coursemodule_from_instance('page', $newafter->id);
        $this->assertSame([(int)$aftercm->id, (int)$beforecm->id], repository::get_source_ids($restored->id));
        $this->assertSame(2, (int)$restored->requiredcount);
        $this->assertSame([(int)$after->cmid, (int)$before->cmid], repository::get_source_ids($aggregator->id));
    }

    public function test_activity_import_omits_sources_not_in_backup(): void {
        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();
        $course = $this->getDataGenerator()->create_course(['enablecompletion' => 1]);
        $page = $this->getDataGenerator()->create_module('page', ['course' => $course->id],
            ['completion' => COMPLETION_TRACKING_MANUAL]);
        $aggregator = $this->getDataGenerator()->create_module('completionaggregator',
            ['course' => $course->id, 'name' => 'Aggregate', 'requiredcount' => 1, 'sourcecmids' => [$page->cmid]],
            ['completion' => COMPLETION_TRACKING_AUTOMATIC]);
        $target = $this->import($course->id, $aggregator->cmid);
        $restored = $DB->get_record('completionaggregator', ['course' => $target->id], '*', MUST_EXIST);
        $this->assertSame([], repository::get_source_ids($restored->id));
        $this->assertSame(1, (int)$restored->requiredcount);
        $this->assertSame([(int)$page->cmid], repository::get_source_ids($aggregator->id));
    }

    private function import(int $courseid, int $cmid = 0): \stdClass {
        global $CFG, $USER;
        require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
        require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');
        $backup = new \backup_controller($cmid ? \backup::TYPE_1ACTIVITY : \backup::TYPE_1COURSE,
            $cmid ?: $courseid, \backup::FORMAT_MOODLE, \backup::INTERACTIVE_NO, \backup::MODE_IMPORT, $USER->id);
        $backupid = $backup->get_backupid();
        $backup->execute_plan(); $backup->destroy();
        $target = $this->getDataGenerator()->create_course(['enablecompletion' => 1]);
        $restore = new \restore_controller($backupid, $target->id, \backup::INTERACTIVE_NO,
            \backup::MODE_IMPORT, $USER->id, \backup::TARGET_CURRENT_ADDING);
        $precheck = $restore->execute_precheck();
        $this->assertTrue($precheck, 'Native restore precheck failed');
        $restore->execute_plan(); $restore->destroy();
        return $target;
    }
}
