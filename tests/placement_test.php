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

use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Unit tests for the Helpdesk placement.
 *
 * @package    aiplacement_ragflowhelpdesk
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[CoversClass(placement::class)]
final class placement_test extends \advanced_testcase {
    /**
     * get_action_list(): the placement advertises exactly the generate_text action, and every advertised
     * entry is a real core_ai action class.
     *
     * @return void
     */
    public function test_get_action_list(): void {
        $actions = placement::get_action_list();
        $this->assertSame([\core_ai\aiactions\generate_text::class], $actions);
        foreach ($actions as $class) {
            $this->assertTrue(class_exists($class), "advertised action {$class} must exist");
            $this->assertTrue(is_subclass_of($class, \core_ai\aiactions\base::class));
        }
    }
}
