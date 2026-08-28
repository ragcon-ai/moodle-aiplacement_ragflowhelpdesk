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
 * The RAGflow Helpdesk chat page (system context).
 *
 * @package    aiplacement_ragflowhelpdesk
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../../config.php');

require_login();
$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url('/ai/placement/ragflowhelpdesk/index.php');
$PAGE->set_pagelayout('standard');
$title = get_string('pluginname', 'aiplacement_ragflowhelpdesk');
$PAGE->set_title($title);
$PAGE->set_heading($title);

require_capability('aiplacement/ragflowhelpdesk:use', $context);

$greeting = get_config('aiplacement_ragflowhelpdesk', 'greeting');
if ($greeting === false) {
    $greeting = get_string('greetingdefault', 'aiplacement_ragflowhelpdesk');
}

echo $OUTPUT->header();
echo \aiprovider_ragflow\output\chat::render_drawer([
    'userid' => (int) $USER->id,
    'contextid' => (int) $context->id,
    'component' => 'aiplacement_ragflowhelpdesk',
    'label' => $title,
    'greeting' => (string) $greeting,
    'page' => true,
]);
echo $OUTPUT->footer();
