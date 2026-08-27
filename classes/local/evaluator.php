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

final class evaluator {
    public static function count_satisfied(\stdClass $instance, int $userid): array {
        global $DB;
        $sourceids = repository::get_source_ids((int)$instance->id);
        if (!$sourceids || (int)$instance->requiredcount < 1 || (int)$instance->requiredcount > count($sourceids)) {
            return [0, count($sourceids), false];
        }
        [$insql, $params] = $DB->get_in_or_equal($sourceids, SQL_PARAMS_NAMED, 'cm');
        $params['userid'] = $userid;
        $states = $DB->get_records_sql_menu(
            "SELECT cm.id, COALESCE(cmc.completionstate, 0)
               FROM {course_modules} cm
          LEFT JOIN {course_modules_completion} cmc ON cmc.coursemoduleid = cm.id AND cmc.userid = :userid
              WHERE cm.id $insql AND cm.deletioninprogress = 0", $params);
        $satisfied = 0;
        foreach ($sourceids as $cmid) {
            $state = (int)($states[$cmid] ?? COMPLETION_INCOMPLETE);
            $matches = $instance->conditiontype === constants::CONDITION_PASS
                ? $state === COMPLETION_COMPLETE_PASS
                : $state !== COMPLETION_INCOMPLETE;
            if ($matches) {
                $satisfied++;
            }
        }
        return [$satisfied, count($sourceids), $satisfied >= (int)$instance->requiredcount];
    }
}

