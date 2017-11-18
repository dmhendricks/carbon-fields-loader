# Carbon Fields Loader
Contributors: hendridm
Tags: custom, fields, custom fields, advanced, repeater, post, type, text, textarea, file, image, rich text, wysiwyg, select, dropdown, checkbox, radio, association, relationship, map, taxonomy, term, user, comment, option, options, widget, simple fields, magic fields, more fields, post meta, term meta, user meta, comment meta, theme options, custom widget, nested fieldsvisibility,multisite,network,plugins,hide,updates
Plugin URI: https://github.com/dmhendricks/carbon-fields-loader/
Donate link: https://paypal.me/danielhendricks
Requires at least: 4.0
Tested up to: 4.8.2
Stable tag: 2.1.1
License: GPL-2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Loads the latest release of the Carbon Fields framework.

## Description

This is a simple plugin used to load the latest _release_ version of [Carbon Fields](http://carbonfields.net/).

This plugin is **not** officially supported by htmlBurger, the makers of Carbon Fields.

Please see the [GitHub page](https://github.com/dmhendricks/carbon-fields-loader) for usage examples and configuration options.

### Requirements

* WordPress 4.0 or higher
* PHP 5.3 or higher

### Carbon Fields - Usage, Documentation & Resources

* Loader Documentation & Usage (GitHub): https://github.com/dmhendricks/carbon-fields-loader
* Carbon Fields: http://carbonfields.net/
* Carbon Fields Documentation: http://carbonfields.net/docs/
* Carbon Fields GitHub Repository: https://github.com/htmlburger/carbon-fields
* Support: https://github.com/dmhendricks/carbon-fields-loader/issues/

### Installation Instructions

1. Install Carbon Fields Loader by downloading the latest release from the [GitHub](https://github.com/dmhendricks/carbon-fields-loader) repo.
2. Extract archive and copy/upload to your `wp-content/plugins` directory.
3. Activate the plugin in WP Admin &gt; Settings

## Frequently Asked Questions

#### Q. I get a fatal error when I activate this plugin. What do I do?
A. This may occur when you are running an outdated version of the Carbon Fields plugin and/or have a plugin/theme that includes and outdated version as a dependency. The only fix is the delete this one or update the plugins/themes that require it.

#### Q. How do I get auto-updates?
A: Install [GitHub Updater](https://github.com/afragen/github-updater).

#### Q. How do I update this thing to use a newer version or a different branch?
If you just want to pull the latest release version of Carbon Fields from the repo, run `composer update`. If you want to pull a different branch, open *composer.json* and edit the line: `"htmlburger/carbon-fields": "2.1.1"`. Set the version to `"dev-branch"` (for example, if you want the *development* branch, set it to `"dev-development"`), then run `composer update`.
