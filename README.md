# Completion Aggregator for Moodle

Combine several activity-completion requirements into one course milestone.
Completion Aggregator completes automatically when a chosen number of selected
activities meet your required completion state.

## Installation

Completion Aggregator requires Moodle 4.5 or later. Install as `mod/completionaggregator`
below Moodle's plugin directory and complete installation through
**Site administration → Notifications**. For Moodle installations using the split
web directory, use `public/mod/completionaggregator`.

## Configuring a milestone

1. Enable activity completion in the course and configure the source activities.
2. Add a **Completion Aggregator** activity.
3. Select the activities whose completion should count.
4. Set the minimum number that must qualify and choose **Complete** or
   **Complete and passed** as the required source state.
5. Save the activity. Completion is recalculated when the source activities change.

For example, select five practice activities and require any three to be complete.
The aggregator can then be used as a single completion requirement elsewhere in
the course. Circular dependencies are rejected when configuring the activity.

## Maintaining the course

If you delete a source activity, review the aggregator's selected sources and
threshold: the required number is not reduced automatically. Course backup and
restore preserve references to source activities that are available in the restored
course; review the settings if some sources were omitted.

## License

This is a 108design source-available commercial software license, not an open-source license. See [LICENSE.md](https://github.com/108design/moodle-mod_completionaggregator/blob/main/LICENSE.md) for the full terms.
