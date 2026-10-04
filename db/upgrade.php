<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

/**
 * Upgrade entry point for Completion Aggregator.
 *
 * @package    mod_completionaggregator
 * @copyright  2026 Andreas Giesen <andreas@108design.com>
 * @license    https://github.com/108design/moodle-mod_completionaggregator/blob/main/LICENSE.md 108design source-available license
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade an existing Completion Aggregator installation.
 *
 * @param int $oldversion The previously installed plugin version.
 * @return bool Whether the upgrade succeeded.
 */
function xmldb_completionaggregator_upgrade($oldversion): bool {
    // The database schema has not changed since the initial plugin release.
    return true;
}
