<?php
namespace TwoLabNet\CarbonFieldsLoader;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Settings extends Plugin {

  /**
    * Create a options/settings page in WP Admin
    */
  function __construct() {

    // Add an options page. You knew that I had to. Maybe... someday...
    $this->add_plugin_options_page();

  }

  private function add_plugin_options_page() {

    Container::make( 'theme_options', self::$settings['data']['Name'] )
      ->set_page_parent('tools.php')
      ->add_tab( __('General'), array(
        Field::make('checkbox', self::$prefix.'enabled', __('Load Carbon Fields'))->set_option_value(1)
          ->help_text(__('Currently, this checkbox does nothing.'))
      ));
  }

}
