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

namespace local_twittercard;

/**
 * Class helper
 *
 * @package    local_twittercard
 * @copyright  2017 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class helper {
    /**
     * Extract the first available image in the section summary.
     *
     * @param null|stdClass $context Context instance
     * @param null|stdClass $section Related section instance
     * @return null|array An associative array containing the image URL and its alternate text; otherwise, null.
     */
    private static function extract_first_image_section0($context, $section) {
        // Sanity checks.
        if (!$context || !$section) {
            return null;
        }

        // Check whether the section is actually the first one (0).
        $sectionno = $section->section;
        if ($sectionno != 0) {
            return null;
        }
        if (empty($section->summary)) {
            return null;
        }

        $sectiontext = file_rewrite_pluginfile_urls($section->summary, 'pluginfile.php',
            $context->id, 'course', 'section', $section->id);;
        if (empty($sectiontext)) {
            return null;
        }

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml version="1.0" encoding="UTF-8" ?>' . $sectiontext);
        libxml_clear_errors();
        $imgtags = $doc->getElementsByTagName('img');
        $imgtag = $imgtags->item(0);
        if (empty($imgtag)) {
            return null;
        }

        $imgurl = $imgtag->getAttribute('src');
        if (empty($imgurl)) {
            return null;
        }
        $imgalt = $imgtag->getAttribute('alt');

        return array('url' => $imgurl, 'alt' => $imgalt);
    }

    /**
     * Create the HTML meta tags required by a Twitter summary card.
     *
     * @param null|stdClass $context Context instance
     * @param null|stdClass $course Related course instance
     * @return null|string The string containing the proper HTML meta tags; otherwise, null.
     */
    public static function create_card($context, $course) {
        // Trap any catchable error.
        try {
            // Tag twitter:site - Twitter @username of the website.
            $twittersite = get_config('local_twittercard', 'twittersite');

            // Tag twitter:title (required) - Title of content.
            $coursetitle = empty($course->fullname) ? $course->name : $course->fullname;
            $coursetitle = format_string($coursetitle, true, array('context' => \context_system::instance()));

            // Tag twitter:description (required) - Description of content.
            $coursedescr = $coursetitle;
            if (!empty($course->summary)) {
                $coursedescr = format_text($course->summary, FORMAT_HTML,
                    array('context' => \context_system::instance(), 'newlines' => false));
                $coursedescr = html_to_text($coursedescr, -1, false);
            }

            // Tag twitter:image (optional) - URL of image to use in the card.
            // JPG, PNG, WEBP and GIF formats are supported.
            // Only the first frame of an animated GIF will be used. SVG is not supported.
            $imgurl = '';
            $imgalt = '';
            $modinfo = get_fast_modinfo($course);
            $sections = $modinfo->get_section_info_all();
            $section = reset($sections);
            $img = self::extract_first_image_section0($context, $section);
            if (!empty($img)) {
                $imgurl = $img['url'];
                $imgalt = $img['alt'];
            }

            $card = new \local_twittercard\cards\summary($coursetitle, $coursedescr, $twittersite, $imgurl, $imgalt);
            $metatags = $card->create_meta_tags();
            if (!empty($metatags)) {
                return join('', $metatags);
            }
        } catch (Exception $e) {
            // Do nothing here.
            return null;
        }

        return null;
    }
}
