# Completion Aggregator

Moodle activity module for calculating automatic completion from a configurable
threshold of other activity-completion states. Supports Moodle 4.5 and later
compatible releases. Release metadata is in `version.php`.

Install this repository's contents as `mod/completionaggregator` below Moodle's
plugin webroot, then run Moodle's normal upgrade process. Moodle 5.1 and newer
normally use `public/mod/completionaggregator`.

Source relations are normalized, recalculation responds to completion events,
cyclic dependencies are rejected, and backup/restore remaps activity references.

## License

This is a 108design source-available commercial software license, not an open-source license. See [LICENSE.md](https://github.com/108design/moodle-mod_completionaggregator/blob/main/LICENSE.md) for the full terms.
