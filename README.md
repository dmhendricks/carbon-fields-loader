# Carbon Fields Loader Plugin for WordPress

This is a simple plugin used to load the latest **_release_** version of [Carbon Fields](http://carbonfields.net/).

This plugin is **not** supported by [htmlBurger](https://htmlburger.com), the makers of Carbon Fields.

**What is the point?** None really, unless you want to run a different version of Carbon Fields than what is on the wordpress.org repo.

Currently, this *simply loads the Carbon Fields framework* and nothing more.

I'm not going to do a release until this thing isn't terrible.

## Requirements

(I haven't actually tested this yet - I just created this repo.)

* WordPress 4.0 or higher
* PHP 5.3 or higher

## How do I use it correctly with my plugin/theme?

If you want to use this plugin to load Carbon Fields for use with your plugin or theme, you would probably want to do something like this:

```
function do_plugin_logic() {
   // Load plugin logic
}

add_action( 'plugins_loaded', array( 'Carbon_Fields\\Carbon_Fields', 'boot' ) );
add_action( 'carbon_fields_loaded', 'do_plugin_logic' );
```

## Version Checking

Since it is possible that an older version of the plugin may be installed and/or loaded as a dependency in a theme or plugin, you may wish to do version checking if your code requires a newer version.

**Quick example:**

```
function verify_dependencies( $deps ) {
  // Check if outdated version of Carbon Fields loaded
  $error = false;

  if(!defined('\\Carbon_Fields\\VERSION')) {
    $error = '<strong>' . __('My Plugin Name', 'my-text-domain') . ':</strong> ' . __('A fatal error occurred while trying to load dependencies.', 'my-text-domain');
  } else if( version_compare( \Carbon_Fields\VERSION, $deps['carbon_fields'], '<' ) ) {
    $error = '<strong>' . __('My Plugin Name', 'my-text-domain') . '] . ':</strong> ' . __('Danger, Will Robinson! An outdated version of Carbon Fields has been loaded: ' . \Carbon_Fields\VERSION) . ' (&gt;= ' . $deps['carbon_fields'], 'my-text-domain') . ' ' . __('required', 'my-text-domain') . ')';
  }

  if($error) {
    add_action( 'admin_notices', function() {
      $class = 'notice notice-error';

      printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $error ) );
    });
  }

  return !$error;
}

function do_plugin_logic() {
  if(verify_dependencies(['carbon_fields' => '2.0.0'])) {
    // Load plugin logic
  }
}

add_action( 'plugins_loaded', array( 'Carbon_Fields\\Carbon_Fields', 'boot' ) );
add_action( 'carbon_fields_loaded', 'do_plugin_logic' );
```

## Frequently Asked Questions

*Q: I get a fatal error when I activate this plugin. What do I do?*

A: This may occur when you are running an outdated version of the Carbon Fields plugin and/or have a plugin/theme that includes and outdated version as a dependency. The only fix is the delete this one or update the plugins/themes that require it.

*Q: How do I update this thing to use a newer version or a different branch?*

A: If you just want to pull the latest release version of Carbon Fields from the repo, run `composer update`. If you want to pull a different branch, open *composer.json* and edit the line: `"htmlburger/carbon-fields": ">=2.0.0"`. Set the version to `"dev-branch"` (for example, if you want the *development* branch, set it to `"dev-development"`), then run `composer update`.

*Q: How can I get auto-updates?*

A: Install [GitHub Updater](https://github.com/afragen/github-updater).

## Changelog

**2.0.3**
* Initial commit
