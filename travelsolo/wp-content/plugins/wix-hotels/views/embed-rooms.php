<div id="wix-hotels"></div>
<script type="text/javascript">
  function wix_hotels_init() {
    WixHotels({
      serviceUrl: '<?php echo $service_url ?>',
      hotelId: '<?php echo $hotel_id ?>',
      element: document.getElementById('wix-hotels'),
      instance: '<?php echo $instance ?>',
      locale: '<?php $locale ?>',
      returnUrl: '<?php echo $return_url ?>',
      pluginVersion: '<?php echo $plugin_version ?>'
    }).run();
  }
</script>
<script src="<?php echo $script ?>" onload="wix_hotels_init()"></script>
