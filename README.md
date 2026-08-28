# RAGflow Helpdesk (aiplacement_ragflowhelpdesk) #

A site-wide **Helpdesk chat** placement for Moodle's core AI subsystem. It adds a **RAGflow Helpdesk** entry
to the site navigation that opens a chat page answering from an organisation-wide
[RAGflow](https://ragflow.io/) knowledge base. It reuses the shared chat engine of the **RAGflow AI
provider** (`aiprovider_ragflow`), so credentials and the assistant are configured once and shared across
the suite.

## Features ##

* A persistent **RAGflow Helpdesk** entry in the site menu, available site-wide to logged-in users; shown
  only once the feature is configured.
* A dedicated chat page that answers from the configured **chat assistant** (an organisation-wide knowledge
  base, not course-scoped).
* Its **own configuration** — assistant, greeting, **conversation memory** (remember the chat across turns
  and reloads) and optional **long-term memory** (durable facts about the user across conversations), plus
  source links and the secure file proxy.
* **Private mode** and drawer controls: start a new conversation, a new private conversation, or delete all
  memories about you.
* Stores **no personal data of its own**; with long-term memory on, per-user facts are kept in RAGflow and
  cleared with the user's data.

## Requirements ##

* **Moodle 5.0–5.2** (core AI subsystem).
* The **RAGflow AI provider** (`aiprovider_ragflow`) installed and enabled — it supplies the shared chat
  engine and the RAGflow credentials. This plugin declares a dependency on it.
* **External service (RAGflow), version 0.25 or later:** a reachable [RAGflow](https://ragflow.io/) instance
  and a **RAGflow API key**, configured once in the AI provider. RAGflow can be **self-hosted or hosted by
  RAGcon**. Without a configured RAGflow tenant the Helpdesk entry stays hidden.

## Installation ##

1. Copy the plugin to `ai/placement/ragflowhelpdesk` in the Moodle tree (**Moodle 5.1+**:
   `public/ai/placement/ragflowhelpdesk`).
2. Complete the installation via *Site administration → Notifications* or `php admin/cli/upgrade.php`.
3. Configure it under *Site administration → Plugins → AI placements → RAGflow Helpdesk* (choose the chat
   assistant; the Helpdesk stays unavailable until one is selected).

## Usage ##

Open **RAGflow Helpdesk** from the site menu and ask a question about the platform. Answers come from the
configured knowledge base, with source links when *Include sources* is enabled.

## Documentation ##

Full setup and usage documentation: <https://docs.ragcon.ai/moodle-ragflow/plugins/helpdesk/>

## Privacy and GDPR ##

* Implements the **Moodle Privacy API**: the placement stores **no personal data of its own**.
* Help questions are sent to RAGflow through the **RAGflow AI provider** (`aiprovider_ragflow`), which owns
  the data-processing and GDPR handling — see that plugin's *Privacy* section. For **long-term memory**,
  create the RAGflow memory as a **RAW** memory (currently the only supported type). RAGflow can be
  **self-hosted or hosted by RAGcon**, so the processing location is under the operator's control.

## Issues & Contributing ##

* Issues and feature requests: <https://github.com/ragcon-ai/moodle-aiplacement_ragflowhelpdesk/issues>

  Please include your **RAGflow version**, **Moodle version**, **plugin version** and the **exact steps to
  reproduce**.
* Pull requests are welcome. The plugin stays **GPLv3**; by contributing you agree your changes are licensed
  under the same terms.

## Support ##

Professional support and web hosting for RAGflow + Moodle are available from **RAGcon GmbH** —
<https://www.ragcon.ai/en> (www.ragcon.ai).

## Community ##

* Moodle — <https://moodle.org>
* RAGflow — <https://ragflow.io>

## Changelog ##

### 0.7.0 ###

* **First public release (beta).** A site-wide Helpdesk chat for Moodle, added as an AI placement: a
  persistent help drawer that answers from an organisation-wide RAGflow knowledge base, with conversation
  memory, optional long-term memory, private mode and source links.

## Acknowledgements ##

This plugin integrates two independent software projects:

* **Moodle** — software by Moodle Pty Ltd, released under the GNU GPL v3 or later
  (<https://github.com/moodle/moodle>). *The word Moodle and associated Moodle logos are trademarks or
  registered trademarks of Moodle Pty Ltd or its related affiliates.*
* **RAGflow** — open-source software by InfiniFlow Inc., released under the Apache License 2.0
  (<https://ragflow.io> · <https://github.com/infiniflow/ragflow>).

This plugin is an independent integration and is not affiliated with or endorsed by Moodle Pty Ltd or
InfiniFlow Inc.

## Development ##

This plugin is part of the Moodle RAGflow suite, developed with the help of a range of AI tools under the
professional supervision of the RAGcon GmbH team — pairing fast, AI-assisted development with human review,
automated testing and security checks before every release.

## License ##

Copyright 2026 RAGcon GmbH <info@ragcon.ai>

This program is free software: you can redistribute it and/or modify it under the terms of the GNU
General Public License as published by the Free Software Foundation, either version 3 of the License,
or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even
the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more details.

The full licence text is in `LICENSE`, or at <https://www.gnu.org/licenses/gpl-3.0.html>.
