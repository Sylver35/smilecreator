# phpBB Breizh Smilies Creator Extension

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Sylver35/smilecreator/badges/quality-score.png?b=1.5.0)](https://scrutinizer-ci.com/g/Sylver35/smilecreator/?branch=1.5.0)
[![Build Status](https://scrutinizer-ci.com/g/Sylver35/smilecreator/badges/build.png?b=1.5.0)](https://scrutinizer-ci.com/g/Sylver35/smilecreator/build-status/1.5.0)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/Sylver35/smilecreator/badges/code-intelligence.svg?b=1.5.0)](https://scrutinizer-ci.com/code-intelligence)

## Minimum Requirements
* phpBB 3.3.13
* PHP 7.2

## Install

1. Download the latest release.
2. Unzip the downloaded release, and change the name of the folder to `smilecreator`.
3. In the `ext` directory of your phpBB board, create a new directory named `sylver35` (if it does not already exist).
4. Copy the `smilecreator` folder to `/ext/sylver35/` (if done correctly, you'll have the main extension class at (your forum root)/ext/sylver35/smilecreator/composer.json).
5. Navigate in the ACP to `Customise -> Manage extensions`.
6. Look for `Breizh Smilies Creator` under the Disabled Extensions list, and click its `Enable` link.

## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `Breizh Smilies Creator` under the Enabled Extensions list, and click its `Disable` link.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/sylver35/smilecreator` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2024 - Sylver35
