<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * German language strings for aiplacement_ragflowhelpdesk.
 *
 * @package    aiplacement_ragflowhelpdesk
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['chatid'] = 'Chat-Assistant';
$string['chatid_help'] = 'Der RAGflow-Chat-Assistant, der Helpdesk-Fragen beantwortet. Er sollte auf einer site-weiten / organisationsweiten Wissensbasis beruhen. Erforderlich — der Helpdesk ist erst verfügbar, wenn ein Assistant ausgewählt ist.';
$string['greeting'] = 'Begrüßungstext';
$string['greeting_desc'] = 'Wird als erste Nachricht angezeigt, wenn der Helpdesk-Chat geöffnet wird. Leer lassen zum Deaktivieren.';
$string['greetingdefault'] = 'Hallo, ich bin der RAGflow Helpdesk. Wobei kann ich dir rund um die Plattform helfen?';
$string['longterm'] = 'Langzeitgedächtnis';
$string['longterm_help'] = 'Zusätzlich zum einzelnen Gespräch dauerhafte Fakten über die Nutzerin/den Nutzer (Name, Rolle, Sprache, Vorlieben, wiederkehrende Ziele) über Gespräche hinweg merken, sodass ein neues Gespräch die Person weiterhin kennt. Nutzt RAGflows native Memory: Die Nachrichten der Person werden gespeichert und relevante Erinnerungen in jeden Turn eingespielt (unten eine RAW-Memory verwenden). Erfordert das Gesprächsgedächtnis sowie eine RAGflow-Memory unten. Dies hält mehr personenbezogene Daten in RAGflow (siehe Datenschutzhinweis); sie werden mit den Daten der Person gelöscht.';
$string['memoryid'] = 'RAGflow-Memory';
$string['memoryid_help'] = 'Die für das Langzeitgedächtnis verwendete RAGflow-Memory. In RAGflow als RAW-Memory anlegen — aktuell der einzige unterstützte Typ; die extrahierenden Typen (semantic, episodic, procedural) folgen ggf. in einer späteren Version. Eine gemeinsame Memory bedient alle Nutzer; Moodle trennt sie pro Person. Für das Langzeitgedächtnis erforderlich.';
$string['pluginname'] = 'RAGflow Helpdesk';
$string['privacy:metadata'] = 'Das RAGflow-Helpdesk-Placement speichert keine personenbezogenen Daten. Die Unterhaltung besteht nur im Browser; Anfragen verarbeitet das Core-KI-Subsystem und der konfigurierte Provider.';
$string['ragflowhelpdesk:use'] = 'RAGflow Helpdesk verwenden';
$string['sessionmemory'] = 'Gesprächsgedächtnis';
$string['sessionmemory_help'] = 'Merkt sich den Gesprächsverlauf über Turns und Seiten-Reloads hinweg per RAGflow-Session, sodass Folgefragen Kontext haben und der Verlauf bei der Rückkehr wiederhergestellt wird. Die Unterhaltung wird server-seitig in RAGflow gespeichert (siehe Datenschutzhinweis).';
