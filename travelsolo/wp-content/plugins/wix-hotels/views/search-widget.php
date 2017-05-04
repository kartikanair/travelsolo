<div id="wix-hotels-search-widget-<?php echo $id ?>" class="wix-hotels-search-widget wix-hotels-search-widget-<?php echo $layout ?>"></div>
<script type="text/javascript">
  function wix_hotels_init_search_widget(id) {
    WixHotelsSearchWidget({
      element: 'wix-hotels-search-widget-' + id,
      pluginVersion: '<?php echo $plugin_version ?>',
      layout: '<?php echo $layout ?>',
      roomsPageUrl: '<?php echo $rooms_page_url ?>'
    }).run();
  }
</script>
<script type="text/javascript" src="<?php echo $script ?>" onload="wix_hotels_init_search_widget('<?php echo $id ?>')"></script>
