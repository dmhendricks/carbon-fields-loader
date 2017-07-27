<?php
namespace TwoLabNet\CarbonFieldsLoader;

class Plugin {

  public static $settings;
  public static $textdomain;

  public function __construct($_settings) {

    // Set text domain and option prefix
    self::$textdomain = $_settings['data']['TextDomain'];
    self::$settings   = $_settings;

    // Initialize Carbon Fields and verify dependencies
    add_action( 'plugins_loaded', array( 'Carbon_Fields\\Carbon_Fields', 'boot' ) );
    add_action( 'setup_theme', array( $this, 'load_plugin' ) );

  }

  public function load_plugin() {
    if(!$this->verify_dependencies()) return;

    // Run extra loader plugin logic
    new Core();

  }

  /**
    * Verify dependencies (such as Carbon Fields & PHP versions)
    */
  public function verify_dependencies() {

    // Check if outdated version of Carbon Fields loaded
    $plugin_name = self::$settings['data']['Name'];
    $error = null;

    if( version_compare( phpversion(), self::$settings['deps']['php'], '<' ) ) {
      $error = '<strong>' . $plugin_name . ':</strong> ' . __('PHP version ' . self::$settings['deps']['php'] . ' required (' . phpversion() . ' detected).');
    } else if( !defined('\\Carbon_Fields\\VERSION') ) {
      $error = '<strong>' . $plugin_name . ':</strong> ' . __('A fatal error occurred while trying to initialize plugin.');
    } else if( version_compare( \Carbon_Fields\VERSION, self::$settings['deps']['carbon_fields'], '<' ) ) {
      $error = '<strong>' . $plugin_name . ':</strong> ' . __('Unable to load. An outdated version of Carbon Fields has been loaded:' . ' ' . \Carbon_Fields\VERSION) . ' (&gt;= '.self::$settings['deps']['carbon_fields'] . ' ' . __('required') . ')';
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
