<?php

class Wix_Hotels_Counter {
  private $counters;
  private static $instance;

  private function __construct() {
    $this->counters = array('default' => 0);
  }

  public static function get_instance() {
    if (!self::$instance) {
      self::$instance = new Wix_Hotels_Counter();
    }
    return self::$instance;
  }

  private function next($group = 'default') {
    if (!key_exists($group, $this->counters)) {
      $this->counters[$group] = 0;
    }
    return $this->counters[$group]++;
  }

  public function availability_calendar() {
    return $this->next('availability-calendar');
  }

  public function search_widget() {
    return $this->next('search-widget');
  }
}