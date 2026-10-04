<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

namespace mod_completionaggregator\local;

defined('MOODLE_INTERNAL') || die();

final class repository {
    public static function get_source_ids(int $aggregatorid): array {
        global $DB;
        return array_map('intval', array_values($DB->get_fieldset_sql(
            'SELECT cmid FROM {completionaggregator_sources} WHERE aggregatorid = :id ORDER BY sortorder, id',
            ['id' => $aggregatorid]
        )));
    }

    public static function replace_sources(int $aggregatorid, array $cmids): void {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $DB->delete_records('completionaggregator_sources', ['aggregatorid' => $aggregatorid]);
        foreach (array_values(array_unique(array_map('intval', $cmids))) as $sortorder => $cmid) {
            $DB->insert_record('completionaggregator_sources', (object)[
                'aggregatorid' => $aggregatorid, 'cmid' => $cmid, 'sortorder' => $sortorder,
            ]);
        }
        $transaction->allow_commit();
    }

    public static function get_dependants(int $cmid): array {
        global $DB;
        $sql = "SELECT ca.* FROM {completionaggregator} ca
                  JOIN {completionaggregator_sources} cas ON cas.aggregatorid = ca.id
                 WHERE cas.cmid = :cmid";
        return $DB->get_records_sql($sql, ['cmid' => $cmid]);
    }

    public static function validate_sources(int $courseid, array $cmids, int $selfcmid = 0): bool {
        global $DB;
        $cmids = array_values(array_unique(array_map('intval', $cmids)));
        if (!$cmids || ($selfcmid && in_array($selfcmid, $cmids, true))) {
            return false;
        }
        [$insql, $params] = $DB->get_in_or_equal($cmids, SQL_PARAMS_NAMED, 'src');
        $params['courseid'] = $courseid;
        $sql = "SELECT id FROM {course_modules} WHERE id $insql AND course = :courseid AND deletioninprogress = 0
                  AND completion <> :completionnone";
        $params['completionnone'] = COMPLETION_TRACKING_NONE;
        return count($DB->get_fieldset_sql($sql, $params)) === count($cmids);
    }

    public static function introduces_cycle(int $aggregatorid, array $proposedsources): bool {
        if (!$aggregatorid) {
            return false;
        }
        global $DB;
        $targetcmid = (int)$DB->get_field('course_modules', 'id',
            ['module' => $DB->get_field('modules', 'id', ['name' => 'completionaggregator']), 'instance' => $aggregatorid]);
        if (!$targetcmid) {
            return false;
        }
        $stack = array_values(array_unique(array_map('intval', $proposedsources)));
        $seen = [];
        while ($stack) {
            $cmid = array_pop($stack);
            if ($cmid === $targetcmid) {
                return true;
            }
            if (isset($seen[$cmid])) {
                continue;
            }
            $seen[$cmid] = true;
            $sql = "SELECT cas.cmid FROM {course_modules} cm
                      JOIN {modules} m ON m.id = cm.module AND m.name = 'completionaggregator'
                      JOIN {completionaggregator_sources} cas ON cas.aggregatorid = cm.instance
                     WHERE cm.id = :cmid";
            foreach ($DB->get_fieldset_sql($sql, ['cmid' => $cmid]) as $next) {
                $stack[] = (int)$next;
            }
        }
        return false;
    }
}
