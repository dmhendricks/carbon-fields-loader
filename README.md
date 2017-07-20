# Carbon Fields Loader WordPress Plugin

This is a simple plugin used to load the latest **_release_** version of [Carbon Fields](http://carbonfields.net/).

This plugin is **not** officially supported by htmlBurger, the makers of Carbon Fields.

**What is the point?** None really, unless you want to run a different version of Carbon Fields than what is on the wordpress.org repo.

Currently, this *simply loads Carbon Fields* and nothing more.

### Potential Features

* I need to come up with a reason to include a settings page, [#obviously](https://twitter.com/hashtag/obviously). It would be a good way to test to make sure everything is in place.
* Maybe add some useful jQuery-Fu to manipulate forms. Maybe add some hooks or settings to do this for you.

### Requirements

(I haven't actually tested this yet - I just created this repo.)

* WordPress 4.0 or higher
* PHP 5.3.2 or higher (although if you're running <5.5 I probably won't care)

## How do I use it correctly with my plugin/theme?

TODO

## Frequently Asked Questions

*Q: I get a fatal error when I activate this plugin. What do I do?*

A: This may occur when you are running an outdated version of the Carbon Fields plugin and/or have a plugin/theme that includes and outdated version as a dependency. The only fix is the delete this one or update the plugins/themes that require it.

*Q: How do I update this thing to use a newer version or a different branch?*

A: If you just want to pull the latest release version of Carbon Fields from the repo, run `composer update`. If you want to pull a different branch, open *composer.json* and edit the line: "htmlburger/carbon-fields": ">=2.0.0". Set the version to "dev-branch" (for example, if you want the *development* branch, set it to "dev-development"), then run `composer update`.

*Q: How can I get auto-updates?*

A: Install [GitHub Updater](https://github.com/afragen/github-updater).

## Changelog

**2.0.3 (master)**
* Initial commit
