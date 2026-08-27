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

See [the 108design Completion Aggregator Software License](LICENSE.md).
