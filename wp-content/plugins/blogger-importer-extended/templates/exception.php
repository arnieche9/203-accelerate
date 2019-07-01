<?php if (!defined('ABSPATH')) die; ?>
<div class="wrap">
<style scoped>
.card .notice { display: none !important; }
</style>
<div class="card">
    <h2 class="title"><?php echo BIECore::NAME; ?></h2>
    <p><?php _e("Oops! Something went wrong. Click the button below to reload the connection to Blogger. The importer will continue afterwards.", BIECore::SLUG); ?></p>
    <p style="margin-top: 25px;"><button id="reset" class="button"><?php _e('Retry Connection', BIECore::SLUG); ?></button></p>
    <hr style="margin-top: 30px;" />
    <h3>Error Information</h4>
    <p>If you need any help please contact us on the <a href="https://wordpress.org/support/plugin/blogger-importer-extended/" target="_blank" rel="noopener">support forums</a>.</p>
    <p><?php echo $message; ?></p>
</div>
</div>

<script>
jQuery(document).ready(function($) {
    $('#reset').on('click', function() {
        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            data: {
                action: 'bie_reset'
            },
            success: function() {
                window.location.reload();
            }
        });
    });
});
</script>
