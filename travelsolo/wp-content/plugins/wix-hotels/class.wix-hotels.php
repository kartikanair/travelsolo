<?php

class Wix_Hotels
{
  static function dir($path) {
    return WIX_HOTELS__PLUGIN_DIR . $path;
  }

  static function url($path) {
    return WIX_HOTELS__PLUGIN_URL . $path;
  }

  static function serviceUrl($path = '') {
    $service_url = get_option('wix_hotels_service_url');
    if (!$service_url) $service_url = WIX_HOTELS__SERVICE_BASE_URL;
    return $service_url . $path;
  }

  static function view($template, $data = array()) {
    extract($data, EXTR_SKIP);
    require self::dir('views/' . $template);
  }

  static function render($template, $data = array()) {
    ob_start();
    self::view($template, $data);
    return ob_get_clean();
  }

  static function _($text) {
    $args = func_get_args();
    $args[0] = __($text, 'wix-hotels');
    return call_user_func_array('sprintf', $args);
  }

  static function admin_notice($message, $dismissible = false) {
    return self::_admin_notice($message, 'info', $dismissible);
  }

  static function admin_success($message, $dismissible = false) {
    return self::_admin_notice($message, 'success', $dismissible);
  }

  static function admin_warning($message, $dismissible = false) {
    return self::_admin_notice($message, 'warning', $dismissible);
  }

  static function admin_error($message, $dismissible = false) {
    return self::_admin_notice($message, 'error', $dismissible);
  }

  private static function _admin_notice($message, $type = 'info', $dismissible = false) {
    $type_class = 'notice-info';
    switch ($type) {
    case 'error':
      $type_class = 'notice-error';
      break;

    case 'success':
      $type_class = 'notice-success';
      break;

    case 'warning':
      $type_class = 'notice-warning';
      break;

    default:
    case 'info':
      break;
    }

    $dismissible_class = $dismissible ? ' is-dismissible' : '';

    return <<<HTML
<div class="notice $type_class $dismissible_class">
  $message
</div>
HTML;
  }
}