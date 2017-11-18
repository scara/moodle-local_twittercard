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

    // Trap any catchable error.
    try {
        $enabled = (bool)get_config('local_twittercard', 'enabled');
        if (!$enabled) {
            return '';
        }

        list($context, $course, $cm) = get_context_info_array($PAGE->context->id);

        // Sanity checks.
        // 1. Do not emit the card if we're not looking at a course.
        if (empty($course)) {
            return '';
        }
        // 2. Do not emit the card if we're looking at e.g. an activity in a course.
        if (!empty($cm)) {
            return '';
        }
        // 3. Do not emit the card if we're editing the course.
        if ($PAGE->user_is_editing()) {
            return '';
        }
        // 4. Do not emit the card if we're editing the course settings.
        $courseediturlpath = 'course/edit.php';
        if (substr($PAGE->url->get_path(), -strlen($courseediturlpath)) === $courseediturlpath) {
            return '';
        }

        $card = \local_twittercard\helper::create_card($context, $course);
        if (!empty($card)) {
            return $card;
        }
    } finally {
        // Do nothing here.
    }

    return '';
}
