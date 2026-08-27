<?php
// This file is part of a 108design source-available software product.
//
// Copyright (C) 2026 Andreas Giesen <andreas@108design.com>
//
// Use and modification are permitted only under the Software License included
// with this distribution. Redistribution and circumvention of Pro feature or
// licensing restrictions are prohibited. See LICENSE.md for the full terms.

$string['pluginname'] = 'Abschluss-Aggregator';
$string['modulename'] = 'Abschluss-Aggregator';
$string['modulenameplural'] = 'Abschluss-Aggregatoren';
$string['modulename_help'] = 'Eine logische Aktivität, die abgeschlossen wird, sobald genügend Quellaktivitäten die konfigurierte Abschlussbedingung erfüllen.';
$string['completionaggregator:addinstance'] = 'Abschluss-Aggregator hinzufügen';
$string['completionaggregator:view'] = 'Abschluss-Aggregator anzeigen';
$string['completionaggregator:manage'] = 'Abschluss-Aggregator verwalten';
$string['completionaggregatorname'] = 'Name';
$string['aggregationrule'] = 'Aggregationsregel';
$string['sourceactivities'] = 'Quellaktivitäten';
$string['sourceactivities_help'] = 'Ausgewertet werden Aktivitäten dieses Kurses mit aktivierter Abschlussverfolgung.';
$string['requiredcount'] = 'Erforderliche Anzahl';
$string['conditiontype'] = 'Bedingung';
$string['conditioncomplete'] = 'Aktivität ist abgeschlossen';
$string['conditionpass'] = 'Aktivität ist abgeschlossen und bestanden';
$string['completionthreshold'] = 'Abschließen, wenn der Schwellenwert erreicht ist';
$string['rulecomplete'] = 'Mindestens {$a->required} von {$a->total} ausgewählten Aktivitäten müssen abgeschlossen sein';
$string['rulepass'] = 'Mindestens {$a->required} von {$a->total} ausgewählten Aktivitäten müssen abgeschlossen und bestanden sein';
$string['errornosources'] = 'Wählen Sie mindestens eine Quellaktivität aus.';
$string['errorrequiredminimum'] = 'Die erforderliche Anzahl muss mindestens 1 sein.';
$string['errorrequiredmaximum'] = 'Die erforderliche Anzahl darf die Zahl der gewählten Aktivitäten nicht überschreiten.';
$string['errorinvalidsource'] = 'Mindestens eine Quelle ist ungültig, gehört zu einem anderen Kurs oder verwendet keine Abschlussverfolgung.';
$string['errorcycle'] = 'Diese Auswahl würde eine zirkuläre Abhängigkeit zwischen Abschluss-Aggregatoren erzeugen.';
$string['invalidconfiguration'] = 'Ungültige Konfiguration: Die erforderliche Anzahl ist größer als die Zahl der verbliebenen Quellen.';
$string['sources'] = 'Quellen';
$string['currentresult'] = 'Aktueller Stand';
$string['satisfied'] = '{$a->satisfied} von {$a->total} erfüllen derzeit die Bedingung.';
$string['privacy:metadata'] = 'Der Abschluss-Aggregator speichert nur Konfiguration und keine personenbezogenen Daten.';

