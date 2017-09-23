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

defined('MOODLE_INTERNAL') || die();

/**
 * Add extra HTML meta elements according to the Twitter summary card specification.
 *
 * Give plugins an opportunity to add any head elements.
 * The callback must always return a string containing valid html head content.
 *
 * Implemented in MDL-53978 (Moodle 3.3).
 */
function local_twittercard_before_standard_html_head() {
    global $PAGE;

    $enabled = (bool)get_config('local_twittercard', 'enabled');
    list($context, $course, $cm) = get_context_info_array($PAGE->context->id);

    // Sanity checks.
    // 1. Do not emit the card if we're not looking at a course.
    if ($enabled && empty($course)) {
        $enabled = false;
    }
    // 2. Do not emit the card if we're looking at e.g. an activity in a course.
    if ($enabled && !empty($cm)) {
        $enabled = false;
    }

    // Twitter summary card specs: https://dev.twitter.com/cards/types/summary.
    if ($enabled) {
        // Tag twitter:site - Twitter @username of the website.
        $twittersitesetting = get_config('local_twittercard', 'twittersite');
        $twittersite = '';
        if (!empty($twittersitesetting) && ($twittersitesetting[0] === '@')) {
            // Properly quote the text.
            $twittersitesetting = s($twittersitesetting);
            $twittersite = "<meta name='twitter:site' content='$twittersitesetting' />\n";
        }

        // Tag twitter:title - Title of content (max 70 characters).
        $coursetitle = empty($course->fullname) ? $course->name : $course->fullname;
        if (core_text::strlen($coursetitle) > 70) {
            $coursetitle = core_text::substr($coursetitle, 0, 67);
            $coursetitle = $coursetitle . "...";
        }
        // Properly quote the text.
        $coursetitle = s($coursetitle);

        if (!empty($coursetitle)) {
            // Tag twitter:description - Description of content (maximum 200 characters).
            $coursedescr = html_to_text($course->summary, -1, false);
            if (core_text::strlen($coursedescr) > 200) {
                $coursedescr = core_text::substr($coursedescr, 0, 197);
                $coursedescr = $coursedescr . "...";
            }
            // Properly quote the text.
            $coursedescr = s($coursedescr);

            if (!empty($coursedescr)) {
                // Tag twitter:image - URL of image to use in the card. Images must be less than 5MB in size.
                // JPG, PNG, WEBP and GIF formats are supported.
                // Only the first frame of an animated GIF will be used. SVG is not supported.
                $twitterimage = '';
                $modinfo = get_fast_modinfo($course);
                $sections = $modinfo->get_section_info_all();
                $section = reset($sections);
                if ($section) {
                    $sectionno = $section->section;
                    if ($sectionno == 0) {
                        $sectiontext = file_rewrite_pluginfile_urls($section->summary, 'pluginfile.php',
                            $context->id, 'course', 'section', $section->id);;
                        if (!empty($sectiontext)) {
                            $doc = new DOMDocument();
                            @$doc->loadHTML($sectiontext);
                            $imgtags = $doc->getElementsByTagName('img');
                            $imgtag = $imgtags->item(0);
                            if (!empty($imgtag)) {
                                $imgurl = $imgtag->getAttribute('src');
                                if (!empty($imgurl)) {
                                    $supportedexts = array('gif', 'jpg', 'png', 'webp');
                                    // Get the path from the URL.
                                    $path = parse_url($imgurl, PHP_URL_PATH);
                                    // Get the extension from path.
                                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                    if (in_array($ext, $supportedexts)) {
                                        // Properly quote the text.
                                        $imgurl = s($imgurl);
                                        $twitterimage = "<meta name='twitter:image' content='$imgurl' />\n";
                                    }
                                }
                            }
                        }
                    }
                }

                return
                    "<meta name='twitter:card' content='summary' />\n" .
                    $twittersite .
                    "<meta name='twitter:title' content='$coursetitle' />\n" .
                    "<meta name='twitter:description' content='$coursedescr' />\n" .
                    $twitterimage;
            }
        }
    }

    return '';
}
