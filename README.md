![Build status: master](https://travis-ci.org/scara/moodle-local_twittercard.svg?branch=master)

# Moodle Twitter card local plugin
This Moodle local plugin emits a Twitter summary card for courses.

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
The Twitter card Moodle local plugin is licenced under the GNU GPL v3 or later.
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
- Extracting the first image in section 0 requires a bit of computation.

# Known issues
- The first image added into section 0 of a course must be publicly accessible.
- Multilanguage description in a course could break the twitter:description tag.

# TODO
- Investigate the opportunity to implement more Twitter cards.
