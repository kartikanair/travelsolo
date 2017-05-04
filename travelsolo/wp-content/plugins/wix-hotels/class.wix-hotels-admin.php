<?php

class Wix_Hotels_Admin
{
  const CONNECT_ACTION = 'connect_to_wix_hotels';

  static function add_pages() {
    $backoffice_hook = add_menu_page(
      'Wix Hotels',
      'Wix Hotels',
      'edit_posts',
      'wix_hotels',
      array('Wix_Hotels_Admin', 'render_backoffice_page'),
      Wix_Hotels::url('images/menu-icon.png'),
      3
    );

    add_action(
      'load-' . $backoffice_hook,
      array('Wix_Hotels_Admin', 'enqueue_backoffice_scripts')
    );
  }

  static function init() {
    if (!empty($_GET['token']) && !empty($_GET['instance_id']) &&
        wp_verify_nonce($_GET['wp_nonce'], self::CONNECT_ACTION))
    {
      $token = $_GET['token'];
      $instance_id = $_GET['instance_id'];
      $secret = Wix_Hotels_Client::getSecret($token, $instance_id);
      if ($secret) {
        update_option('wix_hotels_secret', $secret);
        update_option('wix_hotels_hotel_id', $instance_id);
        wp_redirect(admin_url('admin.php?page=wix_hotels'));
        exit;
      }
    }
  }

  static function add_notices() {
    $current = get_current_screen();
    if ($current->parent_base === 'plugins' && !get_option('wix_hotels_secret')) {
      echo Wix_Hotels::admin_success(
        Wix_Hotels::render('/admin/_notice.php', array(
          'link' => admin_url('admin.php?page=wix_hotels')
        )),
        true // dismissible
      );
    }
  }

  static function modify_admin_bar($wp_admin_bar) {
    $wp_admin_bar->add_node(array(
      'id' => 'wix-hotels',
      'title' => 'Wix Hotels',
      'href' => admin_url('admin.php?page=wix_hotels')
    ));
  }

  static function render_backoffice_page() {
    $secret = get_option('wix_hotels_secret');
    $hotel_id = get_option('wix_hotels_hotel_id');

    if (empty($secret) || empty($hotel_id)) {
      $url = Wix_Hotels::serviceUrl('/connect');
      Wix_Hotels::view('/admin/onboarding.php', array(
        'url' => $url,
        'redirect_to' => admin_url('admin.php?page=wix_hotels'),
        'wp_nonce' => wp_create_nonce(self::CONNECT_ACTION)
      ));
    } else {
      $instance = Wix_Hotels_Client::instance(true);
      $url = 'https://hotels.wix.com/back-office.html';
      Wix_Hotels::view('/admin/back-office.php', array(
        'url' => $url . '?instance=' . $instance . '&viewMode=standalone&wordpress=true&locale=en&cacheKiller=' . time()
      ));
    }
  }

  static function enqueue_backoffice_scripts() {
    wp_enqueue_style(
      'wix-hotels-onboarding-fonts',
      '//static.parastorage.com/services/third-party/fonts/Helvetica/fontFace.css'
    );
    wp_enqueue_style(
      'wix-hotels-admin-stylesheet',
      Wix_Hotels::url('css/admin.css')
    );
    wp_enqueue_script(
      'wix-hotels-admin-back-office-script',
      Wix_Hotels::url('js/admin-back-office.js'),
      array('jquery')
    );
  }

  static function enqueue_admin_bar_scripts() {
    if (is_admin_bar_showing()) {
      wp_enqueue_style('wix-hotels-admin-bar', Wix_Hotels::url('css/admin-bar.css'));
    }
  }
}