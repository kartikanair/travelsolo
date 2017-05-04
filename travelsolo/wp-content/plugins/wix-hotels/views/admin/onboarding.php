<div id="wix-hotels-onboarding">
  <div id="wix-hotels-logo">
    <img src="<?php echo Wix_Hotels::url('images/wix-hotels-logo.png') ?>">
  </div>

  <h1><?php echo Wix_Hotels::_('Welcome to Wix Hotels') ?></h1>

  <p>
    <?php echo Wix_Hotels::_('Let\'s get you set up. It\'s fast and easy.') ?>
  </p>

  <form method="GET" action="<?php echo $url ?>">
    <input type="hidden" name="wp_nonce" value="<?php echo $wp_nonce ?>">
    <input type="hidden" name="redirect_to" value="<?php echo $redirect_to ?>">
    <button type="submit" class="button button-primary" id="wix-hotels-connect">
      <?php echo Wix_Hotels::_('Get Started') ?>
    </button>
  </form>
</div>
