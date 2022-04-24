# v1.1.8 (Build: 2022042400)
- [Tests] Added Moodle 4.0.x release branch. Requirements in [MDL-70594](https://tracker.moodle.org/browse/MDL-70594)
- [Tests] Fix `@covers` annotation warnings appeared since [`moodle-plugin-ci` v3.2.5](https://moodlehq.github.io/moodle-plugin-ci/CHANGELOG.html#325---2022-03-31). More details in [`moodle-local_codechecker` v3.1.0](https://github.com/moodlehq/moodle-local_codechecker/commit/e96e9598c4d9f573fcc6e6124baec3919fbce29f)
- [Tests] Fix namespaces according with test file locations
- [Tests] Fix [MOODLE_INTERNAL check](https://github.com/moodlehq/moodle-local_codechecker/commit/2b019ce58d50a62d6f377d025f87a917d03f24ed) according with [Moodle Code Checker](https://github.com/moodlehq/moodle-local_codechecker) [v3.0.5](https://github.com/moodlehq/moodle-local_codechecker/releases/tag/v3.0.5)
- [Tests] Fix tests file names according with [MDL-71049](https://tracker.moodle.org/browse/MDL-71049)
- [Tests] Add local Behat navigation step to stick with one-branch deploy ([MDL-72090](https://tracker.moodle.org/browse/MDL-72090)
- [Tests] Remove Travis CI support
- [Tests] Hack core Behat navigation step to stick with one-branch deploy ([MDL-72093](https://tracker.moodle.org/browse/MDL-72093))
- [Tests] Make `mariadb:10.5` sticky ([MDL-72131](https://tracker.moodle.org/browse/MDL-72131))
- [Tests] PostgreSQL 10 is now required by Moodle 4.0 ([MDL-70594](https://tracker.moodle.org/browse/MDL-70594))

# v1.1.7 (Build: 2021052300)
- [Tests] Align Travis CI to GitHub Actions PHP 8.0 configuration
- [Tests] Limit 'max_input_vars = 5000' requirement to PHP 8.0 ([MDL-71390](https://tracker.moodle.org/browse/MDL-71390))
- [Tests] PHP 8.0 requires 'max_input_vars = 5000' ([MDL-71390](https://tracker.moodle.org/browse/MDL-71390))
- [Tests] Moodle 3.11 supports PHP 8.0 ([MDL-70745](https://tracker.moodle.org/browse/MDL-70745))
- Remove old (`MOODLE_33_STABLE`) `\core_privacy\local\legacy_polyfill` use
- Add more badges
- [Tests] Replace build status badge w/ GHA one
- [Tests] Schedule weekly GHA runs
- [Tests] Add GitHub Actions support

# v1.1.6 (Build: 2020111500)
- [Tests] Add _next_ Moodle under parallel development, 3.11.x on `MOODLE_311_STABLE`
- [Tests] Replace PHPUnit 8.5 deprecations
- [Tests] Add PHPUnit 8 compatibility ([MDL-67673](https://tracker.moodle.org/browse/MDL-67673))
- [Tests] Add support for `310` branch ([MDL-67415](https://tracker.moodle.org/browse/MDL-67415))
- [Tests] Remove Moodle 3.3 from automated testing ([MDL-64725](https://tracker.moodle.org/browse/MDL-64725)).
- [Tests] Bump travis to use `moodlehq/moodle-plugin-ci^3` ([Upgrading from 2.X to 3.0](https://moodlehq.github.io/moodle-plugin-ci/UPGRADE-3.0.html)).

# v1.1.5 (Build: 2020061500)
- [Tests] Moodle 3.9 requires PHP 7.2+ ([MDL-65809](https://tracker.moodle.org/browse/MDL-65809)).
- [Tests] Moodle 3.8.3+ supports PHP 7.4 ([MDL-66260](https://tracker.moodle.org/browse/MDL-66260)).
- [Tests] Moodle _next_, `master` branch, only on `pgsql`.
- [Tests] Moodle 3.5.13+, 3.7.7+, 3.8.4+, 3.9+ requires Node v14 (ready for `lts/fermium`) ([MDL-66109](https://tracker.moodle.org/browse/MDL-66109)).
- [Tests] Our Behat tests do not require JavaScript i.e. remove requirements for Selenium but be ready to activate
          Selenium when it will be required. Refs:
  - [moodle-plugin-ci/#110](https://github.com/blackboard-open-source/moodle-plugin-ci/issues/110).
  - [moodle-plugin-ci/#116](https://github.com/blackboard-open-source/moodle-plugin-ci/issues/116)
- [Tests] Added Moodle 3.9.x release branch.

# v1.1.4 (Build: 2019111700)
- [Tests] Added Moodle 3.8.x release branch.

# v1.1.3 (Build: 2019051900)
- [Tests] Moodle 3.7 requires PHP 7.1+ ([MDL-63276](https://tracker.moodle.org/browse/MDL-63276)).
- [Tests] Moodle 3.7+ runs on PHP 7.3 ([MDL-63420](https://tracker.moodle.org/browse/MDL-63420)).
- [Tests] Project organization [renamed](https://github.com/blackboard-open-source/moodle-plugin-ci/commit/cdd8bb665d853b3b42f99a29c74a5e02fd9b4509#diff-b4ef8fa7c78dc63432f64a355dbb9ffd) for `moodle-plugin-ci` repo.
- [Tests] Switch to OpenJDK headless JRE 8: [blackboard-open-source/moodle-plugin-ci#83](https://github.com/blackboard-open-source/moodle-plugin-ci/issues/83).
- [Tests] Fixed empty FINALLY statement complaints.
- [Tests] Added Moodle 3.7.x release branch.

# v1.1.2 (Build: 2018120200)
- [Tests] Added Moodle 3.6.x release branch.

# v1.1.1 (Build: 2018082500)
- [Tests] Replaced deprecated Behat step (#18).

# v1.1.0 (Build: 2018040900)
- Implemented the Moodle Privacy API (#15, #17).

# v1.0.4 (Build: 2017121000)
- Fixed an error when the course summary is not provided (#13).

# v1.0.3 (Build: 2017111200)
- Added PHP 7.2 to the tested env matrix: Moodle 3.4 supports it.

# v1.0.2 (Build: 2017102700)
- Ready for Moodle 3.4beta (Build: 20171025).

# v1.0.1 (Build: 2017093000)
- Improved test coverage (#5).

# v1.0.0 (Build: 2017092901)
- Do not emit the card when editing the course (#4).
- Do not enable the Twitter summary card by default (#4).

# v0.2 (Build: 2017092900)
- Multi-language content now supported (#2).
- Improved text shortening (#2).

# v0.1 (Build: 2017092300)
- First release.
