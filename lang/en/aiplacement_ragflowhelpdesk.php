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
 * English language strings for aiplacement_ragflowhelpdesk.
 *
 * @package    aiplacement_ragflowhelpdesk
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['chatid'] = 'Chat assistant';
$string['chatid_help'] = 'The RAGflow chat assistant that answers Helpdesk questions. It should be backed by a site-wide / organisation knowledge base. Required — the Helpdesk is unavailable until an assistant is selected.';
$string['greeting'] = 'Greeting message';
$string['greeting_desc'] = 'Shown as the first message when the Helpdesk chat opens (leave empty to disable).';
$string['greetingdefault'] = 'Hello, I am the RAGflow Helpdesk. How can I help you with the platform?';
$string['longterm'] = 'Long-term memory';
$string['longterm_help'] = 'On top of a single conversation, carry durable facts about the user (name, role, language, preferences, recurring goals) across conversations, so a new conversation still knows the user. Uses RAGflow\'s native Memory: the user\'s messages are stored and relevant memories are retrieved into each turn (use a RAW memory below). Requires conversation memory plus a RAGflow memory below. This keeps more personal data in RAGflow (see the privacy information); it is cleared with the user\'s data.';
$string['memoryid'] = 'RAGflow memory';
$string['memoryid_help'] = 'The RAGflow memory used for long-term memory. Create it in RAGflow as a RAW memory — currently the only supported type; the extracting memory types (semantic, episodic, procedural) may be added in a later version. One shared memory serves all users; Moodle separates them per user. Required for long-term memory.';
$string['pluginname'] = 'RAGflow Helpdesk';
$string['privacy:metadata'] = 'The RAGflow Helpdesk placement does not store any personal data. The conversation exists only in the browser; prompts are handled by the core AI subsystem and the configured provider.';
$string['ragflowhelpdesk:use'] = 'Use the RAGflow Helpdesk';
$string['sessionmemory'] = 'Conversation memory';
$string['sessionmemory_help'] = 'Remember the conversation across turns and page reloads using a RAGflow session, so follow-up questions have context and the transcript is restored on return. The conversation is stored server-side in RAGflow (see the privacy information).';
