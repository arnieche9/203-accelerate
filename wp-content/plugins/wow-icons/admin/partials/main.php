<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wow">
    <span class="wow-plugin-title"><?php echo $name; ?></span> <span class="wow-plugin-version">(version <?php echo $version; ?>)</span>
	<ul class="wow-admin-menu">
		<li><a href='admin.php?page=<?php echo $pluginname;?>' title="List of Records">Settings <i class="fa fa-cogs"></i></a></li>		
		<li><a href='admin.php?page=<?php echo $pluginname;?>&tool=faq' >FAQ <i class="fa fa-question-circle"></i></a></li>
		<li><a href='admin.php?page=<?php echo $pluginname;?>&tool=pro' >Pro version <i class="fa fa-external-link"></i></a></li>
		<li><a href='admin.php?page=<?php echo $pluginname;?>&tool=support' title="Support page">Support <i class="fa fa-life-ring"></i></a></li>
		
		<li><a href='admin.php?page=<?php echo $pluginname;?>&tool=facebook' title="Join Us on Facebook">Join Us <i class="fa fa-sign-in"></i></a></li>
		</ul>
	<p style="padding-bottom: 5px;margin-bottom:30px;"><span class="dashicons dashicons-star-filled"></span>&nbsp;&nbsp; Please rate <a href="https://wordpress.org/plugins/wow-icons/?rate=5#new-post" target="_blank">us on WordPress.org</a>. With your help our products can become better!</p>
	<?php
		$tool= (isset($_REQUEST["tool"])) ? sanitize_text_field($_REQUEST["tool"]) : '';
		
		if ($tool == ""){
			include_once( 'settings.php' );
			include_once ('stylescript.php');
			return;
		}
		elseif ($tool == "faq"){
			include_once( 'faq.php' );	
			return;
		}
		
		elseif ($tool == "pro"){
			include_once( 'pro.php' );	
			return;
		}
		elseif ($tool == "support"){
			include_once( 'support.php' );	
			return;
		}
		
		elseif ($tool == "facebook"){
			include_once( 'facebook.php' );	
			
		}
		elseif ($wow == "faq"){
			include_once( 'faq.php' );	
			return;
		}
	?>
</div>