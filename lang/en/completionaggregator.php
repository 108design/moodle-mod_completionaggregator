<?php
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
$string['aggregationrule'] = 'Aggregation rule';
$string['sourceactivities'] = 'Source activities';
$string['sourceactivities_help'] = 'Activities in this course whose completion states are evaluated. Only activities with completion tracking enabled are listed.';
$string['requiredcount'] = 'Required number';
$string['conditiontype'] = 'Condition';
$string['conditioncomplete'] = 'Activity is complete';
$string['conditionpass'] = 'Activity is complete and passed';
$string['completionthreshold'] = 'Complete when the aggregation threshold is met';
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

