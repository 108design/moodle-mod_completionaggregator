<?php
/**
 * File documentation for lang/de/completionaggregator.php.
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
$string['completionthreshold'] = 'Abschließen, wenn die Aggregationsschwelle erreicht ist';
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


// Contextual activity and configuration help.
$string['activityhelp'] = 'Hilfe zur Aktivität';
$string['adminhelpmore'] = 'Mehr dazu im Hilfepanel';
$string['adminhelptopics'] = 'Hilfethemen';
$string['requiredcount_help'] = 'So viele ausgewählte Quellaktivitäten müssen die Bedingung mindestens erfüllen. Gib einen Wert von 1 bis zur Anzahl der ausgewählten Quellen an.';
$string['conditiontype_help'] = 'Wähle, ob ein Abschluss genügt oder ob die Quellaktivität abgeschlossen und bestanden sein muss.';
$string['completionthreshold_help'] = 'Verwende den automatischen Aktivitätsabschluss und lasse diese Bedingung aktiviert, damit der Meilenstein aus den ausgewählten Quellaktivitäten berechnet wird.';
$string['adminhelp_overview'] = 'Den Meilenstein verstehen';
$string['adminhelp_overview_article'] = '<p>Die Regel über der Quellliste zeigt, wie viele ausgewählte Aktivitäten die eingestellte Bedingung erfüllen müssen. Das Öffnen dieser Seite schließt den Meilenstein nicht ab.</p><p><strong>Quellen</strong> zeigt nur Aktivitäten, auf die Du zugreifen kannst. Die Regel wertet die konfigurierten Quellen aus; eine verborgene oder eingeschränkte Aktivität kann daher zählen, ohne in Deiner Liste zu erscheinen.</p><p>Für den Zugriff auf diese Seite gilt ein eigenes Recht. Standardmäßig steht sie Lehr- und Verwaltungsrollen zur Verfügung. Lernende können den berechneten Abschlussstatus erhalten, auch wenn sie diese Seite nicht öffnen dürfen.</p>';
$string['adminhelp_setup'] = 'Einen Meilenstein einrichten';
$string['adminhelp_setup_article'] = '<p>Aktiviere die Abschlussverfolgung im Kurs und richte den Abschluss der Quellaktivitäten ein. Wähle sie unter <strong>Quellaktivitäten</strong>, gib die <strong>Erforderliche Anzahl</strong> an und lege die <strong>Bedingung</strong> fest.</p><p>Wähle in den nativen Abschlusseinstellungen den automatischen Abschluss und aktiviere <strong>Abschließen, wenn die Aggregationsschwelle erreicht ist</strong>. Beim Speichern einer vorhandenen Aktivität werden ihre Abschlusszustände zurückgesetzt und neu berechnet. Prüfe daher nach Änderungen das Ergebnis.</p>';
$string['adminhelp_selection'] = 'Quellaktivitäten auswählen';
$string['adminhelp_selection_article'] = '<p><strong>Quellaktivitäten</strong> enthält Aktivitäten des aktuellen Kurses mit aktivierter Abschlussverfolgung. Wähle einen oder mehrere Einträge; der aktuelle Aggregator kann sich nicht selbst auswählen.</p><p>Du kannst einen anderen Aggregator auswählen und so eine Kette bilden. Eine Auswahl, die einen Kreisbezug erzeugen würde, wird beim Speichern abgewiesen. Quellen aus anderen Kursen oder ohne Abschlussverfolgung werden ebenfalls abgewiesen.</p>';
$string['adminhelp_threshold'] = 'Erforderliche Anzahl';
$string['adminhelp_threshold_article'] = '<p><strong>Erforderliche Anzahl</strong> ist eine Mindestschwelle. Wenn Du beispielsweise fünf Aktivitäten auswählst und 3 eingibst, müssen beliebige drei davon die gewählte Bedingung erfüllen.</p><p>Der Wert muss mindestens 1 sein und darf die Anzahl der ausgewählten Quellen nicht überschreiten. Das Löschen einer Quelle senkt die Schwelle nicht automatisch; prüfe danach die verbleibenden Quellen und die erforderliche Anzahl.</p>';
$string['adminhelp_conditions'] = 'Abschlussbedingungen';
$string['adminhelp_conditions_article'] = '<p><strong>Aktivität ist abgeschlossen</strong> zählt jeden abgeschlossenen Zustand, auch wenn die Aktivität mit einem nicht bestandenen Ergebnis abgeschlossen wurde.</p><p><strong>Aktivität ist abgeschlossen und bestanden</strong> zählt nur den nativen Zustand „abgeschlossen und bestanden“. Eine Quelle, die lediglich einen Abschluss ohne Bestanden-Status erfasst, erfüllt diese Bedingung nicht.</p>';
$string['adminhelp_completion'] = 'Automatischer Meilensteinabschluss';
$string['adminhelp_completion_article'] = '<p><strong>Abschließen, wenn die Aggregationsschwelle erreicht ist</strong> ist die eigene Bedingung für den automatischen Aktivitätsabschluss. Aktiviere die Abschlussverfolgung im Kurs, wähle den automatischen Abschluss für diese Aktivität und lasse diese Bedingung angehakt.</p><p>Änderungen am Abschluss der Quellen lösen eine Neuberechnung aus. Erfüllt eine Quelle die Bedingung nicht mehr, kann der Meilenstein wieder unvollständig werden. Du kannst ihn an anderer Stelle im Kurs als Abschlussvoraussetzung verwenden, auch wenn Lernende seine Detailseite nicht öffnen dürfen.</p>';
$string['adminhelp_maintenance'] = 'Quellen und Regeln pflegen';
$string['adminhelp_maintenance_article'] = '<p>Prüfe nach dem Löschen einer Quelle die <strong>Quellaktivitäten</strong> und die <strong>Erforderliche Anzahl</strong>. Die gelöschte Verknüpfung wird entfernt; die Schwelle bleibt erhalten. Liegt sie über der verbleibenden Quellenanzahl, erscheint auf der Aktivitätsseite ein Hinweis.</p><p>Kurssicherung und Wiederherstellung verbinden die im wiederhergestellten Kurs enthaltenen Quellen erneut. Fehlen Quellen, prüfe die wiederhergestellte Auswahl und Schwelle. Beim Speichern einer vorhandenen Aktivität werden ihre Abschlusszustände zurückgesetzt und neu berechnet.</p>';
$string['overview_help'] = 'Lies die konfigurierte Regel und die für Dich verfügbaren Quellen. Das Öffnen dieser Seite schließt den Meilenstein nicht ab.';
$string['setup_help'] = 'Wähle verfolgte Quellen, eine Schwelle und eine Bedingung. Aktiviere danach den automatischen Abschluss mit der Aggregationsregel.';
$string['selection_help'] = 'Wähle Aktivitäten mit Abschlussverfolgung aus diesem Kurs. Selbstauswahl und Aggregatorketten mit Kreisbezügen werden abgewiesen.';
$string['threshold_help'] = 'Mindestens so viele ausgewählte Quellen müssen die Bedingung erfüllen. Das Löschen einer Quelle senkt den Wert nicht automatisch.';
$string['conditions_help'] = 'Ein Abschluss zählt auch bei nicht bestandenem Ergebnis. „Abgeschlossen und bestanden“ verlangt den nativen Bestanden-Abschlussstatus.';
$string['completion_help'] = 'Lasse die Aggregationsbedingung beim automatischen Abschluss aktiviert. Änderungen an Quellen können den Meilenstein abschließen oder wieder öffnen.';
$string['maintenance_help'] = 'Prüfe nach Löschungen oder teilweiser Kurswiederherstellung die Quellauswahl und die Schwelle.';
$string['overview'] = $string['adminhelp_overview'];
$string['setup'] = $string['adminhelp_setup'];
$string['selection'] = $string['adminhelp_selection'];
$string['threshold'] = $string['adminhelp_threshold'];
$string['conditions'] = $string['adminhelp_conditions'];
$string['completion'] = $string['adminhelp_completion'];
$string['maintenance'] = $string['adminhelp_maintenance'];
