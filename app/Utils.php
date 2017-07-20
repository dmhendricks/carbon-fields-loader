<?php
namespace TwoLabNet\CarbonFieldsLoader;

class Utils extends Plugin {

  public static function show_notice($msg, $type = 'error', $is_dismissible = false) {
    if(is_admin()) {
      $class = 'notice notice-'.$type.($is_dismissible ? ' is-dismissible' : '');
      $msg = __( $msg, self::$settings['data']['TextDomain'] );

      printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $msg );
    }
  }

  public static function array_merge_recursive_distinct( array &$array1, array &$array2 ) {
    // Attribution: http://php.net/manual/en/function.array-merge-recursive.php#92195
    $merged = $array1;
    foreach ( $array2 as $key => &$value )
    {
      if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) ) {
        $merged [$key] = self::array_merge_recursive_distinct ( $merged [$key], $value );
      } else {
        $merged [$key] = $value;
      }
    }
    return $merged;
  }

}
