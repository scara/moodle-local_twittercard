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
 * Library of interface functions and constants for module twittercard
 *
 * All the core Moodle functions, needed to allow the module to work
 * integrated in Moodle should be placed here.
 *
 * All the twittercard specific functions, needed to implement all the module
 * logic, should go to locallib.php. This will help to save some memory when
 * Moodle is performing actions across all modules.
 *
 * @package    local_twittercard
 * @copyright  2017 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_twittercard\cards;

defined('MOODLE_INTERNAL') || die();

/**
 * Class summary
 *
 * Represents a Twitter summary card.
 *
 * @link https://dev.twitter.com/cards/types/summary Twitter summary card specification
 * @link https://cards-dev.twitter.com/validator Twitter card validator
 *
 * @package    local_twittercard
 * @copyright  2017 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class summary {
    /**
     * The list of the supported extensions for the tag twitter:image.
     * @var array
     */
    private $supportedimgexts = array('gif', 'jpg', 'png', 'webp');

    /**
     * Tag twitter:description.
     * @var null|string
     */
    private $twitterdescription = null;
    /**
     * Tag twitter:imag:alt.
     * @var null|string
     */
    private $twitterimagealt = null;
    /**
     * Tag twitter:imag.
     * @var null|string
     */
    private $twitterimage = null;
    /**
     * Tag twitter:site.
     * @var null|string
     */
    private $twittersite = null;
    /**
     * Tag twitter:title.
     * @var null|string
     */
    private $twittertitle = null;

    /**
     * Twitter summary card constructor.
     *
     * @param string $twittertitle A concise title for the related content.
     * @param string $twitterdescription A description that concisely summarizes the content as appropriate for
     *                                   presentation within a Tweet. You should not re-use the title as the description
     *                                   or use this field to describe the general services provided by the website.
     * @param null|string $twittersite The Twitter @username the card should be attributed to.
     * @param null|string $twitterimage A URL to a unique image representing the content of the page.
     * @param null|string $twitterimagealt A text description of the image conveying the essential nature of an image
     *                                     to users who are visually impaired.
     * @throws \InvalidArgumentException
     */
    public function __construct($twittertitle, $twitterdescription,
                                $twittersite = null, $twitterimage = null, $twitterimagealt = null) {
        // Sanity checks.
        if (empty($twittertitle) && empty($twitterdescription)) {
            throw new \InvalidArgumentException('twitter:title and twitter:description are required');
        }
        if (empty($twittertitle)) {
            throw new \InvalidArgumentException('twitter:title is required');
        }
        if (empty($twitterdescription)) {
            throw new \InvalidArgumentException('twitter:description is required');
        }

        $this->twittertitle = $twittertitle;
        $this->twitterdescription = $twitterdescription;
        $this->twittersite = $twittersite;
        $this->twitterimage = $twitterimage;
        $this->twitterimagealt = $twitterimagealt;
    }

    /**
     * Creates the meta tags representing the Twitter summary card.
     *
     * @return string The meta tags representing the Twitter summary card.
     */
    public function create_meta_tags() {
        // Tag twitter:card => summary.

        // Tag twitter:site (optional) - Twitter @username of the website.
        $twittersitemeta = '';
        if (!empty($this->twittersite) && ($this->twittersite[0] === '@')) {
            // Properly quote the text.
            $twittersiteenc = s($this->twittersite);
            $twittersitemeta = "<meta name='twitter:site' content='$twittersiteenc' />\n";
        }

        // Tag twitter:title (required) - Title of content (max 70 characters).
        $coursetitle = $this->twittertitle;
        if (\core_text::strlen($coursetitle) > 70) {
            $coursetitle = \core_text::substr($coursetitle, 0, 67);
            $coursetitle = $coursetitle . "...";
        }
        // Properly quote the text.
        $coursetitleenc = s($coursetitle);

        // Tag twitter:description (required) - Description of content (maximum 200 characters).
        $coursedescr = $this->twitterdescription;
        if (\core_text::strlen($coursedescr) > 200) {
            $coursedescr = \core_text::substr($coursedescr, 0, 197);
            $coursedescr = $coursedescr . "...";
        }
        // Properly quote the text.
        $coursedescrenc = s($coursedescr);

        // Tag twitter:image (optional) - URL of image to use in the card. Images must be less than 5MB in size.
        // JPG, PNG, WEBP and GIF formats are supported.
        // Only the first frame of an animated GIF will be used. SVG is not supported.
        $twitterimagemeta = '';
        $twitterimagealtmeta = '';
        if (!empty($this->twitterimage)) {
            // Get the path from the URL.
            $path = parse_url($this->twitterimage, PHP_URL_PATH);
            if ($path !== false) {
                // Get the extension from path.
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                if (in_array($ext, $this->supportedimgexts)) {
                    // Properly quote the text.
                    $imgurlenc = s($this->twitterimage);
                    $twitterimagemeta = "<meta name='twitter:image' content='$imgurlenc' />\n";

                    if (!empty($this->twitterimagealt)) {
                        $imgalt = $this->twitterimagealt;
                        if (\core_text::strlen($imgalt) > 420) {
                            $imgalt = \core_text::substr($imgalt, 0, 417);
                            $imgalt = $imgalt . "...";
                        }
                        // Properly quote the text.
                        $imgaltenc = s($imgalt);
                        $twitterimagealtmeta = "<meta name='twitter:image:alt' content='$imgaltenc' />\n";
                    }
                }
            }
        }

        return
            "<meta name='twitter:card' content='summary' />\n" .
            $twittersitemeta .
            "<meta name='twitter:title' content='$coursetitleenc' />\n" .
            "<meta name='twitter:description' content='$coursedescrenc' />\n" .
            $twitterimagemeta .
            $twitterimagealtmeta;
    }
}
