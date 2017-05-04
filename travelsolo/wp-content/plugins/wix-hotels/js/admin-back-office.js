/*global jQuery*/
(function ($) {
  'use strict';

  return $(initializeBackOfficePage);

  function initializeBackOfficePage() {
    var $iframe = $('#wix-hotels-back-office');
    var $window = $(window);

    onResize();
    $window.resize(onResize);

    function onResize() {
      $iframe.height($window.height() - 32);
    }
  }

}(jQuery));
