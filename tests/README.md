# Tests – aiplacement_ragflowhelpdesk

**Plugin version:** `2026082311` (release `0.6.9`) — update this line whenever the tests or the plugin
version change.

PHPUnit tests for this plugin. They run automatically in the bundled **moodle-plugin-ci** GitHub Actions
workflow; to run them locally, use `vendor/bin/phpunit` from a configured Moodle root (see the
[Moodle PHPUnit docs](https://moodledev.io/general/development/tools/phpunit)).

This file records **what the tests verify**, in **execution order** (PHPUnit runs the methods top-to-bottom
as defined in each class). Keep it in sync when tests are added, reordered or changed.

This placement is deliberately thin: it exposes a site-wide Helpdesk chat entry and delegates all chat
logic to the shared RAGflow provider (`aiprovider_ragflow`), which carries the bulk of the unit tests.

## Coverage

### `placement_test.php` — Helpdesk placement (`\aiplacement_ragflowhelpdesk\placement`)

| # | Test | Verifies |
|---|---|---|
| 1 | `test_get_action_list` | `get_action_list()` advertises exactly the `generate_text` action, and every advertised entry is a real `\core_ai\aiactions\base` subclass. |

### `admin_setting_reference_test.php` — reference select (`\aiplacement_ragflowhelpdesk\admin_setting_reference`)

Regression cover for the silent config-loss fix: the reference select must ALWAYS keep the stored value
selectable, so saving the settings page while RAGflow is unreachable can never drop the configured
assistant / memory.

| # | Test | Verifies |
|---|---|---|
| 1 | `test_merge_choices_keeps_stored_when_api_unreachable` | with an empty live list (RAGflow unreachable) the stored id stays a selectable choice with its supplied label — a save cannot clear it. |
| 2 | `test_merge_choices_uses_live_label_when_present` | a stored value that IS in the live list keeps its real label and is not duplicated. |
| 3 | `test_merge_choices_empty_stored` | with no stored value the choices are just the "none" option plus the live list. |
| 4 | `test_stored_label_distinguishes_missing_from_unverified` | the stored-value label reads "no longer in RAGflow" for a deleted reference vs "could not be verified" for an unreachable one — never the same. |
| 5 | `test_shorten` | `shorten()` abbreviates a long id to 8 chars + ellipsis and leaves an empty id empty. |

### `behat/helpdesk_nav.feature` — acceptance (`@aiplacement_ragflowhelpdesk @javascript`)

Run with **moodle-plugin-ci** (the bundled CI runs Behat automatically) or `vendor/bin/behat` from a
configured Moodle (see the [Moodle Behat docs](https://moodledev.io/general/development/tools/behat)).

| # | Scenario | Verifies |
|---|---|---|
| 1 | The Helpdesk entry is hidden while the placement is not configured | Without configuration the "RAGflow Helpdesk" navigation entry is not shown (the `primary_extend` guard), so no unusable entry leaks. |

## Deliberately not covered here (needs integration / a running RAGflow)

- The chat itself (engine, memory, sources, rate guard) lives in `aiprovider_ragflow` and is covered there.
- The Helpdesk entry / chat once **configured** needs a reachable RAGflow tenant, so it is not automated.
