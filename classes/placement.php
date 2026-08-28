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

/**
 * The RAGflow Helpdesk placement.
 *
 * A site-wide entry point (a "RAGflow Helpdesk" item in the primary/more menu) that opens a chat
 * page. It runs the core generate_text action against the RAGflow provider from the system context,
 * so the provider answers from its organisation-wide Helpdesk knowledge base.
 *
 * @package    aiplacement_ragflowhelpdesk
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class placement extends \core_ai\placement {
    #[\Override]
    public static function get_action_list(): array {
        return [
            \core_ai\aiactions\generate_text::class,
        ];
    }
}
