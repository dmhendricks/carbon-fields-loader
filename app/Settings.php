<?php
namespace TwoLabNet\CarbonFieldsLoader;

class Settings extends Plugin {

  protected static $options;

  public function __construct() {

    self::$options = self::$settings['options'];

    // Hide plugin(s) & append notice to plugin description
    if( self::$options['hide_plugins'] || self::$options['description_notice'] ) {
      add_filter( 'all_plugins', array( $this, 'process_plugins_list' ) );
    }

    // Remove plugin action lins
    if( self::$options['remove_actions'] ) {
      add_filter( ( is_multisite() ? 'network_admin_' : '' ) . 'plugin_action_links_' . self::$settings['plugin_file'], array( $this, 'remove_plugin_action_links' ), 10, 4 );
    }

    // Disable updates
    if( self::$options['disable_updates'] ) {
      add_filter( 'site_transient_update_plugins', array( $this, 'disable_plugin_updates' ) );
    }

  }

  /**
    * Remove plugin links (Plugins > Installed Plugins), if defined as constants in wp-config.php
    *
    * Example usage (PHP - any version):
    *    define( 'CFL_REMOVE_PLUGIN_ACTIONS', true ); // Removes all action links
    *    define( 'CFL_REMOVE_PLUGIN_ACTIONS', 'deactivate' ); // Removes 'Deactivate' Link
    * Example usage (PHP >= 7.0):
    *    // Removes "Deactivate" and "Edit" action links
    *    define( 'CFL_REMOVE_PLUGIN_ACTIONS', ['deactivate', 'edit'] );
    *    define( 'CFL_OPTIONS', [ 'remove_actions' => ['deactivate', 'edit'] ] );
    *
    * @since 2.0.4
    */
  public function remove_plugin_action_links( $actions ) {

    // Disable specifically specified links
    $links_to_remove = is_string( self::$options['remove_actions'] ) ? array( self::$options['remove_actions'] ) : self::$options['remove_actions'];

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
    * Modifies Plugins > Installed Plugins list in WP Admin, including removing
    *    hidden plugins and modifying the plugin description.
    *
    * Examples:
    *    define( 'CFL_HIDE_PLUGIN', true );
    *    define( 'CFL_HIDE_GITHUB_UPDATER', true );
    *    define( 'CFL_DESCRIPTION_NOTICE', '<strong>Do not deactivate!</strong>' );
    *
    * @since 2.0.4
    */
  public function process_plugins_list( $plugins ) {
    $hide_plugins = self::$options['hide_plugins'];

    if( $hide_plugins ) {

      foreach( $hide_plugins as $hide_plugin ) {
        $hide_string = '/' . $hide_plugin . '.php';
        foreach( $plugins as $key => $data ) {
          if( stripos( $key, $hide_string ) ) {
            unset( $plugins[$key] );
            break;
          }
        }
      }

    }

    if( self::$options['description_notice'] && !in_array( 'carbon-fields-loader', $hide_plugins ) ) $plugins[self::$settings['plugin_file']]['Description'] .= ' ' . self::$options['description_notice'];

    return $plugins;
  }

  /**
    * Disables plugin update notification for this plugin (only relevant when)
    *    GitHub Updater is installed.
    *
    * Examples:
    *    define( 'CFL_DISABLE_UPDATE_NOTIFICATION', true );
    *    define( 'CFL_OPTIONS', [ 'disable_updates' => true );
    *
    * @since 2.0.5
    */
  public function disable_plugin_updates( $value ) {

    if( !isset( $value->response[self::$settings['plugin_file']] ) ) return $value;
    unset( $value->response[self::$settings['plugin_file']] );
    return $value;

  }

  /**
    * Overrides default settings with those set via constants in wp-config.php
    *
    * @since 2.0.5
    */
  public static function set_options() {

    // Define default options
    $settings = array(
      'hide_plugins' => array(),
      'remove_actions' => array(),
      'disable_updates' => false,
      'description_notice' => null
    );
    $cfl_options = is_array( Utils::get_const('CFL_OPTIONS') ) ? CFL_OPTIONS : null;

    // Is GitHub Updater activated?
    self::$settings['plugins_detected']['github-updater'] = class_exists("Fragen\\GitHub_Updater\\Base");

    // Get dependency overrides
    if( $cfl_options && isset($cfl_options['deps']['carbon_fields']) ) {
      self::$settings['deps']['carbon_fields'] = $cfl_options['deps']['carbon_fields'];
    } else if( $cfl_options && isset($cfl_options['min_version']) ) {
      self::$settings['deps']['carbon_fields'] = $cfl_options['min_version'];
    } else if( Utils::get_const('CFL_MIN_VERSION') ) {
      self::$settings['deps']['carbon_fields'] = Utils::get_const('CFL_MIN_VERSION');
    }
    if( $cfl_options && isset($cfl_options['deps']['php']) ) {
      self::$settings['deps']['php'] = $cfl_options['deps']['php'];
    }

    // Disable update notification
    if( $cfl_options && isset($cfl_options['disable_updates']) && $cfl_options['disable_updates'] ) {
      $settings['disable_updates'] = filter_var($cfl_options['disable_updates'], FILTER_VALIDATE_BOOLEAN);
    } else if( Utils::get_const('CFL_DISABLE_UPDATE_NOTIFICATION') ) {
      $settings['disable_updates'] = filter_var(Utils::get_const('CFL_DISABLE_UPDATE_NOTIFICATION'), FILTER_VALIDATE_BOOLEAN);
    }

    // Remove plugin action links. If multiple constants used, options are merged.
    // Order of precedence (highest to lowest): CFL_OPTIONS, CFL_REMOVE_PLUGIN_ACTIONS, CFL_DISABLE_DEACTIVATE
    $remove_plugin_actions = Utils::get_const('CFL_REMOVE_PLUGIN_ACTIONS');
    if( $remove_plugin_actions ) {
      switch( true ) {
        case is_bool( $remove_plugin_actions ):
          $settings['remove_actions'] = $remove_plugin_actions;
          break;
        case is_string( $remove_plugin_actions ):
          $settings['remove_actions'] = array( $remove_plugin_actions );
          break;
        case is_array( $remove_plugin_actions ):
          $settings['remove_actions'] = array_unique( array_merge( $settings['remove_actions'], $remove_plugin_actions ) );
          break;
      }
    }

    $disable_deactivate = Utils::get_const('CFL_DISABLE_DEACTIVATE');
    if( is_bool( $disable_deactivate ) && $disable_deactivate && is_array( $settings['remove_actions'] ) ) {
      $settings['remove_actions'] = array_unique( array_merge( $settings['remove_actions'], array( 'deactivate' ) ) );
    }

    if( $cfl_options && isset($cfl_options['remove_actions']) && $cfl_options['remove_actions'] ) {
      switch( true ) {
        case is_bool( $cfl_options['remove_actions'] ) || is_array( $cfl_options['remove_actions'] ):
          $settings['remove_actions'] = $cfl_options['remove_actions'];
          break;
        case is_string( $cfl_options['remove_actions'] ):
          $settings['remove_actions'] = array( $cfl_options['remove_actions'] );
          break;
      }
    }

    // Hide plugins
    if( Utils::get_const('CFL_HIDE_PLUGIN') ) {
      $settings['hide_plugins'][] = 'carbon-fields-loader';
    }
    if( Utils::get_const('CFL_HIDE_GITHUB_UPDATER') ) {
      $settings['hide_plugins'][] = 'github-updater';
    }
    if( $cfl_options && isset($cfl_options['hide_plugins']) && $cfl_options['hide_plugins'] ) {
      switch( true ) {
        case is_bool( $cfl_options['hide_plugins'] ):
          $settings['hide_plugins'] = array( 'carbon-fields-loader', 'github-updater' );
          break;
        case is_string( $cfl_options['hide_plugins'] ) && !in_array( $cfl_options['hide_plugins'], $settings['hide_plugins'] ):
          $settings['hide_plugins'][] = $cfl_options['hide_plugins'];
          break;
        case is_array( $cfl_options['hide_plugins'] ):
          $settings['hide_plugins'] = array_unique( array_merge( $cfl_options['hide_plugins'], $settings['hide_plugins'] ) );
          break;
      }

    }

    // Set plugin description notice
    if( $cfl_options && isset($cfl_options['description_notice']) && $cfl_options['description_notice'] ) {
      $settings['description_notice'] = $cfl_options['description_notice'];
    } else if( Utils::get_const('CFL_DESCRIPTION_NOTICE') ) {
      $settings['description_notice'] = CFL_DESCRIPTION_NOTICE;
    }

    self::$settings['options'] = $settings;

  }

}
