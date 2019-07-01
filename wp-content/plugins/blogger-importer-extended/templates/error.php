<?php if (!defined('ABSPATH')) die; ?>
<div class="wrap">
<style scoped>
.card .notice { display: none !important; }
</style>
<div class="card">
    <h2 class="title"><?php echo BIECore::NAME; ?></h2>
    <div class="error-div error">
        <p>The uploads directory is not writable by WordPress, so we can't import images.</p>
		<p>Please see <a href="http://codex.wordpress.org/Changing_File_Permissions">http://codex.wordpress.org/Changing_File_Permissions</a> and contact your host for assistance.</p>
	    <p><a class="button button-primary" href="">Try Again</a></p>
    </div>
</div>
</div>