<?php

class Wix_Hotels_Embed
{
  static function get_default_parameters() {
    return array(
      'service_url' => Wix_Hotels::serviceUrl(),
      'hotel_id' => get_option('wix_hotels_hotel_id'),
      'locale' => get_locale(),
      'plugin_version' => WIX_HOTELS_VERSION,
    );
  }

  static function with_defaults(array $params) {
    return array_merge($params, self::get_default_parameters());
  }

  static function rooms_list() {
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('wix-hotels-rooms-stylesheet', Wix_Hotels::url('css/rooms.css'));
    wp_enqueue_style('wix-hotels-datepicker-stylesheet', Wix_Hotels::url('css/datepicker.css'));

    $thank_you_page_id = get_option('wix_hotels_thank_you_page_id');
    $return_url = get_page_link($thank_you_page_id);

    return Wix_Hotels::render('embed-rooms.php', self::with_defaults(array(
      'instance' => Wix_Hotels_Client::instance(),
      'script' => Wix_Hotels::serviceUrl('/embed/wp/rooms.js'),
      'return_url' => $return_url . '?reservation_id=:reservationId&confirmation_token=:confirmationToken'
    )));
  }

  static function reservation_details() {
    wp_enqueue_style('wix-hotels-reservation-stylesheet', Wix_Hotels::url('css/reservation.css'));
    return Wix_Hotels::render('embed-reservation-details.php', self::with_defaults(array(
      'instance' => Wix_Hotels_Client::instance(),
      'script' => Wix_Hotels::serviceUrl('/embed/wp/reservation-details.js')
    )));
  }

  static function search_widget($id, $layout) {
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('wix-hotels-datepicker-stylesheet', Wix_Hotels::url('css/datepicker.css'));
    wp_enqueue_style('wix-hotels-search-widget-stylesheet', Wix_Hotels::url('css/search-widget.css'));
    return Wix_Hotels::render('search-widget.php', self::with_defaults(array(
      'id' => $id,
      'script' => Wix_Hotels::serviceUrl('/embed/wp/search-widget.js'),
      'layout' => $layout,
      'rooms_page_url' => get_page_link(get_option('wix_hotels_rooms_page_id'))
    )));
  }

  static function search_widget_shortcode($args = array()) {
    $id = empty($args['id']) ? Wix_Hotels_Counter::get_instance()->search_widget() : $args['id'];
    $layout = empty($args['layout']) ? 'horizontal' : $args['layout'];
    return self::search_widget($id, $layout);
  }

  static function availability_calendar_widget($id, $room_id) {
    wp_enqueue_style(
      'wix-hotels-availability-calendar-stylesheet',
      Wix_Hotels::url('css/availability-calendar.css')
    );
    return Wix_Hotels::render('availability-calendar-widget.php', self::with_defaults(array(
      'id' => $id,
      'script' => Wix_Hotels::serviceUrl('/embed/wp/availability-calendar-widget.js'),
      'start_of_week' => get_option('start_of_week'),
      'room_id' => $room_id
    )));
  }

  static function availability_calendar_shortcode($args = array()) {
    $id = empty($args['id']) ? Wix_Hotels_Counter::get_instance()->availability_calendar() : $args['id'];
    $room_id = empty($args['room_id']) ? null : $args['room_id'];
    return self::availability_calendar_widget($id, $room_id);
  }
}