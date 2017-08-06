<?php
namespace TwoLabNet\CarbonFieldsLoader;

class Plugin {

  protected static $settings;
  protected static $textdomain;

  public function __construct($_settings) {

    // Set text domain and option prefix
    self::$textdomain = $_settings['data']['TextDomain'];
    self::$settings   = $_settings;

    // Get plugin option constants from wp-config.php, if set
    Settings::set_options();

    // Verify dependecies and load plugin logic
    register_activation_hook( self::$settings['plugin_file'], array( $this, 'activate' ) );
    add_action( 'plugins_loaded', array( $this, 'init' ) );

  }

  /**
    * Check plugin dependencies on activation.
    *
    * @since 2.0.5
    */
  public function activate() {

    $dependency_check = $this->verify_dependencies( true, array( 'activate' => true, 'echo' => false ) );
    if( $dependency_check !== true ) die( $dependency_check );

  }

  /**
    * Initialize Carbon Fields and load plugin logic
    *
    * @since 2.0.0
    */
  public function init() {

    add_action( 'after_setup_theme', array( 'Carbon_Fields\\Carbon_Fields', 'boot' ) );

    if( $this->verify_dependencies( 'carbon_fields' ) === true ) {
      add_action( 'carbon_fields_loaded', array( $this, 'load_plugin' ));
    }

  }

  /**
    * Load plugin classes
    *
    * @since 2.0.0
    */
  public function load_plugin() {

    if( !$this->verify_dependencies( 'carbon_fields' ) ) return;

    // Load plugin configuration logic
    new Settings();

  }

  /**
    * Function to verify dependencies, such as if an outdated version of Carbon
    *    Fields is detected.
    *
    * @param string|array|bool $deps A string (single) or array of deps to check. `true`
    *    checks all defined dependencies.
    * @param array $args An array of arguments.
    * @return bool|string Result of dependency check. Returns bool if $args['echo']
    *    is false, string if true.
    * @since 2.0.5
    */
  private function verify_dependencies( $deps = true, $args = array() ) {

    if( is_bool( $deps ) && $deps ) $deps = self::$settings['deps'];
    if( !is_array( $deps ) ) $deps = array( $deps => self::$settings['deps'][$deps] );

    $args = Utils::set_default_atts( array(
      'echo' => true,
      'activate' => true
    ), $args);

    $notices = array();

    foreach( $deps as $dep => $version ) {

      switch( $dep ) {

        case 'php':

          if( version_compare( phpversion(), $version, '<' ) ) {
            $notices[] = __( 'This plugin is not supported on versions of PHP below', self::$textdomain ) . ' ' . self::$settings['deps']['php'] . '.' ;
          }
          break;

        case 'carbon_fields':

          //if( defined('\\Carbon_Fields\\VERSION') || ( defined('\\Carbon_Fields\\VERSION') && version_compare( \Carbon_Fields\VERSION, $version, '<' ) ) ) {
          if( !$args['activate'] && !defined('\\Carbon_Fields\\VERSION') ) {
            $notices[] = __( 'An unknown error occurred while trying to load the Carbon Fields framework.', self::$textdomain );
          } else if ( defined('\\Carbon_Fields\\VERSION') && version_compare( \Carbon_Fields\VERSION, $version, '<' ) ) {
            $notices[] = __( 'An outdated version of Carbon Fields has been detected:', self::$textdomain ) . ' ' . \Carbon_Fields\VERSION . ' (&gt;= '.self::$settings['deps']['carbon_fields'] . ' ' . __( 'required', self::$textdomain ) . ').' . ' <strong>' . self::$settings['data']['Name'] . '</strong> ' . __( 'deactivated.', self::$textdomain ) ;
          }
          break;

        }

    }

    if( $notices ) {

      deactivate_plugins( self::$settings['plugin_file'] );

      $notices = '<ul><li>' . implode( "</li>\n<li>", $notices ) . '</li></ul>';

      if( $args['echo'] ) {
        Utils::show_notice($notices, self::$textdomain, 'error', false);
        return false;
      } else {
        return $notices;
      }

    }

    return !$notices;

  }

}
