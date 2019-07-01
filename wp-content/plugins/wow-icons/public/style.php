<?php if ( ! defined( 'ABSPATH' ) ) exit;
	
	wp_register_style( $this->pluginname.'-frontend', plugin_dir_url( __FILE__ ) . '/css/style.css', false, $this->version );
	wp_register_style( $this->pluginname.'-animate', plugin_dir_url( __FILE__ ) . '/css/animate.min.css', false, $this->version );
	wp_register_style( $this->pluginname.'-im', $this->pluginurl . '/assets/icomoon/icomoon.css', false, $this->version );
	wp_register_style( $this->pluginname.'-ft', $this->pluginurl . '/assets/fontello/css/fontello.css', false, $this->version );
	wp_register_style( $this->pluginname.'-di', includes_url( '/css/dashicons.min.css' ), false, $this->version );
	wp_register_style( $this->pluginname.'-fa', $this->pluginurl . '/assets/fontawesome/font-awesome.min.css', false, $this->version );
	wp_register_style( $this->pluginname.'-oi', $this->pluginurl . '/assets/openiconic/css/open-iconic-bootstrap.min.css', false, $this->version );
	wp_register_style( $this->pluginname.'-gmi', 'https://fonts.googleapis.com/icon?family=Material+Icons', false );
	wp_register_style( $this->pluginname.'-jv', $this->pluginurl . '/assets/justvector/stylesheets/justvector.css', false, $this->version );
	wp_register_style( $this->pluginname.'-pf', $this->pluginurl . '/assets/paymentfont/css/paymentfont.min.css', false, $this->version );
	wp_register_style( $this->pluginname.'-tp', $this->pluginurl . '/assets/typicons/font/typicons.min.css', false, $this->version );
	
	$options = get_option('wow_icons');	
	if ($options != false){
		foreach ($options as $key => $value){
			wp_enqueue_style( $this->pluginname.'-'.$key );
		}			
	}
	
	
?>