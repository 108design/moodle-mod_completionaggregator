<?php
/**
 * This file is part of a 108design source-available software product.
 *
 * Use and modification are permitted only under the Software License included
 * with this distribution. See LICENSE.md for the full terms.
 *
 */
// Copyright (C) 2026 Andreas Giesen. See LICENSE.md for the full terms.
namespace mod_completionaggregator;

defined('MOODLE_INTERNAL') || die();

/**
 * Native view logging follows the activity's existing access boundary.
 *
 * @package mod_completionaggregator
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license See LICENSE.md for the full terms.
 */
final class view_event_test extends \advanced_testcase {
    /** Record the view in the correct native context with usable snapshots and URL. */
    public function test_authorised_activity_view_emits_native_event(): void {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/mod/completionaggregator/lib.php');
        $this->resetAfterTest();
        $this->setAdminUser();
        $course = $this->getDataGenerator()->create_course(['enablecompletion' => 1]);
        $page = $this->getDataGenerator()->create_module('page', ['course' => $course->id,
            'completion' => COMPLETION_TRACKING_MANUAL]);
        $activity = $this->getDataGenerator()->create_module('completionaggregator', ['course' => $course->id,
            'sourcecmids' => [$page->cmid], 'requiredcount' => 1]);
        $instance = $DB->get_record('completionaggregator', ['id' => $activity->id], '*', MUST_EXIST);
        $cm = get_coursemodule_from_id('completionaggregator', $activity->cmid, 0, false, MUST_EXIST);
        $context = \context_module::instance($cm->id);
        $sink = $this->redirectEvents();
        \completionaggregator_view($instance, $course, $cm, $context);
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);
        $this->assertInstanceOf(\mod_completionaggregator\event\course_module_viewed::class, $event);
        $this->assertEquals($instance->id, $event->objectid);
        $this->assertEquals($context->id, $event->contextid);
        $this->assertEquals($course->id, $event->courseid);
        $this->assertEquals($instance, $event->get_record_snapshot('completionaggregator', $instance->id));
        $this->assertSame((new \moodle_url('/mod/completionaggregator/view.php', ['id' => $cm->id]))->out(false),
            $event->get_url()->out(false));
    }

    /** A denied viewer must not create a misleading activity-view record. */
    public function test_denied_viewer_emits_no_event(): void {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/mod/completionaggregator/lib.php');
        $this->resetAfterTest();
        $this->setAdminUser();
        $course = $this->getDataGenerator()->create_course(['enablecompletion' => 1]);
        $page = $this->getDataGenerator()->create_module('page', ['course' => $course->id,
            'completion' => COMPLETION_TRACKING_MANUAL]);
        $activity = $this->getDataGenerator()->create_module('completionaggregator', ['course' => $course->id,
            'sourcecmids' => [$page->cmid], 'requiredcount' => 1]);
        $instance = $DB->get_record('completionaggregator', ['id' => $activity->id], '*', MUST_EXIST);
        $cm = get_coursemodule_from_id('completionaggregator', $activity->cmid, 0, false, MUST_EXIST);
        $context = \context_module::instance($cm->id);
        $user = $this->getDataGenerator()->create_user();
        $roleid = $DB->get_field('role', 'id', ['shortname' => 'student'], MUST_EXIST);
        $this->getDataGenerator()->enrol_user($user->id, $course->id, $roleid);
        assign_capability('mod/completionaggregator:view', CAP_PROHIBIT, $roleid, $context);
        $this->setUser($user);
        $sink = $this->redirectEvents();
        try {
            \completionaggregator_view($instance, $course, $cm, $context);
            $this->fail('The existing view capability is required.');
        } catch (\required_capability_exception $exception) {
            $this->assertSame([], $sink->get_events());
        }
    }
}
