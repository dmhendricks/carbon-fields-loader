<?php
namespace TwoLabNet\CarbonFieldsLoader;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Settings extends Plugin {

  /**
    * Create a options/settings page in WP Admin
    */
  function __construct() {

    // Add an options page. You knew that I had to.
    $this->add_plugin_options_page();

  }

  private function add_plugin_options_page() {

    // Coming soon... maybe... someday.

  }

}
