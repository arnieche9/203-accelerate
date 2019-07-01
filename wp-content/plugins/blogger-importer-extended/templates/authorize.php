<?php if (!defined('ABSPATH')) die; ?>
<div class="wrap">
<style scoped>
.card .notice { display: none !important; }
</style>
<div class="card">
	<h2 class="title"><?php echo BIECore::NAME; ?></h2>
	<p><?php _e('Before getting started, we need to connect this site to your Blogger account.', BIECore::SLUG); ?></p>
	<p><?php _e('After connecting, you will be able to choose which blog to import.', BIECore::SLUG); ?></p>
	<a class="button button-primary" href="<?php echo $url; ?>" style="margin: 5px 0 10px;"><?php _e("Connect to Blogger", BIECore::SLUG); ?></a>
</div>
</div>