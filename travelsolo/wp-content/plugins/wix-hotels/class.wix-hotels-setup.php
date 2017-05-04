<?php

class Wix_Hotels_Setup
{
  const SCHEMA_VERSION = 1;

  static function update_0() {
    add_option('wix_hotels_service_url', 'https://hotels.wix.com/standalone');

    add_option('wix_hotels_secret', '');
    add_option('wix_hotels_hotel_id', '');

    $rooms_page_id = wp_insert_post(array(
      'post_status' => 'draft',
      'post_type' => 'page',
      'post_author' => 1,
      'post_name' => 'wix-hotels-rooms',
      'post_title' => 'Our Rooms',
      'post_content' => '[wix-hotels-rooms]',
      'post_parent' => NULL,
      'comment_status' => 'closed'
    ));
    add_option('wix_hotels_rooms_page_id', $rooms_page_id);
  }

  static function update_1() {
    $rooms_page_id = get_option('wix_hotels_rooms_page_id');
    $rooms_page = get_post($rooms_page_id);
    $post_name = $rooms_page->post_name;
    $post_status = $rooms_page->post_status;

    wp_update_post(array(
      'ID' => $rooms_page_id,
      'post_status' => $post_status === 'draft' ? 'publish' : $post_status,
      'post_name' => $post_name === 'wix-hotels-rooms' ? 'our-rooms' : $post_name
    ));

    $thank_you_page_id = wp_insert_post(array(
      'post_status' => 'publish',
      'post_type' => 'page',
      'post_author' => 1,
      'post_name' => 'thank-you',
      'post_title' => 'Thank You',
      'post_content' => '[wix-hotels-reservation-details]',
      'post_parent' => NULL,
      'comment_status' => 'closed'
    ));
    add_option('wix_hotels_thank_you_page_id', $thank_you_page_id);
  }

  static function activate() {
    $version = (int)get_option('wix_hotels_schema_version', -1);
    if ($version === -1 && get_option('wix_hotels_rooms_page_id')) {
      $version = 0;
    }
    while ($version < self::SCHEMA_VERSION) {
      $version += 1;
      call_user_func(array('Wix_Hotels_Setup', 'update_' . $version));
      update_option('wix_hotels_schema_version', $version);
    }
  }

  static function deactivate() {
    global $wpdb;

    $page_id = get_option('wix_hotels_rooms_page_id');
    if ($page_id) {
      wp_delete_post($page_id, true);
    }
    $page_id = get_option('wix_hotels_thank_you_page_id');
    if ($page_id) {
      wp_delete_post($page_id, true);
    }

    $query = "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'wix_hotels_%'";
    $options = $wpdb->get_col($query);
    if ($options) {
      foreach ($options as $option) {
        delete_option($option);
      }
    }
  }
}