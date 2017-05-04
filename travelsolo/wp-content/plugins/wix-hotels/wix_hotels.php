<?php
/*
Plugin Name: Wix Hotels
Version: 1.6.3
Description: Wix Hotels is your all-in-one online booking system. Easy to use and packed with features. You get everything you need to manage your reservations, room inventory, payments, and more.
Author: Wix Hotels
Author URI: http://www.wix.com/hotels/website
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wix-hotels
Domain Path: /languages
*/

define('WIX_HOTELS_VERSION', '1.6.3');
define('WIX_HOTELS__PLUGIN_URL', plugin_dir_url(__FILE__));
define('WIX_HOTELS__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WIX_HOTELS__SERVICE_BASE_URL', 'https://hotels.wix.com/standalone');

require 'class.wix-hotels.php';
require 'class.wix-hotels-setup.php';
require 'class.wix-hotels-client.php';
require 'class.wix-hotels-admin.php';
require 'class.wix-hotels-iframe.php';
require 'class.wix-hotels-embed.php';
require 'class.wix-hotels-search-widget.php';
require 'class.wix-hotels-availability-calendar-widget.php';
require 'class.wix-hotels-counter.php';

if (is_admin()) {
  add_action('admin_init', array('Wix_Hotels_Admin', 'init'));
  add_action('admin_notices', array('Wix_Hotels_Admin', 'add_notices'));
  add_action('admin_menu', array('Wix_Hotels_Admin', 'add_pages'));
  add_action('wp_loaded', array('Wix_Hotels_Setup', 'activate'));
}

function wix_hotels_register_search_widget() {
  register_widget('Wix_Hotels_Search_Widget');
}
add_action('widgets_init', 'wix_hotels_register_search_widget');

function wix_hotels_register_availability_calendar_widget() {
  register_widget('Wix_Hotels_Availability_Calendar_Widget');
}
add_action('widgets_init', 'wix_hotels_register_availability_calendar_widget');

add_action('admin_bar_menu', array('Wix_Hotels_Admin', 'modify_admin_bar'), 9999);
add_action('admin_enqueue_scripts', array('Wix_Hotels_Admin', 'enqueue_admin_bar_scripts'));
add_action('wp_enqueue_scripts', array('Wix_Hotels_Admin', 'enqueue_admin_bar_scripts'));

add_shortcode('wix-hotels-rooms', array('Wix_Hotels_Embed', 'rooms_list'));
add_shortcode('wix-hotels-reservation-details', array('Wix_Hotels_Embed', 'reservation_details'));
add_shortcode('wix-hotels-availability-calendar', array('Wix_Hotels_Embed', 'availability_calendar_shortcode'));
add_shortcode('wix-hotels-search-widget', array('Wix_Hotels_Embed', 'search_widget_shortcode'));

register_deactivation_hook(__FILE__, array('Wix_Hotels_Setup', 'deactivate'));
