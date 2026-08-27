<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/course/moodleform_mod.php');

final class mod_completionaggregator_mod_form extends moodleform_mod {
    public function definition(): void {
        global $CFG;
        $mform = $this->_form;
        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'name', get_string('completionaggregatorname', 'completionaggregator'), ['size' => 64]);
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $this->standard_intro_elements();

        $mform->addElement('header', 'aggregationrule', get_string('aggregationrule', 'completionaggregator'));
        $options = $this->source_options();
        $mform->addElement('autocomplete', 'sourcecmids', get_string('sourceactivities', 'completionaggregator'), $options,
            ['multiple' => true]);
        $mform->addHelpButton('sourcecmids', 'sourceactivities', 'completionaggregator');
        $mform->setType('sourcecmids', PARAM_INT);
        $mform->addElement('text', 'requiredcount', get_string('requiredcount', 'completionaggregator'), ['size' => 5]);
        $mform->setType('requiredcount', PARAM_INT);
        $mform->setDefault('requiredcount', 1);
        $mform->addElement('select', 'conditiontype', get_string('conditiontype', 'completionaggregator'), [
            \mod_completionaggregator\local\constants::CONDITION_COMPLETE => get_string('conditioncomplete', 'completionaggregator'),
            \mod_completionaggregator\local\constants::CONDITION_PASS => get_string('conditionpass', 'completionaggregator'),
        ]);
        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
    }

    private function source_options(): array {
        $options = [];
        $modinfo = get_fast_modinfo($this->get_course());
        foreach ($modinfo->get_cms() as $cm) {
            if ($cm->deletioninprogress || $cm->completion == COMPLETION_TRACKING_NONE ||
                    ($this->_instance && $cm->modname === 'completionaggregator' && (int)$cm->instance === (int)$this->_instance)) {
                continue;
            }
            $options[$cm->id] = format_string($cm->name) . ' (' . get_string('pluginname', $cm->modname) . ')';
        }
        return $options;
    }

    public function data_preprocessing(&$defaultvalues): void {
        if ($this->_instance) {
            $defaultvalues['sourcecmids'] = \mod_completionaggregator\local\repository::get_source_ids((int)$this->_instance);
        }
    }

    public function add_completion_rules(): array {
        $name = \mod_completionaggregator\local\constants::RULE . $this->get_suffix();
        $this->_form->addElement('checkbox', $name, '', get_string('completionthreshold', 'completionaggregator'));
        $this->_form->setDefault($name, 1);
        return [$name];
    }

    public function completion_rule_enabled($data): bool {
        return !empty($data[\mod_completionaggregator\local\constants::RULE . $this->get_suffix()]);
    }

    public function validation($data, $files): array {
        $errors = parent::validation($data, $files);
        $sources = array_values(array_unique(array_map('intval', (array)($data['sourcecmids'] ?? []))));
        $required = (int)($data['requiredcount'] ?? 0);
        if (!$sources) {
            $errors['sourcecmids'] = get_string('errornosources', 'completionaggregator');
        } else if (!\mod_completionaggregator\local\repository::validate_sources((int)$data['course'], $sources, (int)($data['coursemodule'] ?? 0))) {
            $errors['sourcecmids'] = get_string('errorinvalidsource', 'completionaggregator');
        } else if ($this->_instance && \mod_completionaggregator\local\repository::introduces_cycle((int)$this->_instance, $sources)) {
            $errors['sourcecmids'] = get_string('errorcycle', 'completionaggregator');
        }
        if ($required < 1) {
            $errors['requiredcount'] = get_string('errorrequiredminimum', 'completionaggregator');
        } else if ($required > count($sources)) {
            $errors['requiredcount'] = get_string('errorrequiredmaximum', 'completionaggregator');
        }
        return $errors;
    }
}

