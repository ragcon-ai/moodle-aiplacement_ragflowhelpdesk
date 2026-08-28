@aiplacement @aiplacement_ragflowhelpdesk @javascript
Feature: RAGflow Helpdesk placement
  In order not to expose an unusable entry
  As a site administrator
  I need the Helpdesk navigation entry to stay hidden until the placement is configured

  Scenario: The Helpdesk entry is hidden while the placement is not configured
    Given I log in as "admin"
    And I am on homepage
    Then I should not see "RAGflow Helpdesk"
