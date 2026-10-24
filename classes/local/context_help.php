<?php
/**
 * This file is part of a 108design source-available software product.
 *
 * Use and modification are permitted only under the Software License included
 * with this distribution. See LICENSE.md for the full terms.
 *
 * File documentation for classes/local/context_help.php.
 *
 * @package   mod_completionaggregator
 * @copyright 2026 Andreas Giesen
 * @license   See LICENSE.md for the full terms.
 */
// Copyright (C) 2026 Andreas Giesen. See LICENSE.md.
namespace mod_completionaggregator\local;

defined('MOODLE_INTERNAL') || die();

/** Contextual settings help, following the standalone Frontpage panel contract. */
final class context_help {
    private const TOPICS = ['overview', 'setup', 'selection', 'threshold', 'conditions', 'completion', 'maintenance'];
    private static array $topics = ['overview'];
    private static bool $activitysettings = false;
    private static bool $prepared = false;

    /** Called only by this component's native activity form. */
    public static function register_activity_settings(): void {
        self::$activitysettings = true;
    }

    /** Carry an exact-topic icon to its native control without HTML in AMD arguments. */
    public static function field_icon(string $field, string $topic): string {
        return \html_writer::span(self::icon($topic), '', ['data-aggregator-help-field' => $field]);
    }

    /** Scope help to an authorised activity view or this component's native edit form. */
    public static function prepare(\core\hook\output\before_http_headers $hook): void {
        global $CFG, $PAGE;
        if (self::$prepared || !isloggedin() || isguestuser()) {
            return;
        }
        $view = (int)$PAGE->context->contextlevel === CONTEXT_MODULE
            && $PAGE->url->get_path() === (new \moodle_url('/mod/completionaggregator/view.php'))->get_path()
            && has_capability('mod/completionaggregator:view', $PAGE->context);
        $settings = self::$activitysettings
            && $PAGE->url->get_path() === (new \moodle_url('/course/modedit.php'))->get_path()
            && has_capability('moodle/course:manageactivities', $PAGE->context);
        if (!$view && !$settings) {
            return;
        }
        self::$topics = $settings ? array_slice(self::TOPICS, 1) : ['overview'];
        if ($view && has_capability('moodle/course:manageactivities', $PAGE->context)) {
            self::$topics = self::TOPICS;
        }
        $PAGE->add_body_class('mod-completionaggregator-admin-help-page');
        self::$prepared = true;
        $PAGE->requires->css(new \moodle_url('/mod/completionaggregator/styles/context_help.css', [
            'rev' => get_config('mod_completionaggregator', 'version'),
            'theme' => theme_get_revision(),
        ]));
        $module = (int)$CFG->version < 2025041400 ? 'context_help_legacy' : 'context_help';
        $PAGE->requires->js_call_amd('mod_completionaggregator/context_help_form', 'init');
        $PAGE->requires->js_call_amd('mod_completionaggregator/' . $module, 'init', [[
            'topic' => optional_param('aggregatorhelp', '', PARAM_ALPHA),
        ]]);
    }

    /** Native popover with concise guidance and a direct link to the extended topic. */
    public static function icon(string $key): string {
        global $CFG, $PAGE;
        if (defined('CLI_SCRIPT') && CLI_SCRIPT) {
            return '';
        }
        if (!in_array($key, self::TOPICS, true)) {
            throw new \coding_exception('Unknown Administration help topic.');
        }
        $url = new \moodle_url($PAGE->url);
        $url->param('aggregatorhelp', $key);
        $help = new \help_icon($key, 'mod_completionaggregator', $url->out(false));
        $renderer = $PAGE->get_renderer('core');
        $data = (array)$help->export_for_template($renderer);
        $data['completedoclink'] = \html_writer::link($url, get_string('adminhelpmore', 'mod_completionaggregator'));
        $data['legacy'] = (int)$CFG->version < 2025041400;
        $data['infoicon'] = (int)$CFG->version < 2026100500 ? 'i/info' : 'i/circleinfo';
        return $renderer->render_from_template('mod_completionaggregator/settings_help_icon', $data);
    }

    /** Always available in the native Topnav user area on the registered page. */
    public static function navbar(\renderer_base $renderer): string {
        global $CFG;
        if (!self::$prepared) {
            return '';
        }
        $label = get_string('activityhelp', 'mod_completionaggregator');
        return \html_writer::tag('button', $renderer->pix_icon(
            (int)$CFG->version < 2026100500 ? 'i/info' : 'i/circleinfo', ''), [
                'type' => 'button', 'class' => 'nav-link icon-no-margin mod-completionaggregator-help-navbar',
                'data-aggregator-help-open' => '', 'aria-label' => $label, 'title' => $label,
                'aria-controls' => 'mod-completionaggregator-context-help', 'aria-expanded' => 'false',
            ]);
    }

    /** Same header, topic chooser and article layout as the Frontpage reference. */
    public static function render(): string {
        global $PAGE;
        if (!self::$prepared) {
            return '';
        }
        $title = get_string('activityhelp', 'mod_completionaggregator');
        $close = \html_writer::tag('button', \html_writer::span('&#215;', '', ['aria-hidden' => 'true']), [
            'type' => 'button', 'class' => 'btn btn-secondary btn-sm mod-completionaggregator-help-close',
            'aria-label' => get_string('closebuttontitle', 'moodle'), 'data-aggregator-help-close' => '1',
        ]);
        $options = '';
        $articles = '';
        foreach (self::$topics as $topic) {
            $label = get_string('adminhelp_' . $topic, 'mod_completionaggregator');
            $options .= \html_writer::tag('option', $label, ['value' => $topic]);
            $articles .= \html_writer::tag('article', \html_writer::tag('h3', $label, ['class' => 'h5', 'tabindex' => '-1'])
                . get_string('adminhelp_' . $topic . '_article', 'mod_completionaggregator'), [
                    'data-aggregator-help-article' => $topic, 'hidden' => 'hidden',
                ]);
        }
        $choice = \html_writer::tag('label', get_string('adminhelptopics', 'mod_completionaggregator'), [
            'for' => 'mod-completionaggregator-help-topic', 'class' => 'form-label',
        ]) . \html_writer::tag('select', $options, [
            'id' => 'mod-completionaggregator-help-topic', 'class' => 'form-select custom-select',
        ]);
        // Shared help-panel identity: no link or action; close remains beside the topic selector.
        $brand = \html_writer::tag('span', \html_writer::empty_tag('img', [
            'src' => $PAGE->get_renderer('core')->image_url('helpbrand', 'mod_completionaggregator')->out(false),
            'alt' => '', 'width' => 25, 'height' => 24,
        ]), [
            'class' => 'mod-completionaggregator-help-brand', 'role' => 'img', 'aria-label' => '108design',
            'title' => '108design', 'tabindex' => '0', 'data-toggle' => 'tooltip', 'data-bs-toggle' => 'tooltip',
        ]);
        $header = \html_writer::tag('header', \html_writer::tag('h2', $title, [
            'id' => 'mod-completionaggregator-context-help-title', 'class' => 'sr-only visually-hidden', 'tabindex' => '-1',
        ]) . \html_writer::div($choice, 'mod-completionaggregator-help-choices') . $brand . $close,
            ['class' => 'mod-completionaggregator-help-header mod-completionaggregator-help-header-branded']);
        return \html_writer::tag('aside', $header
            . \html_writer::div($articles, 'mod-completionaggregator-help-content', ['tabindex' => '0']), [
                'id' => 'mod-completionaggregator-context-help', 'class' => 'mod-completionaggregator-context-help',
                'aria-labelledby' => 'mod-completionaggregator-context-help-title', 'hidden' => 'hidden',
                'data-aggregator-help-url' => $PAGE->url->out(false),
            ]);
    }

    /** Append the registered panel without changing the page's controls. */
    public static function footer(\core\hook\output\before_standard_footer_html_generation $hook): void {
        $hook->add_html(self::render());
    }
}
