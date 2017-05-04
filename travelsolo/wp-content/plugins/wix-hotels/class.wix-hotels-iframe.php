<?php

class Wix_Hotels_Iframe
{
  static function roomsList() {
    $instance = Wix_Hotels_Client::instance();
    $url = 'https://hotels.wix.com/index.html';
    return Wix_Hotels::render('/iframe.php', array(
      'url' => $url . '?instance=' . $instance . '&viewMode=standalone&wordpress=true&locale=en&cacheKiller=' . time()
    ));
  }
}