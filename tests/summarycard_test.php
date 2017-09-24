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
 * Tests for the Twitter summary card.
 *
 * @package    local_twittercard
 * @copyright  2017 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Class local_twittercard_summarycard_testcase
 *
 * @package    local_twittercard
 * @copyright  2017 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_twittercard_summarycard_testcase extends advanced_testcase {
    /**
     * Data provider for test_successful_creating().
     *
     * @return array The type-value pairs fixture.
     */
    public function test_successful_creating_provider() {
        return array(
            [
                'title', 'description', '@site', 'http://example.org/path/to/img.png', 'imagealt',
                "<meta name='twitter:card' content='summary' />
<meta name='twitter:site' content='@site' />
<meta name='twitter:title' content='title' />
<meta name='twitter:description' content='description' />
<meta name='twitter:image' content='http://example.org/path/to/img.png' />
<meta name='twitter:image:alt' content='imagealt' />
"
            ],
            [
                'title', 'description', '@site', 'http://example.org/path/to/img.png', null,
                "<meta name='twitter:card' content='summary' />
<meta name='twitter:site' content='@site' />
<meta name='twitter:title' content='title' />
<meta name='twitter:description' content='description' />
<meta name='twitter:image' content='http://example.org/path/to/img.png' />
"
            ],
            [
                'title', 'description', 'site', 'http://example.org/path/to/img.png', 'imagealt',
                "<meta name='twitter:card' content='summary' />
<meta name='twitter:title' content='title' />
<meta name='twitter:description' content='description' />
<meta name='twitter:image' content='http://example.org/path/to/img.png' />
<meta name='twitter:image:alt' content='imagealt' />
"
            ],
            [
                'title', 'description', 'site', null, 'imagealt',
                "<meta name='twitter:card' content='summary' />
<meta name='twitter:title' content='title' />
<meta name='twitter:description' content='description' />
"
            ],
            [
                'title', 'description', null, null, 'imagealt',
                "<meta name='twitter:card' content='summary' />
<meta name='twitter:title' content='title' />
<meta name='twitter:description' content='description' />
"
            ],
            [
                'title', 'description', null, null, null,
                "<meta name='twitter:card' content='summary' />
<meta name='twitter:title' content='title' />
<meta name='twitter:description' content='description' />
"
            ],
            [
                'title', 'description', '@site', 'http://example.org/path/to/img.svg', 'imagealt',
                "<meta name='twitter:card' content='summary' />
<meta name='twitter:site' content='@site' />
<meta name='twitter:title' content='title' />
<meta name='twitter:description' content='description' />
"
            ],
            [
                'title\'s', 'description\'s', '@site', 'http://example.org/path/to/img.svg', 'imagealt',
                "<meta name='twitter:card' content='summary' />
<meta name='twitter:site' content='@site' />
<meta name='twitter:title' content='title&#039;s' />
<meta name='twitter:description' content='description&#039;s' />
"
            ],
            [
                '0123456789012345678901234567890123456789012345678901234567890123456789',
                '0123456789012345678901234567890123456789012345678901234567890123456789'.
                    '0123456789012345678901234567890123456789012345678901234567890123456789'.
                    '012345678901234567890123456789012345678901234567890123456789',
                '@site', 'http://example.org/path/to/img.svg',
                'imagealt',
                "<meta name='twitter:card' content='summary' />
<meta name='twitter:site' content='@site' />
<meta name='twitter:title' content='0123456789012345678901234567890123456789012345678901234567890123456789' />
<meta name='twitter:description' content='0123456789012345678901234567890123456789012345678901234567890123456789".
                "0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789".
                "012345678901234567890123456789' />
"
            ],
            [
                '01234567890123456789012345678901234567890123456789012345678901234567890',
                '0123456789012345678901234567890123456789012345678901234567890123456789'.
                    '0123456789012345678901234567890123456789012345678901234567890123456789'.
                    '0123456789012345678901234567890123456789012345678901234567890',
                '@site', 'http://example.org/path/to/img.svg',
                'imagealt',
                "<meta name='twitter:card' content='summary' />
<meta name='twitter:site' content='@site' />
<meta name='twitter:title' content='0123456789012345678901234567890123456789012345678901234567890123456...' />
<meta name='twitter:description' content='01234567890123456789012345678901234567890123456789012345678901234567890".
                "123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789".
                "012345678901234567890123456...' />
"
            ],
            [
                'title', 'description', 'site', 'http://example.org/path/to/img.png',
                '0123456789012345678901234567890123456789012345678901234567890123456789'.
                    '0123456789012345678901234567890123456789012345678901234567890123456789'.
                    '0123456789012345678901234567890123456789012345678901234567890123456789'.
                    '0123456789012345678901234567890123456789012345678901234567890123456789'.
                    '0123456789012345678901234567890123456789012345678901234567890123456789'.
                    '01234567890123456789012345678901234567890123456789012345678901234567890',
                "<meta name='twitter:card' content='summary' />
<meta name='twitter:title' content='title' />
<meta name='twitter:description' content='description' />
<meta name='twitter:image' content='http://example.org/path/to/img.png' />
<meta name='twitter:image:alt' content='0123456789012345678901234567890123456789012345678901234567890123456789".
                "0123456789012345678901234567890123456789012345678901234567890123456789".
                "0123456789012345678901234567890123456789012345678901234567890123456789".
                "0123456789012345678901234567890123456789012345678901234567890123456789".
                "0123456789012345678901234567890123456789012345678901234567890123456789".
                "0123456789012345678901234567890123456789012345678901234567890123456...' />
"
            ],
        );
    }

    /**
     * This is a test for successfully creating Twitter summary cards.
     *
     * @dataProvider test_successful_creating_provider
     *
     * @param null|string $twittertitle Tag twitter:title
     * @param null|string $twitterdescription Tag twitter:description
     * @param null|string $twittersite Tag twitter:site
     * @param null|string $twitterimage Tag twitter:image
     * @param null|string $twitterimagealt Tag twitter:image:alt
     * @param string $metatags Expected summary card meta tags.
     */
    public function test_successful_creating($twittertitle, $twitterdescription, $twittersite,
                                             $twitterimage, $twitterimagealt, $metatags) {
        $card = new \local_twittercard\cards\summary(
            $twittertitle, $twitterdescription, $twittersite, $twitterimage, $twitterimagealt);

        $this->assertEquals($metatags, $card->create_meta_tags());
    }

    /**
     * Data provider for test_failing_creating().
     *
     * @return array The type-value pairs fixture.
     */
    public function test_failing_creating_provider() {
        return array(
            [
                null, null, null, null, null,
                'twitter:title and twitter:description are required'
            ],
            [
                'title', null, null, null, null,
                'twitter:description is required'
            ],
            [
                null, 'description', null, null, null,
                'twitter:title is required'
            ],
            [
                null, null, '@site', 'http://example.org/path/to/img.png', 'imagealt',
                'twitter:title and twitter:description are required'
            ],
            [
                'title', null, '@site', 'http://example.org/path/to/img.png', 'imagealt',
                'twitter:description is required'
            ],
            [
                null, 'description', '@site', 'http://example.org/path/to/img.png', 'imagealt',
                'twitter:title is required'
            ],
        );
    }

    /**
     * This is a test for when Twitter summary cards creation should fail.
     *
     * @dataProvider test_failing_creating_provider
     * @expectedException InvalidArgumentException
     *
     * @param null|string $twittertitle Tag twitter:title
     * @param null|string $twitterdescription Tag twitter:description
     * @param null|string $twittersite Tag twitter:site
     * @param null|string $twitterimage Tag twitter:image
     * @param null|string $twitterimagealt Tag twitter:image:alt
     * @param string $excmessage Expected exception message.
     */
    public function test_failing_creating($twittertitle, $twitterdescription, $twittersite,
                                          $twitterimage, $twitterimagealt, $excmessage) {
        $card = new \local_twittercard\cards\summary(
            $twittertitle, $twitterdescription, $twittersite, $twitterimage, $twitterimagealt);
        $this->expectExceptionMessage($excmessage);
    }
}
