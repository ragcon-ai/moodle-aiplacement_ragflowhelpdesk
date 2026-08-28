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

namespace aiplacement_ragflowhelpdesk;

use core\hook\navigation\primary_extend;

/**
 * Adds the "RAGflow Helpdesk" entry to the primary navigation (overflowing into the more menu).
 *
 * @package    aiplacement_ragflowhelpdesk
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hook_callbacks {
    /**
     * Append the Helpdesk item to the site primary navigation.
     *
     * @param primary_extend $hook
     */
    public static function primary_extend(primary_extend $hook): void {
        if (!isloggedin() || isguestuser()) {
            return;
        }
        if (!\core\plugininfo\aiplacement::is_plugin_enabled('ragflowhelpdesk')) {
            return;
        }
        // The shared chat engine lives in the RAGflow provider.
        if (!class_exists('\aiprovider_ragflow\output\chat')) {
            return;
        }
        $context = \context_system::instance();
        if (!has_capability('aiplacement/ragflowhelpdesk:use', $context)) {
            return;
        }
        // Only show the entry once the feature is actually configured (provider enabled + assistant set).
        if (\aiprovider_ragflow\chat_engine::config('aiplacement_ragflowhelpdesk') === null) {
            return;
        }

        $hook->get_primaryview()->add(
            get_string('pluginname', 'aiplacement_ragflowhelpdesk'),
            new \moodle_url('/ai/placement/ragflowhelpdesk/index.php'),
            \navigation_node::TYPE_CUSTOM,
            null,
            'ragflowhelpdesk',
        );
    }
}
