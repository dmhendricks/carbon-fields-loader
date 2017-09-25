<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Carbon Fields Loader
 * Plugin URI:        https://github.com/dmhendricks/carbon-fields-loader/
 * Description:       A loader plugin for the Carbon Fields framework.
 * Version:           2.1.0
 * Author:            Daniel M. Hendricks
 * Author URI:        https://www.danhendricks.com
 * Text Domain:       cfloader
 * Domain Path:       /languages
 * License:           GPL-2.0
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least:	4.0
 * Tested up to:      4.8.2
 * GitHub Plugin URI: dmhendricks/carbon-fields-loader
 */

/*	Copyright 2017	  Daniel M. Hendricks (https://www.danhendricks.com/)

		This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version 2
    of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if(!defined('WPINC')) die();

require( __DIR__ . '/vendor/autoload.php' );
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// Initialize plugin - Change to use your own namespace
new \TwoLabNet\CarbonFieldsLoader\Plugin(array(
	'data' => get_plugin_data(__FILE__),
	'path' => realpath(plugin_dir_path(__FILE__)).DIRECTORY_SEPARATOR,
	'url' => plugin_dir_url(__FILE__),
	'deps' => array( 'php' => '5.3', 'carbon_fields' => '2.1.0' ),
	'plugin_file' => plugin_basename(__FILE__)
));
?>
