<?php
// This file is part of the Twitter Card local plugin for Moodle
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
 * Contains the class responsible for step definitions related to local_twittercard.
 *
 * @package    local_twittercard
 * @category   test
 * @copyright  2017 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// NOTE: no MOODLE_INTERNAL test here, this file may be required by behat before including /config.php.

use Behat\Mink\Exception\DriverException,
    Behat\Mink\Exception\ExpectationException as ExpectationException,
    Behat\Mink\Exception\ElementNotFoundException as ElementNotFoundException,
    Behat\Gherkin\Node\TableNode as TableNode;

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

/**
 * The class responsible for step definitions related to local_twittercard.
 *
 * @package    local_twittercard
 * @category   test
 * @copyright  2017 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_local_twittercard extends behat_base {
    /**
     * Check that the given meta tags should exist, matching the given contents.
     *
     * @Then /^I should see the following meta tags:$/
     * @param TableNode $table A list of rows, with the following columns: metaname, metacontent
     *
     * @throws ExpectationException
     * @throws ElementNotFoundException
     */
    public function i_should_see_the_following_meta_tags(TableNode $table) {
        $hash = $table->getHash();
        foreach ($hash as $row) {
            $key = $row['metaname'];
            $expectedvalue = $row['metacontent'];
            // Search for the name.
            $exception = new ExpectationException("Unable to find the meta name '$key'", $this->getSession());
            $xpath = "//meta[@name='$key']";
            $node = $this->find('xpath', $xpath, $exception);
            if (empty($node)) {
                throw $exception;
            }
            // Search for the content.
            $exception = new ExpectationException("Unable to find content related to meta '$key'", $this->getSession());
            $currentvalue = $node->getAttribute('content');
            if (empty($currentvalue)) {
                throw $exception;
            }
            $exception = new ExpectationException("The expected content '$expectedvalue' related to meta '$key' " .
                "doesn't match with the current value, '$currentvalue'", $this->getSession());
            if ($expectedvalue !== $currentvalue) {
                throw $exception;
            }
        }
    }

    /**
     * Check that the given meta tags should not exist.
     *
     * @Then /^I should not see the following meta tags:$/
     * @param TableNode $table A list of rows, with the following columns: metaname, metacontent
     *
     * @throws ExpectationException
     * @throws ElementNotFoundException
     */
    public function i_should_not_see_the_following_meta_tags(TableNode $table) {
        $hash = $table->getHash();
        foreach ($hash as $row) {
            $key = $row['metaname'];
            // Search for the name.
            $xpath = "//meta[@name='$key']";

            $this->execute('behat_general::should_not_exist', [$xpath, 'xpath_element']);
        }
    }

    /**
     * Go to current page setting "Edit settings"
     *
     * This can be used on front page, course, category or modules pages.
     *
     * @Given /^I navigate to _Edit settings_ in current page administration$/
     *
     * @throws ExpectationException
     * @return void
     */
    public function i_navigate_to_edit_settings_in_current_page_administration() {
        global $CFG;

        $branch = (int)$CFG->branch;
        $nodetext = 'Settings';

        // HACK - Due to MDL-72093 (related to MDL-69588) we need create this hack to stick with one-branch deploy.
        if ($branch < 400) {
            $nodetext = 'Edit settings';
        }

        $this->execute("behat_navigation::i_navigate_to_in_current_page_administration", [$nodetext]);
    }
}
