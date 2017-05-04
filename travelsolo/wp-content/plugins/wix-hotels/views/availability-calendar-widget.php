<div id="wix-hotels-availability-calendar-widget-<?php echo $id ?>" class="wix-hotels-availability-calendar-widget"></div>
<script type="text/javascript">
  function wix_hotels_init_availability_calendar_widget(id) {
    WixHotelsAvailabilityCalendarWidget({
      element: 'wix-hotels-availability-calendar-widget-' + id,
      serviceUrl: '<?php echo $service_url ?>',
      hotelId: '<?php echo $hotel_id ?>',
      locale: '<?php $locale ?>',
      pluginVersion: '<?php echo $plugin_version ?>',
      startOfWeek: '<?php echo $start_of_week ?>',
      roomId: '<?php echo $room_id; ?>'
    }).run();
  }
</script>
<script type="text/javascript" src="<?php echo $script ?>" onload="wix_hotels_init_availability_calendar_widget('<?php echo $id ?>')"></script>
