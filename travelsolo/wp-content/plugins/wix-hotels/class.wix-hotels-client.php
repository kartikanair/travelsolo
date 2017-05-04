<?php

class Wix_Hotels_Client
{
  private static $instance;

  static function getSecret($token, $instance_id) {
    $url = Wix_Hotels::serviceUrl('/api/secret');
    $response = wp_remote_post($url, array(
      'headers' => array('Content-Type' => 'application/json'),
      'body' => json_encode(array(
        'token' => $token,
        'instance_id' => $instance_id
      ))
    ));
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
      return $response['body'];
    }
    return false;
  }

  static function instance($owner = false) {
    $secret = get_option('wix_hotels_secret');
    $hotel_id = get_option('wix_hotels_hotel_id');
    if (!self::$instance && $secret) {
      self::$instance = self::postInstance($secret, $hotel_id, $owner);
    }
    return self::$instance;
  }


  private static function postInstance($secret, $hotel_id, $owner) {
    $data = array(
      'instance_id' => $hotel_id,
      'timestamp' => date('Y-m-d H:i:s'),
      'is_owner' => $owner
    );
    $rooms_page_id = get_option('wix_hotels_rooms_page_id');
    if ($rooms_page_id) {
      $data['rooms_page'] = get_page_link($rooms_page_id);
    }

    $data = json_encode($data);
    $signature = base64_encode(hash_hmac('sha256', $data, $secret, true));

    $url = Wix_Hotels::serviceUrl('/api/instance');
    $response = wp_remote_post($url, array(
      'headers' => array('Content-Type' => 'application/json'),
      'body' => json_encode(array(
        'payload' => $data,
        'signature' => $signature
      ))
    ));

    if (!is_wp_error($response)) {
      return $response['body'];
    }
    return false;
  }
}