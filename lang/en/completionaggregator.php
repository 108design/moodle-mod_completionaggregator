<?php
/**
 * File documentation for lang/en/completionaggregator.php.
 *
 * @package   mod_completionaggregator
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license   See LICENSE.md for the full terms.
 */
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

$string['pluginname'] = 'Completion Aggregator';
$string['modulename'] = 'Completion Aggregator';
$string['modulenameplural'] = 'Completion Aggregators';
$string['modulename_help'] = 'A logical activity that completes when a configured number of source activities meet their completion condition.';
$string['completionaggregator:addinstance'] = 'Add a Completion Aggregator';
$string['completionaggregator:view'] = 'View Completion Aggregator';
$string['completionaggregator:manage'] = 'Manage Completion Aggregator';
$string['completionaggregatorname'] = 'Name';
$string['aggregationrule'] = 'Aggregation Rule';
$string['sourceactivities'] = 'Source Activities';
$string['sourceactivities_help'] = 'Activities in this course whose completion states are evaluated. Only activities with completion tracking enabled are listed.';
$string['requiredcount'] = 'Required Number';
$string['conditiontype'] = 'Condition';
$string['conditioncomplete'] = 'Activity Is Complete';
$string['conditionpass'] = 'Activity Is Complete and Passed';
$string['completionthreshold'] = 'Complete When the Aggregation Threshold Is Met';
$string['rulecomplete'] = 'At least {$a->required} of {$a->total} selected activities must be complete';
$string['rulepass'] = 'At least {$a->required} of {$a->total} selected activities must be complete and passed';
$string['errornosources'] = 'Select at least one source activity.';
$string['errorrequiredminimum'] = 'The required number must be at least 1.';
$string['errorrequiredmaximum'] = 'The required number cannot exceed the number of selected activities.';
$string['errorinvalidsource'] = 'One or more source activities are invalid, belong to another course, or do not track completion.';
$string['errorcycle'] = 'This selection would create a circular Completion Aggregator dependency.';
$string['invalidconfiguration'] = 'Invalid configuration: the required number exceeds the remaining number of sources.';
$string['sources'] = 'Sources';
$string['currentresult'] = 'Current result';
$string['satisfied'] = '{$a->satisfied} of {$a->total} currently satisfy the condition.';
$string['privacy:metadata'] = 'The Completion Aggregator stores configuration only and does not store personal data.';


// Contextual activity and configuration help.
$string['activityhelp'] = 'Activity Help';
$string['adminhelpmore'] = 'More in the help panel';
$string['adminhelptopics'] = 'Help Topics';
$string['requiredcount_help'] = 'The minimum number of selected source activities that must meet the condition. Enter a value from 1 to the number of selected sources.';
$string['conditiontype_help'] = 'Choose whether completion alone counts, or whether the source must be complete with a passing result.';
$string['completionthreshold_help'] = 'Use automatic activity completion and keep this condition enabled to calculate the milestone from its selected source activities.';
$string['adminhelp_overview'] = 'Understanding the Milestone';
$string['adminhelp_overview_article'] = '<p>The rule above the source list shows how many selected activities must meet the configured condition. Viewing this page does not itself complete the milestone.</p><p><strong>Sources</strong> shows only activities available to you. The rule evaluates the configured sources; a hidden or restricted activity can therefore count without appearing in your list.</p><p>Access to this page has its own permission. By default it is available to teaching and managing roles; learners can receive the calculated completion state without being able to open this page.</p>';
$string['adminhelp_setup'] = 'Configuring a Milestone';
$string['adminhelp_setup_article'] = '<p>Enable completion tracking in the course and configure completion for the source activities. Select them under <strong>Source Activities</strong>, enter the <strong>Required Number</strong> and choose the <strong>Condition</strong>.</p><p>Under the native completion settings, select automatic completion and enable <strong>Complete When the Aggregation Threshold Is Met</strong>. Saving an existing activity resets and recalculates its completion states, so check the result after changing its settings.</p>';
$string['adminhelp_selection'] = 'Selecting Source Activities';
$string['adminhelp_selection_article'] = '<p><strong>Source Activities</strong> lists activities in the current course with completion tracking enabled. Select one or more entries; the current aggregator cannot select itself.</p><p>You can select another aggregator to build a chain. Saving rejects a selection that would create a circular dependency. Selections from another course or without completion tracking are also rejected.</p>';
$string['adminhelp_threshold'] = 'Required Number';
$string['adminhelp_threshold_article'] = '<p><strong>Required Number</strong> is an “at least” threshold. For example, select five activities and enter 3 to require any three of them to meet the chosen condition.</p><p>The value must be at least 1 and cannot exceed the selected source count. Deleting a source does not lower the threshold automatically; review the remaining sources and required number.</p>';
$string['adminhelp_conditions'] = 'Completion Conditions';
$string['adminhelp_conditions_article'] = '<p><strong>Activity Is Complete</strong> counts every completed state, including a completed activity with a failing result.</p><p><strong>Activity Is Complete and Passed</strong> counts only the native complete-and-passed state. A source that merely records completion without a passing state does not satisfy this condition.</p>';
$string['adminhelp_completion'] = 'Automatic Milestone Completion';
$string['adminhelp_completion_article'] = '<p><strong>Complete When the Aggregation Threshold Is Met</strong> is the custom condition for automatic activity completion. Enable course completion tracking, select automatic completion for this activity and keep this condition checked.</p><p>Source completion changes trigger recalculation. If a source no longer meets the condition, the milestone can return to incomplete. The milestone can be used as a completion requirement elsewhere in the course even when learners cannot open its detail page.</p>';
$string['adminhelp_maintenance'] = 'Maintaining Sources and Rules';
$string['adminhelp_maintenance_article'] = '<p>After deleting a source, check <strong>Source Activities</strong> and <strong>Required Number</strong>. The deleted relation is removed, while the threshold stays unchanged. A threshold above the remaining source count is flagged on the activity page.</p><p>Course backup and restore reconnect sources included in the restored course. If sources are omitted, review the restored selection and threshold. Saving an existing activity resets and recalculates its completion states.</p>';
$string['overview_help'] = 'Read the configured rule and the sources available to you. Viewing this page does not complete the milestone.';
$string['setup_help'] = 'Select tracked sources, a threshold and a condition, then enable automatic completion with the aggregation rule.';
$string['selection_help'] = 'Select tracked activities from this course. Self-selection and circular aggregator chains are rejected.';
$string['threshold_help'] = 'The threshold means at least this many selected sources. Deleting a source does not lower the number automatically.';
$string['conditions_help'] = 'Completion alone includes completed failures. Complete and passed requires the native passing completion state.';
$string['completion_help'] = 'Keep the aggregation condition enabled under automatic completion. Source changes can complete or reverse the milestone.';
$string['maintenance_help'] = 'Review source selections and threshold after deletions or partial course restores.';
$string['overview'] = $string['adminhelp_overview'];
$string['setup'] = $string['adminhelp_setup'];
$string['selection'] = $string['adminhelp_selection'];
$string['threshold'] = $string['adminhelp_threshold'];
$string['conditions'] = $string['adminhelp_conditions'];
$string['completion'] = $string['adminhelp_completion'];
$string['maintenance'] = $string['adminhelp_maintenance'];
