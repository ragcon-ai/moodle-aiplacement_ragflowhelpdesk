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

use aiprovider_ragflow\helper;
use aiprovider_ragflow\local\health\checker;
use aiprovider_ragflow\local\health\reference_status;

/**
 * A select admin setting for a RAGflow reference (chat assistant or memory) that **always keeps the
 * currently stored value selectable** — even when RAGflow is unreachable and the live list comes back
 * empty. This is what prevents the silent config loss: with a plain admin_setting_configselect, an API
 * outage means the stored id is not among the choices, the select submits the first option, and saving the
 * page overwrites the reference to empty. Here the stored value is always a choice, so a save preserves it.
 *
 * A stored value that is no longer in the live list is labelled by its checker state (missing vs
 * unverified) instead of as a bare 32-character hash.
 *
 * @package    aiplacement_ragflowhelpdesk
 * @copyright  2026 RAGcon GmbH <info@ragcon.ai>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class admin_setting_reference extends \admin_setting_configselect {
    /** @var string 'assistant' or 'memory'. */
    protected string $reftype;

    /**
     * Build a RAGflow reference select that always keeps the stored value selectable.
     *
     * @param string $name Unique setting name (e.g. aiplacement_ragflowhelpdesk/chatid).
     * @param string $visiblename Localised label.
     * @param string $description Localised description.
     * @param string $defaultsetting Default value.
     * @param string $reftype 'assistant' or 'memory'.
     */
    public function __construct(
        string $name,
        string $visiblename,
        string $description,
        string $defaultsetting,
        string $reftype
    ) {
        $this->reftype = $reftype;
        parent::__construct($name, $visiblename, $description, $defaultsetting, null);
    }

    /**
     * Build the choices lazily from the live RAGflow list, always keeping the stored value selectable.
     *
     * @return bool
     */
    public function load_choices() {
        if (is_array($this->choices)) {
            return true;
        }
        [$base, $key] = self::provider_config();
        $stored = (string) $this->get_setting();
        if ($this->reftype === 'memory') {
            $live = class_exists('\aiprovider_ragflow\helper') ? helper::get_memories($base, $key) : [];
            $status = checker::instance()->check_memory($stored);
        } else {
            $live = class_exists('\aiprovider_ragflow\helper') ? helper::get_chats($base, $key) : [];
            $status = checker::instance()->check_assistant($stored);
        }
        $this->choices = self::merge_choices($this->reftype, $live, $stored, self::stored_label($status));
        return true;
    }

    /**
     * Build the select choices, ALWAYS keeping $stored selectable. Pure – no network. This method is the
     * guarantee that a save can never drop the stored reference.
     *
     * @param string $reftype 'assistant' or 'memory'.
     * @param array $live [id => name] live list (may be empty when RAGflow is unreachable).
     * @param string $stored The currently stored id.
     * @param string $storedlabel Label to use for a stored id that is not in the live list.
     * @return array [id => label]
     */
    public static function merge_choices(string $reftype, array $live, string $stored, string $storedlabel): array {
        $none = $reftype === 'memory' ? get_string('none') : get_string('choosedots');
        $choices = ['' => $none] + $live;
        if ($stored !== '' && !isset($choices[$stored])) {
            $choices[$stored] = $storedlabel;
        }
        return $choices;
    }

    /**
     * A short, human label for a stored reference that is not in the live list, distinguishing "no longer
     * exists" from "could not be verified".
     *
     * @param reference_status $status
     * @return string
     */
    protected static function stored_label(reference_status $status): string {
        $short = self::shorten((string) $status->reference);
        if ($status->state === reference_status::UNVERIFIED) {
            return get_string('reference:option_unverified', 'aiprovider_ragflow', $short);
        }
        return get_string('reference:option_missing', 'aiprovider_ragflow', $short);
    }

    /**
     * Abbreviate a reference id for display (first 8 chars + ellipsis).
     *
     * @param string $id
     * @return string
     */
    protected static function shorten(string $id): string {
        return $id === '' ? '' : \core_text::substr($id, 0, 8) . '…';
    }

    /**
     * The enabled RAGflow provider's [baseurl, apikey], or ['', ''] if none.
     *
     * @return array
     */
    protected static function provider_config(): array {
        global $DB;
        $rec = $DB->get_record_select(
            'ai_providers',
            'provider = :p AND enabled = 1',
            ['p' => 'aiprovider_ragflow\\provider'],
            '*',
            IGNORE_MULTIPLE
        );
        if (!$rec) {
            return ['', ''];
        }
        $config = json_decode($rec->config, true) ?: [];
        return [(string) ($config['baseurl'] ?? ''), (string) ($config['apikey'] ?? '')];
    }
}
