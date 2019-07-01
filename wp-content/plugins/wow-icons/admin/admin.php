<?php if ( ! defined( 'ABSPATH' ) ) exit;
	function wow_admin_menu_icons() {
		/* Adding  Menus */
		add_menu_page(WOW_ICONS_NAME, WOW_ICONS_NAME, 'manage_options', WOW_ICONS_BASENAME, 'wow_page_icons', plugin_dir_url( __FILE__ ).'img/wow-icon.png');
	}	
	add_action('admin_menu', 'wow_admin_menu_icons');
	function wow_page_icons() {
		global $wow_icons_plugin;	
		$wow_icons_plugin = true;
		include_once( 'partials/main.php' );			
		wp_enqueue_style(WOW_ICONS_BASENAME, plugin_dir_url(__FILE__) . 'css/style.css', array(), WOW_ICONS_VERSION);
		wp_enqueue_style( 'font-awesome', WOW_ICONS_URL . 'assets/fontawesome/font-awesome.min.css', array(), '4.7.0' );
		wp_enqueue_script( WOW_ICONS_BASENAME.'-script',WOW_ICONS_URL . 'admin/js/script.js', array(), WOW_ICONS_VERSION, true );
	}
	
	function wow_icons_plugins_admin_footer_text( $footer_text ) {
		global $wow_icons_plugin;
		if ( $wow_icons_plugin == true ) {
			$rate_text = sprintf( '<span id="footer-thankyou">Developed by <a href="http://wow-company.com/" target="_blank">Wow-Company</a> | <a href="https://www.facebook.com/wowaffect/" target="_blank">Join us on Facebook</a> | <a href="https://wow-estore.com/" target="_blank">Wow-Estore</a> | <a href="https://wordpress.org/support/plugin/wow-icons" target="_blank">Support</a></span>'
			);
			return str_replace( '</span>', '', $footer_text ) . ' | ' . $rate_text . '</span>';
		}
		else {
			return $footer_text;
		}	
	}
	add_filter( 'admin_footer_text', 'wow_icons_plugins_admin_footer_text' );
	
	add_action( 'wp_ajax_wow_get_icons', 'wow_get_icons' );
	function wow_get_icons() {
		// run a quick security check
		if( ! check_ajax_referer( 'wow_get_icons', 'security' ) )
		return;
		switch ( $_POST['library'] ) {
			case 'fontawesome':
			$icons = wow_fontawesome_icons();
			break;
			case 'fontello':
			$icons = wow_fontello_icons();
			break;
			case 'icomoon':
			$icons = wow_icomoon_icons();
			break;
			case 'dashicons':
			$icons = wow_dashicons_icons();
			break;
			case 'openiconic':
			$icons = wow_openiconic_icons();
			break;
			case 'gmaterialicons':
			$icons = wow_materialicons_icons();
			break;
			case 'justvector':
			$icons = wow_justvector_icons();
			break;
			case 'paymentfont':
			$icons = wow_paymentfont_icons();
			break;
			default:
			$icons = '';
		} 
		echo json_encode( $icons ); //Send to Icons in Array
		die();
	}
	add_action( 'admin_enqueue_scripts', 'wow_admin_script_icons' );	
	function wow_admin_script_icons( $hook ) {
		$inpost = array ( 'post-new.php', 'post.php' );
		if ( ! in_array( $hook, $inpost ) ) {
			return;
		}		
		wp_enqueue_style( WOW_ICONS_BASENAME.'-button',  WOW_ICONS_URL . 'admin/css/button.css', false, WOW_ICONS_VERSION );		
		wp_enqueue_script( WOW_ICONS_BASENAME.'-button', WOW_ICONS_URL. 'admin/js/button.js', array( 'wp-color-picker' ), WOW_ICONS_VERSION, true );		
		add_action( 'media_buttons_context', 'wow_picker_button_icons', 1 );
		include_once ('partials/stylescript.php');
		wp_enqueue_style( 'wp-color-picker' );	
		require_once plugin_dir_path( __FILE__ ) . 'partials/button.php';
	}
	add_action( 'init', 'wow_global_init_icons' );
	function wow_global_init_icons() {
		if( is_admin() ) {			
			require_once dirname( __FILE__ ) .'/icons/fontello.php';
			require_once dirname( __FILE__ ) .'/icons/fontawesome.php';
			require_once dirname( __FILE__ ) .'/icons/icomoon.php';
			require_once dirname( __FILE__ ) .'/icons/dashicons.php';
			require_once dirname( __FILE__ ) .'/icons/openiconic.php';
			require_once dirname( __FILE__ ) .'/icons/material-icons.php';
			require_once dirname( __FILE__ ) .'/icons/justvector.php';
			require_once dirname( __FILE__ ) .'/icons/paymentfont.php';
		} 
	}		