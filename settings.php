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
 * Settings for aiplacement_ragflowhelpdesk.
 *
 * @package    aiplacement_ragflowhelpdesk
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $c = 'aiplacement_ragflowhelpdesk';
    $p = 'aiprovider_ragflow';

    // The assistant/memory selects keep the stored value selectable even when RAGflow is unreachable, so a
    // save can never silently drop the reference (see admin_setting_reference). A shared, cached checker
    // also drives a state notice above each field, distinguishing "no longer exists" from "cannot verify".
    $checker = \aiprovider_ragflow\local\health\checker::instance();
    $refnotice = function (string $settingkey, string $reftype) use ($c, $p, $checker) {
        $stored = (string) get_config($c, $settingkey);
        if ($stored === '') {
            return '';
        }
        $status = $reftype === 'memory' ? $checker->check_memory($stored) : $checker->check_assistant($stored);
        if ($status->state === \aiprovider_ragflow\local\health\reference_status::MISSING) {
            return \html_writer::div(get_string('reference:notice_missing', $p), 'alert alert-danger');
        }
        if ($status->state === \aiprovider_ragflow\local\health\reference_status::UNVERIFIED) {
            return \html_writer::div(get_string('reference:notice_unverified', $p), 'alert alert-warning');
        }
        return '';
    };

    if (($notice = $refnotice('chatid', 'assistant')) !== '') {
        $settings->add(new admin_setting_description("$c/chatidnotice", '', $notice));
    }
    $settings->add(new \aiplacement_ragflowhelpdesk\admin_setting_reference(
        "$c/chatid",
        get_string('chatid', $c),
        get_string('chatid_help', $c),
        '',
        'assistant'
    ));

    $settings->add(new admin_setting_configtextarea(
        "$c/greeting",
        get_string('greeting', $c),
        get_string('greeting_desc', $c),
        get_string('greetingdefault', $c),
        PARAM_TEXT
    ));

    $settings->add(new admin_setting_configcheckbox(
        "$c/sessionmemory",
        get_string('sessionmemory', $c),
        get_string('sessionmemory_help', $c),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        "$c/longterm",
        get_string('longterm', $c),
        get_string('longterm_help', $c),
        0
    ));

    if (($notice = $refnotice('memoryid', 'memory')) !== '') {
        $settings->add(new admin_setting_description("$c/memoryidnotice", '', $notice));
    }
    $settings->add(new \aiplacement_ragflowhelpdesk\admin_setting_reference(
        "$c/memoryid",
        get_string('memoryid', $c),
        get_string('memoryid_help', $c),
        '',
        'memory'
    ));

    $settings->add(new admin_setting_configcheckbox(
        "$c/includesources",
        get_string('includesources', $p),
        get_string('includesources_help', $p),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        "$c/serveviaproxy",
        get_string('serveviaproxy', $p),
        get_string('serveviaproxy_help', $p),
        0
    ));

    // Write a slim usage/error entry to the Moodle standard log per request (opt-in; see help).
    $settings->add(new admin_setting_configcheckbox(
        "$c/logtomoodle",
        get_string('logtomoodle', $p),
        get_string('logtomoodle_desc', $p),
        0
    ));
}
