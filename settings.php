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
 * Defines the version and other meta-info about the plugin
 *
 * Setting the $plugin->version to 0 prevents the plugin from being installed.
 * See https://docs.moodle.org/dev/version.php for more info.
 *
 * @package    local_twittercard
 * @copyright  2017 Matteo Scaramuccia <moodle@matteoscaramuccia.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    // Create the new settings page.
    $settings = new admin_settingpage('local_twittercard', get_string('pluginname', 'local_twittercard'));

    // Create.
    $ADMIN->add('localplugins', $settings);

    // Add a checkbox setting to the settings for this page.
    $name = 'local_twittercard/enabled';
    $title = get_string('enabled', 'local_twittercard');
    $description = get_string('enabled_help', 'local_twittercard');
    $default = '0';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $settings->add($setting);

    // Add a string setting to the settings for this page.
    $name = 'local_twittercard/twittersite';
    $title = get_string('twittersite', 'local_twittercard');
    $description = get_string('twittersite_help', 'local_twittercard');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_NOTAGS);
    $settings->add($setting);
}
