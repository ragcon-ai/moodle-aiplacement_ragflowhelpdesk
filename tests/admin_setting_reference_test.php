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

use aiprovider_ragflow\local\health\reference_status;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Regression test for the silent config-loss fix: the reference select must ALWAYS keep the stored value
 * selectable, so saving the settings page while RAGflow is unreachable (empty live list) can never drop
 * the configured assistant / memory.
 *
 * @package    aiplacement_ragflowhelpdesk
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[CoversClass(admin_setting_reference::class)]
final class admin_setting_reference_test extends \advanced_testcase {
    /**
     * The setting extends \admin_setting_configselect from lib/adminlib.php, which is not autoloaded, so
     * load it before the test references the class (the admin settings framework loads it in production).
     *
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        global $CFG;
        require_once($CFG->libdir . '/adminlib.php');
    }

    /**
     * When RAGflow is unreachable the live list is empty, but the stored id must still be a valid choice —
     * this is what stops a save from silently clearing it.
     *
     * @return void
     */
    public function test_merge_choices_keeps_stored_when_api_unreachable(): void {
        $choices = admin_setting_reference::merge_choices('assistant', [], '2839995c', 'Unavailable (2839…)');
        $this->assertArrayHasKey('2839995c', $choices, 'stored value stays selectable so a save cannot drop it');
        $this->assertSame('Unavailable (2839…)', $choices['2839995c']);
        $this->assertArrayHasKey('', $choices);
    }

    /**
     * A stored value that IS in the live list keeps its real label and is not duplicated.
     *
     * @return void
     */
    public function test_merge_choices_uses_live_label_when_present(): void {
        $live = ['abc' => 'Onboarding Assistant'];
        $choices = admin_setting_reference::merge_choices('assistant', $live, 'abc', 'IGNORED');
        $this->assertSame('Onboarding Assistant', $choices['abc'], 'a value in the live list keeps its real label');
        $this->assertCount(2, $choices, 'no duplicate stored entry when it is already live');
    }

    /**
     * No stored value: only the base "none" option plus the live list.
     *
     * @return void
     */
    public function test_merge_choices_empty_stored(): void {
        $choices = admin_setting_reference::merge_choices('memory', ['m' => 'Mem'], '', 'X');
        $this->assertSame(['' => get_string('none'), 'm' => 'Mem'], $choices);
    }

    /**
     * Call a protected static method on the setting class.
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    private static function call(string $method, array $args) {
        $rm = new \ReflectionMethod(admin_setting_reference::class, $method);
        $rm->setAccessible(true);
        return $rm->invokeArgs(null, $args);
    }

    /**
     * The stored-value label distinguishes a genuinely gone reference ("no longer in RAGflow") from one that
     * merely could not be verified — the two must never read the same, so an admin can tell a config problem
     * from a connection problem.
     *
     * @return void
     */
    public function test_stored_label_distinguishes_missing_from_unverified(): void {
        $missing = self::call('stored_label', [
            new reference_status(reference_status::MISSING, 'assistant_not_found', '2839995cabcdef'),
        ]);
        $unverified = self::call('stored_label', [
            new reference_status(reference_status::UNVERIFIED, 'api_unreachable', '2839995cabcdef'),
        ]);
        $this->assertSame(get_string('reference:option_missing', 'aiprovider_ragflow', '2839995c…'), $missing);
        $this->assertSame(get_string('reference:option_unverified', 'aiprovider_ragflow', '2839995c…'), $unverified);
        $this->assertNotSame($missing, $unverified);
    }

    /**
     * shorten() abbreviates a long id to 8 chars + ellipsis, leaves an empty id empty.
     *
     * @return void
     */
    public function test_shorten(): void {
        $this->assertSame('2839995c…', self::call('shorten', ['2839995cabcdef0011']));
        $this->assertSame('', self::call('shorten', ['']));
        // An id shorter than 8 chars is returned whole with the ellipsis appended.
        $this->assertSame('short…', self::call('shorten', ['short']));
    }
}
