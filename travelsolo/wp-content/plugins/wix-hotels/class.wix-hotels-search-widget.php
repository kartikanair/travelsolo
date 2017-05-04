<?php

class Wix_Hotels_Search_Widget extends WP_Widget
{
  const LAYOUT_HORIZONTAL = 'horizontal';
  const LAYOUT_VERTICAL = 'vertical';

	function __construct() {
		parent::__construct(
			'wix_hotels_search_widget',
			Wix_Hotels::_('Wix Hotels: Search'),
			array('description' => Wix_Hotels::_('A widget for quick availability search.'))
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
    $layout = $instance['layout'];
    echo Wix_Hotels_Embed::search_widget($id, $layout);
		echo $args['after_widget'];
	}

	public function form($instance) {
		$title = !empty($instance['title']) ? $instance['title'] : Wix_Hotels::_('Book Now');
    $layout = !empty($instance['layout']) ? $instance['layout'] : self::LAYOUT_VERTICAL;
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
    <label for=""><?php echo Wix_Hotels::_('Layout:'); ?></label><br>

    <input
      type="radio"
      id="<?php echo $this->get_field_id('layout_vertical'); ?>"
      name="<?php echo $this->get_field_name('layout'); ?>"
      <?php echo $layout === self::LAYOUT_VERTICAL ? 'checked' : ''; ?>
      value="<?php echo self::LAYOUT_VERTICAL ?>">
    <label for="<?php echo $this->get_field_id('layout_vertical'); ?>"><?php echo Wix_Hotels::_('Vertical') ?></label><br>

    <input
      type="radio"
      id="<?php echo $this->get_field_id('layout_horizontal'); ?>"
      name="<?php echo $this->get_field_name('layout'); ?>"
      <?php echo $layout === self::LAYOUT_HORIZONTAL ? 'checked' : ''; ?>
      value="<?php echo self::LAYOUT_HORIZONTAL ?>">
    <label for="<?php echo $this->get_field_id('layout_horizontal'); ?>"><?php echo Wix_Hotels::_('Horizontal') ?></label><br>

    </p>
		<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title']
      = !empty($new_instance['title'])
      ? strip_tags( $new_instance['title'] )
      : '';

    $layout_whitelist = array(
      self::LAYOUT_HORIZONTAL,
      self::LAYOUT_VERTICAL
    );
    if (in_array($new_instance['layout'], $layout_whitelist)) {
      $instance['layout'] = $new_instance['layout'];
    }
		return $instance;
	}

}