<?php
// This file is part of Moodle - https://moodle.org/
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

$string['errornosources'] = 'Wähle mindestens eine Quellaktivität aus.';
$string['requiredcount_help'] = 'So viele ausgewählte Quellaktivitäten müssen die Bedingung mindestens erfüllen. Gib einen Wert von 1 bis zur Anzahl der ausgewählten Quellen an.';
$string['conditiontype_help'] = 'Wähle, ob ein Abschluss genügt oder ob die Quellaktivität abgeschlossen und bestanden sein muss.';
$string['completionthreshold_help'] = 'Verwende den automatischen Aktivitätsabschluss und lass diese Bedingung aktiviert, damit der Meilenstein aus den ausgewählten Quellaktivitäten berechnet wird.';
$string['adminhelp_overview_article'] = '<p>Die Regel über der Quellliste zeigt, wie viele ausgewählte Aktivitäten die eingestellte Bedingung erfüllen müssen. Das Öffnen dieser Seite schließt den Meilenstein nicht ab.</p><p><strong>Quellen</strong> zeigt nur Aktivitäten, auf die du zugreifen kannst. Die Regel wertet die konfigurierten Quellen aus; eine verborgene oder eingeschränkte Aktivität kann daher zählen, ohne in deiner Liste zu erscheinen.</p><p>Für den Zugriff auf diese Seite gilt ein eigenes Recht. Standardmäßig steht sie Lehr- und Verwaltungsrollen zur Verfügung. Teilnehmer/innen können den berechneten Abschlussstatus erhalten, auch wenn sie diese Seite nicht öffnen dürfen.</p>';
$string['adminhelp_setup_article'] = '<p>Aktiviere die Abschlussverfolgung im Kurs und richte den Abschluss der Quellaktivitäten ein. Wähle sie unter <strong>Quellaktivitäten</strong>, gib die <strong>Erforderliche Anzahl</strong> an und lege die <strong>Bedingung</strong> fest.</p><p>Wähle in den nativen Abschlusseinstellungen den automatischen Abschluss und aktiviere <strong>Abschließen, wenn die Aggregationsschwelle erreicht ist</strong>. Beim Speichern einer vorhandenen Aktivität werden ihre Abschlusszustände zurückgesetzt und neu berechnet. Prüfe daher nach Änderungen das Ergebnis.</p>';
$string['adminhelp_selection_article'] = '<p><strong>Quellaktivitäten</strong> enthält Aktivitäten des aktuellen Kurses mit aktivierter Abschlussverfolgung. Wähle einen oder mehrere Einträge; der aktuelle Aggregator kann sich nicht selbst auswählen.</p><p>Du kannst einen anderen Aggregator auswählen und so eine Kette bilden. Eine Auswahl, die einen Kreisbezug erzeugen würde, wird beim Speichern abgewiesen. Quellen aus anderen Kursen oder ohne Abschlussverfolgung werden ebenfalls abgewiesen.</p>';
$string['adminhelp_threshold_article'] = '<p><strong>Erforderliche Anzahl</strong> ist eine Mindestschwelle. Wenn du beispielsweise fünf Aktivitäten auswählst und 3 eingibst, müssen beliebige drei davon die gewählte Bedingung erfüllen.</p><p>Der Wert muss mindestens 1 sein und darf die Anzahl der ausgewählten Quellen nicht überschreiten. Das Löschen einer Quelle senkt die Schwelle nicht automatisch; prüfe danach die verbleibenden Quellen und die erforderliche Anzahl.</p>';
$string['adminhelp_completion_article'] = '<p><strong>Abschließen, wenn die Aggregationsschwelle erreicht ist</strong> ist die eigene Bedingung für den automatischen Aktivitätsabschluss. Aktiviere die Abschlussverfolgung im Kurs, wähle den automatischen Abschluss für diese Aktivität und lass diese Bedingung angehakt.</p><p>Änderungen am Abschluss der Quellen lösen eine Neuberechnung aus. Erfüllt eine Quelle die Bedingung nicht mehr, kann der Meilenstein wieder unvollständig werden. Du kannst ihn an anderer Stelle im Kurs als Abschlussvoraussetzung verwenden, auch wenn Teilnehmer/innen seine Detailseite nicht öffnen dürfen.</p>';
$string['adminhelp_maintenance_article'] = '<p>Prüfe nach dem Löschen einer Quelle die <strong>Quellaktivitäten</strong> und die <strong>Erforderliche Anzahl</strong>. Die gelöschte Verknüpfung wird entfernt; die Schwelle bleibt erhalten. Liegt sie über der verbleibenden Quellenanzahl, erscheint auf der Aktivitätsseite ein Hinweis.</p><p>Kurssicherung und Wiederherstellung verbinden die im wiederhergestellten Kurs enthaltenen Quellen erneut. Fehlen Quellen, prüfe die wiederhergestellte Auswahl und Schwelle. Beim Speichern einer vorhandenen Aktivität werden ihre Abschlusszustände zurückgesetzt und neu berechnet.</p>';
$string['overview_help'] = 'Lies die konfigurierte Regel und die für dich verfügbaren Quellen. Das Öffnen dieser Seite schließt den Meilenstein nicht ab.';
$string['setup_help'] = 'Wähle verfolgte Quellen, eine Schwelle und eine Bedingung. Aktiviere danach den automatischen Abschluss mit der Aggregationsregel.';
$string['selection_help'] = 'Wähle Aktivitäten mit Abschlussverfolgung aus diesem Kurs. Selbstauswahl und Aggregatorketten mit Kreisbezügen werden abgewiesen.';
$string['completion_help'] = 'Lass die Aggregationsbedingung beim automatischen Abschluss aktiviert. Änderungen an Quellen können den Meilenstein abschließen oder wieder öffnen.';
$string['maintenance_help'] = 'Prüfe nach Löschungen oder teilweiser Kurswiederherstellung die Quellauswahl und die Schwelle.';
$string['updateguard_hint'] = 'Verwende ein freigegebenes Paket für die installierte Ausgabe. Du kannst den Vorgang erneut prüfen.';
$string['updateguard_dependency'] = 'Eine benötigte Plugin-Version fehlt. Aktualisiere die Abhängigkeit gemeinsam mit diesem Plugin oder vorher.';
$string['updateguard_approval'] = 'Die Pakete oder der installierte Stand haben sich seit der Vorschau geändert. Prüfe den Vorgang erneut.';
$string['updateguard_busy'] = 'Eine andere Installation läuft. Versuche es nach deren Abschluss erneut.';
$string['updateguard_installed'] = 'Der installierte Updateschutz ist unvollständig. Stelle die Dateien der zuletzt installierten freigegebenen Version wieder her.';
$string['updateguard_operation'] = 'Diese Kombination von Installationsaktionen wird nicht unterstützt. Starte einen einzelnen Updatevorgang erneut.';
$string['updateinfo_choice'] = 'Kontrolliere vor dem Fortfahren die Paketquelle und Moodles Prüfergebnisse. Mit „{$a}“ unten kannst du abbrechen.';
