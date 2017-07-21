<?php
namespace TwoLabNet\CarbonFieldsLoader;
use Carbon_Fields;

class Plugin {

  public static $settings;
  public static $textdomain;

  public function __construct($_settings) {

    // Set text domain and option prefix
    self::$textdomain = $_settings['data']['TextDomain'];
    self::$settings   = $_settings;

    // Initialize Carbon Fields and verify dependencies
    add_action( 'plugins_loaded', array( 'Carbon_Fields\\Carbon_Fields', 'boot' ) );
    add_action( 'plugins_loaded', array( &$this, 'verify_dependencies' ) );

  }

  public function verify_dependencies() {

    // Check if outdated version of Carbon Fields loaded
    $error = null;

    if( !defined('\\Carbon_Fields\\VERSION') ) {
      $error = '<strong>' . self::$settings['data']['Name'] . ':</strong> ' . __('A fatal error occurred while trying to initialize plugin.');
    } else if( version_compare( \Carbon_Fields\VERSION, self::$settings['deps']['carbon_fields'], '<' ) ) {
      $error = '<strong>' . self::$settings['data']['Name'] . ':</strong> ' . __('Unable to load. An outdated version of Carbon Fields has been loaded:' . ' ' . \Carbon_Fields\VERSION) . ' (&gt;= '.self::$settings['deps']['carbon_fields'] . ' ' . __('required') . ')';
    }

    if($error) $this->show_notice($error, 'error', false);
    return !$error;

  }

  /**
    * Helper function to display a notice in the WP Admin
    */
  private function show_notice($msg, $type = 'error', $is_dismissible = false) {

    if( is_admin() ) {
      $class = 'notice notice-' . $type . ( $is_dismissible ? ' is-dismissible' : '' );
      printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $msg );
    }
  }

}
