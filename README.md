![Build status: master](https://travis-ci.org/scara/moodle-local_twittercard.svg?branch=master)
![PHP](https://img.shields.io/badge/PHP-v5.6%20%2F%20v7.0%20%2F%20v7.1%20%2F%20v7.2-blue.svg)
![Moodle](https://img.shields.io/badge/Moodle-v3.3%20to%20v3.4-orange.svg)

# Moodle Twitter card local plugin
This Moodle local plugin emits a Twitter summary card for courses.

The Twitter Summary Card in the course homepage will give kind of preview of the content of your Moodle course by using the information provided by mean of:
- the course title
- the course description
- an optional image, being the first added in Section #0. Beware that this image should be publicly available regardless the user being enrolled into that course

If you want to deepen what a Twitter Summary Card is, more details are available at:
- https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/summary
- https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/markup

# Requirements
- Moodle 3.3 (build 2017051500 or later)

# Installation
To install using _git_, type this command in the root of your Moodle installation:
```
git clone git://github.com/scara/moodle-local_twittercard.git ./local/twittercard
```
Then add `/local/twittercard` to your `gitignore` or local `exclude` files, e.g.:
```
echo '/local/twittercard' >> .git/info/exclude
```
Alternatively, download the _tar.gz_/_zip_ respectively from:
- https://github.com/scara/moodle-local_twittercard/tarball/master
- https://github.com/scara/moodle-local_twittercard/zipball/master

and uncompress it into the `local` folder.
Then rename the new folder into `twittercard`.

Log into your Moodle instance as _admin_: the installation process will start.
Alternatively, visit the _Site administration > Notifications_ page.

After you have installed this local plugin, you'll need to configure it under
_Site administration -> Plugins -> Local plugins -> Twitter card_ in the _Settings_ block.

# License
The Twitter social icons used in the plugins list are licensed as described in https://about.twitter.com/en_us/company/brand-resources.html#social-icons

The Twitter card Moodle local plugin is licenced under the GNU GPL v3 or later.<br/>
Copyright (c) 2017 Matteo Scaramuccia <moodle@matteoscaramuccia.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

# Performances
- Creating the card, e.g. when extracting the first image in section 0, requires a bit of computation.

# Known issues
- The first image added into section 0 of a course must be publicly accessible.
- This plugin doesn't automagically log the
[Twitterbot](https://developer.twitter.com/en/docs/tweets/optimize-with-cards/guides/getting-started#url-crawling-caching)
User-Agent (`"Twitterbot/1.0"`) in ([yet](https://github.com/scara/moodle-local_twittercard/issues/10)) so you need
to take care of guest access in those courses exposed via a Twitter card.
More details at [MDL-61586](https://tracker.moodle.org/browse/MDL-61586).
# TODO
- Investigate the opportunity to implement more Twitter cards.
