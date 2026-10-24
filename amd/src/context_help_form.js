/**
 * This file is part of a 108design source-available software product.
 *
 * Use and modification are permitted only under the Software License included
 * with this distribution. See LICENSE.md for the full terms.
 *
 * File documentation for amd/src/context_help_form.js.
 *
 * @package   mod_completionaggregator
 * @copyright 2026 Andreas Giesen
 * @license   See LICENSE.md for the full terms.
 */
// Copyright (C) 2026 Andreas Giesen. See LICENSE.md.

/** Align help in our registered forms without changing fields or their values. */
export const init = () => {
    const navigation = document.querySelector('#usernavigation');
    const alignNavbarHelp = () => {
        if (!navigation) return;
        const help = navigation.querySelector('.mod-completionaggregator-help-navbar');
        const children = [...navigation.children];
        const userMenu = children.find(node => node.matches('[data-region="usermenu"], .usermenu-container'));
        const userIndex = userMenu ? children.indexOf(userMenu) : children.length;
        // Older Moodle places its divider after the user menu, outside the help insertion area.
        const anchor = children.find((node, index) => index < userIndex &&
            node.classList.contains('divider')) || userMenu;
        if (help && anchor && (help.parentElement !== navigation || help.nextElementSibling !== anchor)) {
            navigation.insertBefore(help, anchor);
        }
    };
    // Navbar callbacks can finish in any order; keep help immediately before the user-area divider.
    alignNavbarHelp();
    if (navigation) new MutationObserver(alignNavbarHelp).observe(navigation, {childList: true});

    document.querySelectorAll('[data-aggregator-help-field]').forEach(holder => {
        const name = holder.dataset.aggregatorHelpField;
        const field = document.getElementById('id_' + name);
        const item = field?.closest('.fitem');
        const element = item?.querySelector('.felement, .checkbox');
        const icon = holder.querySelector('.mod-completionaggregator-context-help-icon');
        if (!field || !element || !icon || element.querySelector('.mod-completionaggregator-field-control')) return;
        const row = document.createElement('div');
        row.className = 'mod-completionaggregator-field-control';
        if (name === 'sourcecmids') row.classList.add('mod-completionaggregator-field-control-wide');
        // Move the whole native autocomplete/control group, keeping all generated fields and errors together.
        const group = document.createElement('div');
        group.className = 'mod-completionaggregator-field-input';
        [...element.childNodes].forEach(node => group.append(node));
        row.append(group, icon);
        element.append(row);
        holder.remove();
        const question = group.querySelector('.help-icon:not(.mod-completionaggregator-context-help-icon)');
        const label = item.querySelector(':scope > .col-form-label');
        if (question && label?.querySelector('label')?.textContent.trim()) {
            let addon = label.querySelector('.form-label-addon');
            if (!addon) {
                addon = document.createElement('span');
                addon.className = 'form-label-addon d-flex align-items-center align-self-start';
                label.append(addon);
            }
            addon.append(question);
        }
    });
};
