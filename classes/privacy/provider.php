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
 * Privacy Subsystem implementation for local_twittercard.
 *
 * @package    local_twittercard
 * @copyright  2018 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_twittercard\privacy;

defined('MOODLE_INTERNAL') || die();

// Backward compat.
interface_exists('\core_privacy\local\metadata\null_provider') || die();

/**
 * Privacy Subsystem implementation for local_twittercard implementing null_provider.
 *
 * @package    local_twittercard
 * @copyright  2018 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    // This plugin does not store any personal user data.
    \core_privacy\local\metadata\null_provider {

    // 3.4+ runs only on PHP 7.0+ so 'return type declaration' is supported and required,
    // due to the way the privacy null_provider interface has been implemented in 3.4+.
    // A polyfill - /privacy/classes/local/legacy_polyfill.php - comes to help here in keeping the same plugin implementation,
    // regardless the Moodle version, 3.3 vs 3.4+.
    // Ref.: https://docs.moodle.org/dev/Privacy_API#Difference_between_Moodle_3.3_and_more_recent_versions.

    // This is the trait to be included to actually benefit from the polyfill.
    use \core_privacy\local\legacy_polyfill;

    /**
     * Get the language string identifier with the component's language
     * file to explain why this plugin stores no data.
     *
     * @return  string
     */
    public static function _get_reason() {
        return 'privacy:metadata';
    }
}
