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
 * Tests for the Privacy API implementation in Twitter summary card.
 *
 * @package    local_twittercard
 * @copyright  2018 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_twittercard;

/**
 * Class local_twittercard_privacy_testcase
 *
 * @package    local_twittercard
 * @copyright  2017 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @coversDefaultClass \local_twittercard\privacy\provider
 * @covers \local_twittercard\privacy\provider
 *
 */
class privacy_test extends \advanced_testcase {
    /**
     * Tests that local_twittercard actually implements the Privacy API null_provider.
     *
     * @covers ::get_reason()
     *
     */
    public function test_null_provider() {
        $this->assertTrue(class_exists('\local_twittercard\privacy\provider'));
        $this->assertEquals(
            [ 'core_privacy\local\metadata\null_provider' => 'core_privacy\local\metadata\null_provider' ],
            class_implements('\local_twittercard\privacy\provider')
        );

        $this->assertEquals(
            'privacy:metadata',
            \local_twittercard\privacy\provider::get_reason()
        );
    }
}
