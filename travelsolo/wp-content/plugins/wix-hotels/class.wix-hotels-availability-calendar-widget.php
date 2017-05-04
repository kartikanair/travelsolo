<?php

class Wix_Hotels_Availability_Calendar_Widget extends WP_Widget
{
  function __construct() {
    parent::__construct(
      'wix_hotels_availability_calendar_widget',
      Wix_Hotels::_('Wix Hotels: Availability Calendar'),
      array('description' => Wix_Hotels::_('A widget for availability overview.'))
    );
  }

  public function widget($args, $instance) {
    echo $args['before_widget'];
    if (!empty($instance['title'])) {
      echo $args['before_title']
        . apply_filters('widget_title', $instance['title'])
        . $args['after_title'];
    }
    $id = Wix_Hotels_Counter::get_instance()->availability_calendar();
    $room_id = $instance['room_id'];
    echo Wix_Hotels_Embed::availability_calendar_widget($id, $room_id);
    echo $args['after_widget'];
  }

  public function form($instance) {
    $title = !empty($instance['title']) ? $instance['title'] : Wix_Hotels::_('Availability');
    $room_id = trim($instance['room_id']);
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
    <label for="<?php echo $this->get_field_id('room_id'); ?>"><?php _e('Room ID:')?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('room_id'); ?>" name="<?php echo $this->get_field_name('room_id') ?>" type="text" value="<?php echo esc_attr($room_id); ?>">
    </p>
    <?php
  }

  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title']
      = !empty($new_instance['title'])
      ? strip_tags($new_instance['title'])
      : '';
    $instance['room_id']
      = !empty($new_instance['room_id'])
      ? strip_tags($new_instance['room_id'])
      : '';
    return $instance;
  }

}