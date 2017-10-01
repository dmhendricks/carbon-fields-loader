[![Author](https://img.shields.io/badge/author-Daniel%20M.%20Hendricks-lightgrey.svg?colorB=9900cc)](https://www.danhendricks.com)
[![Latest Version](https://img.shields.io/github/release/dmhendricks/carbon-fields-loader.svg)](https://github.com/dmhendricks/carbon-fields-loader/releases)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://paypal.me/danielhendricks)
[![WP Engine](https://img.shields.io/badge/WP%20Engine-Compatible-orange.svg)](http://bit.ly/WPEnginePlans)
[![GitHub License](https://img.shields.io/badge/license-GPLv2-yellow.svg)](https://raw.githubusercontent.com/dmhendricks/carbon-fields-loader/master/LICENSE)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/dmhendricks/carbon-fields-loader.svg?style=social)](https://twitter.com/danielhendricks)

# Carbon Fields Loader Plugin for WordPress

This is a simple plugin that may be used to load the latest **_release_** version of [Carbon Fields](http://carbonfields.net/).

This plugin is **_not_** supported or maintained by [htmlBurger](https://htmlburger.com) and team, the creators and maintaners of [Carbon Fields](https://carbonfields.net/). The author of this loader plugin has no affiliation with htmlBurder or the Carbon Fields team.

* [Official Carbon Fields Framework Documentation](https://carbonfields.net/docs/)
* [Usage Examples for this Loader Plugin](https://github.com/dmhendricks/carbon-fields-loader/wiki/)

## Requirements

* WordPress 4.0 or higher
* PHP 5.3 or higher (using the `CFL_OPTIONS` constant requires PHP 7 or higher)

**Note:** This plugin will deactivate itself if a legacy version Carbon Fields is loaded (either via plugin or as a dependency of a plugin/theme). Legacy versions and current releases of Carbon Fields are not compatible and may not be concurrently loaded.

## Options

Because we don't like "admins" monkeying around and disabling (or touching) things, options are set with constants in `wp-config.php`.

### PHP 5.3 and Higher

```
define( 'CFL_MIN_VERSION', '2.1.0' );
```

Sets the minimum supported loaded version of Carbon Fields to >=2.1.0.

```
define( 'CFL_DISABLE_UPDATE_NOTIFICATION', true );
```

Disables update notifications for this plugin. (Only relevant if [GitHub Updater](https://github.com/afragen/github-updater) is also installed.) This can be useful if you use GitHub Updater for other plugins but don't want your code to break because somebody clicked "Update" without testing first.

```
define( 'CFL_REMOVE_PLUGIN_ACTIONS', 'deactivate' );
```

Removes the "Deactivate" action link for this plugin from Plugins > Installed Plugins.
* Set `CFL_REMOVE_PLUGIN_ACTIONS` to `true` to remove **_all_** action links.
* Alternatively, you may also set `CFL_DISABLE_DEACTIVATE` to true to remove the _Deactivate_ action link only.

```
define( 'CFL_HIDE_PLUGIN', true );
define( 'CFL_HIDE_GITHUB_UPDATER', true );
```

Hides this plugin and GitHub Updater from Plugins > Installed Plugins in WP Admin.

```
define( 'CFL_DESCRIPTION_NOTICE', '<strong>This plugin is required for the site to work!</strong>' );
```

Allows you to append text to this plugin's description in Plugins > Installed Plugins.

### PHP 7.0 and Higher

You may use an array for the `CFL_REMOVE_PLUGIN_LINKS` constant:

```
define( 'CFL_REMOVE_PLUGIN_LINKS', ['deactivate', 'edit'] );
```

This removes both the 'Deactivate' and 'Edit' action links from Plugins > Installed Plugins.

However, since you're running a [non-legacy](https://en.wikipedia.org/wiki/PHP#Release_history) version of PHP, you may be more concise.

```
define( 'CFL_OPTIONS', array( ... ) );
```

#### Parameters

* `min_version` (string) - Set the minimum supported loaded version of Carbon Fields. This is short form if you don't want to use `deps`.
* `deps` (array) - Set minimum versions for PHP (`'php'`) and Carbon Fields (`'carbon_fields'`). **NB!** The minimum version of Carbon Fields set in `deps` takes precedence over the `min_version` setting. If you have boths set, this value will be used.
* `hide_plugins` (mixed) - If set to `true` (bool), hides this plugin *and* GitHub Updater. Array `['carbon-fields-loader', 'github-updater']` or string `'carbon-fields-loader'` may be used selectively choose.
* `remove_actions` (mixed) - If set to `true` (bool), removes *all* action links (ie, "Deactivate" and "Edit"). Array `['deactivate', 'edit']` ("Deactivate" and "Edit" links) or string `'deactivate'` ("Deactivate" link only) may be used to selectively choose.
* `disable_updates` (bool) - If set to true, disables update notifications for **_this_** plugin only.
* `description_notice` (string) - Allows you to append text to this plugin's description in the same way that defining `CFL_DESCRIPTION_NOTICE` does.

#### Examples

```
define( 'CFL_OPTIONS' , ['min_version' => '2.1.0', 'hide_plugins' => true ] );
```

* Carbon Fields 2.1.0 or higher must be loaded, else notice is displayed.
* This plugin *and* [GitHub Updater](https://github.com/afragen/github-updater) will be hidden from Plugins > Installed Plugins.

```
define( 'CFL_OPTIONS' , ['deps' => [ 'carbon_fields' => '2.1.0', 'php' => '5.3.29' ], 'hide_plugins' => ['carbon-fields-loader', 'github-updater'], 'disable_updates' => true ] );
````

* Carbon Fields >=2.1.0 and >=PHP 5.3.29 must be loaded, else notice is displayed.
* This plugin and GitHub Updater are hidden from Plugins > Installed Plugins.
* Update notifications are disabled for this plugin. (If [GitHub Updater](https://github.com/afragen/github-updater) is installed.)

```
define( 'CFL_OPTIONS' , ['min_version' => '2.1.0', 'hide_plugins' => 'carbon-fields-loader', 'remove_actions' => ['deactivate', 'edit'], 'disable_updates' => true ] );
```

* Carbon Fields 2.1.0 or higher must be loaded, else notice is displayed.
* This plugin (but not GitHub Updater) is hidden from Plugins > Installed Plugins.
* Removes "Deactivate" and "Edit" action links from this plugin.
* Update notifications are disabled for this plugin.

## Frequently Asked Questions

**_Q: I get a fatal error when I activate this plugin. What do I do?_**

A: This may occur when you are running an outdated version of the Carbon Fields plugin and/or have a plugin/theme that includes and outdated version as a dependency. Although this plugin does appropriate version checking, other plugins/themes may not. The only fix is the delete this one or update the plugins/themes that require it.

**_Q: How do I properly use this loader with my plugin/theme?_**

Please see the wiki for [usage examples](https://github.com/dmhendricks/carbon-fields-loader/wiki#usage-with-plugintheme).

**_Q: How do I update this plugin to use a newer version or a different branch of the Carbon Fields Framework?_**

A: If you just want to pull the latest release version of Carbon Fields from the repo, run `composer update`. If you want to pull a different branch, open *composer.json* and edit the line: `"htmlburger/carbon-fields": "^2.1.0"`. Set the version to `"dev-branch"` (for example, if you want the *development* branch, set it to `"dev-development"`), then run `composer update`.

**_Q: How can I get auto-updates?_**

A: Install [GitHub Updater](https://github.com/afragen/github-updater).

## Change Log

Release changes are noted on the [Releases](https://github.com/dmhendricks/carbon-fields-loader/releases) page.

#### Branch: `master`

* None since release

## Credits

Please support [humans.txt](http://humanstxt.org/). It's an initiative for knowing the people behind a web site. It's an unobtrusive text file that contains information about the different people who have contributed to building the web site.

**Carbon Fields**

	URL: http://carbonfields.net/
	Author: htmlBurger.com
	Twitter: @htmlburger
	Author URI: https://htmlburger.com/
	Location: London, England
