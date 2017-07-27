<?php
namespace TwoLabNet\CarbonFieldsLoader;

class Core extends Plugin {

  public function __construct() {

    // Hide plugin if desired
    if( $this->get_const('CFL_HIDE_PLUGIN') ) {
      add_filter( 'all_plugins', array( $this, 'hide_plugin' ) );
    }

    // Remove plugin links if configured
    if( $this->get_const('CFL_REMOVE_PLUGIN_LINKS') ) {
      add_filter( ( is_multisite() ? 'network_admin_' : '' ) . 'plugin_action_links_' . self::$settings['plugin_file'], array( $this, 'remove_plugin_links' ), 10, 4 );
    }

  }

  /**
    * Remove plugin links (Plugins > Installed Plugins), if defined as constants in wp-config.php
    *
    * Example usage (PHP - any version):
    *    define( 'CFL_REMOVE_PLUGIN_LINKS', true ); // Removes all action links
    *    define( 'CFL_REMOVE_PLUGIN_LINKS', 'deactivate' ); // Removes 'Deactivate' Link
    * Example usage (PHP >= 7.0):
    *    // Removes "Deactivate" and "Edit" action links
    *    define( 'CFL_REMOVE_PLUGIN_LINKS', ['deactivate', 'edit'] );
    */
  public function remove_plugin_links( $actions ) {

    // Disable specifically specified links
    $links_to_remove = $this->get_const('CFL_REMOVE_PLUGIN_LINKS');
    if( !$links_to_remove ) return;
    if( is_string( $links_to_remove ) ) $links_to_remove = array($links_to_remove);

    if( is_bool( $links_to_remove ) ) {

      // Remove all links
      return array();

    } else if( is_array( $links_to_remove ) ) {

      // Remove specified link(s)
      foreach( $links_to_remove as $link ) {
        if( array_key_exists( $link, $actions ) ) unset( $actions[$link] );
      }

    }

    return $actions;

  }

  /**
    * Hide this plugin from Plugins > Installed Plugins in WP Admin, if defined in wp-config.php
    *
    * Usage:
    *    define( 'CFL_HIDE_PLUGIN', true );
    */
  public function hide_plugin( $plugins ) {
    unset( $plugins[self::$settings['plugin_file']] );
    return $plugins;
  }

  /**
    * Check if constant defined, and if so, return value (with filter
    *    validation, if desired)
    *
    * Example usage:
    *    echo get_const( 'DB_HOST' ); // MySQL host name
    *    echo get_const( 'MY_BOOLEAN_CONST', FILTER_VALIDATE_BOOLEAN );
    *       // null if undefined, true if valid boolean, else false
    *
    * @param string The name of constant to retrieve.
    * @param const (optional) filter_var() filter to apply.
    *    Valid values: http://php.net/manual/en/filter.filters.validate.php
    *
    * @return mixed Value of constant if specified, else null.
    */
  private function get_const( $const, $filter_validate = null ) {

    if( !defined($const) ) {
      return null;
    } else if( $filter_validate ) {
      return filter_var( constant($const), $filter_validate);
    }
    return constant($const);

  }

}
