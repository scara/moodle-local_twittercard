@local @local_twittercard
Feature: A Twitter summary card is added into the page
  In order to better promote my courses using Twitter
  As a user
  I want to add a Twitter summary card in each course homepage

  Background:
    Given the following "categories" exist:
      | name  | category | idnumber |
      | Cat 1 | 0        | CAT1     |
    And the following "courses" exist:
      | category | fullname    | shortname | summary          |
      | CAT1     | TC Course 1 | TCC1      | Course 1 summary |

  Scenario: Check that the meta tags for a basic Twitter Summary Card are not there by default
    Given I log in as "admin"
    When I am on "TC Course 1" course homepage
    Then I should not see the following meta tags:
      | metaname            |
      | twitter:card        |
      | twitter:site        |
      | twitter:title       |
      | twitter:description |
      | twitter:image       |
      | twitter:image:alt   |

  Scenario: Check the meta tags for a basic Twitter Summary Card
    Given I log in as "admin"
    And I navigate to "Plugins > Local plugins > Twitter card" in site administration
    And I set the field "Enabled" to "1"
    And I press "Save changes"
    When I am on "TC Course 1" course homepage
    Then I should see the following meta tags:
      | metaname            | metacontent      |
      | twitter:card        | summary          |
      | twitter:title       | TC Course 1      |
      | twitter:description | Course 1 summary |
    And I should not see the following meta tags:
      | metaname            |
      | twitter:site        |
      | twitter:image       |
      | twitter:image:alt   |

  Scenario: Check that no card exist with editing mode on
    Given the following config values are set as admin:
      | enabled | 1 | local_twittercard |
    And I log in as "admin"
    When I am on "TC Course 1" course homepage with editing mode on
    Then I should not see the following meta tags:
      | metaname            |
      | twitter:card        |
      | twitter:site        |
      | twitter:title       |
      | twitter:description |
      | twitter:image       |
      | twitter:image:alt   |

  Scenario: Check that no card exist while editing the course settings
    Given the following config values are set as admin:
      | enabled | 1 | local_twittercard |
    And I log in as "admin"
    When I am on "TC Course 1" course homepage
    And I navigate to _Edit settings_ in current page administration
    Then I should see "Edit course settings"
    And I should not see the following meta tags:
      | metaname            |
      | twitter:card        |
      | twitter:site        |
      | twitter:title       |
      | twitter:description |
      | twitter:image       |
      | twitter:image:alt   |

  Scenario: Check the meta tags for a Twitter Summary Card, including twitter:site
    Given the following config values are set as admin:
      | enabled | 1 | local_twittercard |
    And I log in as "admin"
    And I navigate to "Plugins > Local plugins > Twitter card" in site administration
    And I set the field "Twitter site" to "@website"
    And I press "Save changes"
    When I am on "TC Course 1" course homepage
    Then I should see the following meta tags:
      | metaname            | metacontent      |
      | twitter:card        | summary          |
      | twitter:site        | @website         |
      | twitter:title       | TC Course 1      |
      | twitter:description | Course 1 summary |
    And I should not see the following meta tags:
      | metaname            |
      | twitter:image       |
      | twitter:image:alt   |

  Scenario: Check the meta tags for a basic Twitter Summary Card, given a broken twitter:site value
    Given the following config values are set as admin:
      | enabled     | 1       | local_twittercard |
      | twittersite | website | local_twittercard |
    And I log in as "admin"
    When I am on "TC Course 1" course homepage
    Then I should see the following meta tags:
      | metaname            | metacontent      |
      | twitter:card        | summary          |
      | twitter:title       | TC Course 1      |
      | twitter:description | Course 1 summary |
    And I should not see the following meta tags:
      | metaname            |
      | twitter:site        |
      | twitter:image       |
      | twitter:image:alt   |

  Scenario: Check that no card exist while browsing an activity in a course e.g. a forum
    Given the following "activities" exist:
      | activity   | name         | intro                       | course | idnumber  | section |
      | forum      | TC Forum 1   | TC Test forum description   | TCC1   | tcforum1  | 2       |
    And the following config values are set as admin:
      | enabled | 1 | local_twittercard |
    And I log in as "admin"
    And I am on "TC Course 1" course homepage
    And I follow "TC Forum 1"
    Then I should see "TC Test forum description"
    And I should not see the following meta tags:
      | metaname            |
      | twitter:card        |
      | twitter:site        |
      | twitter:title       |
      | twitter:description |
      | twitter:image       |
      | twitter:image:alt   |

  Scenario: Check the meta tags for a basic Twitter Summary Card - Guest Access
    Given the following "courses" exist:
      | category | fullname        | shortname | summary              |
      | CAT1     | TC Course Guest | TCCGuest  | Course Guest summary |
    And the following config values are set as admin:
      | enabled | 1 | local_twittercard |
    And I log in as "admin"
    And I am on "TC Course Guest" course homepage
    And I navigate to "Users > Enrolment methods" in current page administration
    And I click on "Edit" "link" in the "Guest access" "table_row"
    And I set the following fields to these values:
      | Allow guest access | Yes |
    And I press "Save changes"
    And I log out
    And I log in as "guest"
    When I am on "TC Course Guest" course homepage
    Then I should see the following meta tags:
      | metaname            | metacontent          |
      | twitter:card        | summary              |
      | twitter:title       | TC Course Guest      |
      | twitter:description | Course Guest summary |
    And I should not see the following meta tags:
      | metaname            |
      | twitter:site        |
      | twitter:image       |
      | twitter:image:alt   |

  Scenario: Check the meta tags for a Twitter Summary Card including an image w/o alternate text
    Given the following config values are set as admin:
      | enabled | 1 | local_twittercard |
    And I log in as "admin"
    And I am on "TC Course 1" course homepage with editing mode on
    And I edit the section "0" and I fill the form with:
      | Summary | <p><img src="http://example.org/path/to/image.png"></p> |
    And I turn editing mode off
    When I am on "TC Course 1" course homepage
    Then I should see the following meta tags:
      | metaname            | metacontent                          |
      | twitter:card        | summary                              |
      | twitter:title       | TC Course 1                          |
      | twitter:description | Course 1 summary                     |
      | twitter:image       | http://example.org/path/to/image.png |
    And I should not see the following meta tags:
      | metaname            |
      | twitter:site        |
      | twitter:image:alt   |

  Scenario: Check the meta tags for a Twitter Summary Card including an image w alternate text
    Given the following config values are set as admin:
      | enabled | 1 | local_twittercard |
    And I log in as "admin"
    And I am on "TC Course 1" course homepage with editing mode on
    And I edit the section "0" and I fill the form with:
      | Summary | <p><img src="http://example.org/path/to/image.png" alt="blahblahblah"></p> |
    And I turn editing mode off
    When I am on "TC Course 1" course homepage
    Then I should see the following meta tags:
      | metaname            | metacontent                          |
      | twitter:card        | summary                              |
      | twitter:title       | TC Course 1                          |
      | twitter:description | Course 1 summary                     |
      | twitter:image       | http://example.org/path/to/image.png |
      | twitter:image:alt   | blahblahblah                         |
    And I should not see the following meta tags:
      | metaname            |
      | twitter:site        |
