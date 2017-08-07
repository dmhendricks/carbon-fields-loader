<?php
namespace TwoLabNet\CarbonFieldsLoader;

class Utils extends Plugin {

  /**
    * Display a notice/message in WP Admin
    *
    * @param string $msg The message to display.
    * @param string $type The type of notice. Valid values:
    *    error, warning, success, info
    * @param bool $is_dismissible Specify whether or not the user may dismiss
    *    the notice.
    * @since 2.0.0
    */
  public static function show_notice($msg, $textdomain = '', $type = 'error', $is_dismissible = false) {

    add_action( 'admin_notices', function() use (&$msg, &$type, &$is_dismissible) {

      $class = 'notice notice-' . $type . ( $is_dismissible ? ' is-dismissible' : '' );
      $msg = __( $msg, $textdomain );

      printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $msg );

    });

  }

  /**
    * Return constant, if defined (with filter validation, if specified)
    *
    * Example usage:
    *    echo get_const( 'DB_HOST' ); // MySQL host name
    *    echo get_const( 'MY_BOOLEAN_CONST', FILTER_VALIDATE_BOOLEAN );
    *       // null if undefined, true if valid boolean, else false
    *
    * @param string $const The name of constant to retrieve.
    * @param const $filter_validate filter_var() filter to apply (optional).
    *    Valid values: http://php.net/manual/en/filter.filters.validate.php
    * @return mixed Value of constant if specified, else null.
    * @since 2.0.3
    */
  public static function get_const( $const, $filter_validate = null ) {

    if( !defined($const) ) {
      return null;
    } else if( $filter_validate ) {
      return filter_var( constant($const), $filter_validate);
    }
    return constant($const);

  }

  /**
    * Combine function attributes with known attributes and fill in defaults when needed.
    *
    * @param array  $pairs     Entire list of supported attributes and their defaults.
    * @param array  $atts      User defined attributes in shortcode tag.
    * @return array Combined and filtered attribute list.
    * @link https://core.trac.wordpress.org/browser/tags/4.8/src/wp-includes/shortcodes.php#L540 Original source
    * @since 2.0.5
    */
  public static function set_default_atts( $pairs, $atts ) {

    $atts = (array)$atts;
    $result = array();

    foreach ($pairs as $name => $default) {
      if ( array_key_exists($name, $atts) ) {
        $result[$name] = $atts[$name];
      } else {
        $result[$name] = $default;
      }
    }

    return $result;

  }

}
