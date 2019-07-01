<?php if ( ! defined( 'ABSPATH' ) ) exit;	
	wp_enqueue_style( $this->pluginname.'-fonticonpicker',  $this->pluginurl . 'admin/css/jquery.fonticonpicker.min.css', false, $this->version );
	// CSS ( Themes )
	wp_enqueue_style( $this->pluginname.'-fonticonpicker-darkgrey', $this->pluginurl . 'admin/css/jquery.fonticonpicker.darkgrey.min.css', false, $this->version );
	
	// CSS ( Icons )
	wp_enqueue_style( $this->pluginname.'-icomoon', $this->pluginurl . 'assets/icomoon/icomoon.css', false, $this->version );
	wp_enqueue_style( $this->pluginname.'-fontello', $this->pluginurl . 'assets/fontello/css/fontello.css', false, $this->version );
	wp_enqueue_style( $this->pluginname.'-openiconic', $this->pluginurl . 'assets/openiconic/css/open-iconic-bootstrap.min.css', false, $this->version );
	wp_enqueue_style( $this->pluginname.'-dashicons', includes_url( 'css/dashicons.min.css' ), false, $this->version );
	wp_enqueue_style( $this->pluginname.'-fontawesome', $this->pluginurl . 'assets/fontawesome/font-awesome.min.css', false, $this->version );
	wp_enqueue_style( $this->pluginname.'-materialicons', 'https://fonts.googleapis.com/icon?family=Material+Icons', false );
	wp_enqueue_style( $this->pluginname.'-justvector', $this->pluginurl . 'assets/justvector/stylesheets/justvector.css', false, $this->version );
	wp_enqueue_style( $this->pluginname.'-paymentfont', $this->pluginurl . 'assets/paymentfont/css/paymentfont.min.css', false, $this->version );	
	wp_enqueue_style( $this->pluginname.'-typicons', $this->pluginurl . 'assets/typicons/font/typicons.min.css', false, $this->version );
	wp_enqueue_script( $this->pluginname.'-fonticonpicker',$this->pluginurl . 'admin/js/jquery.fonticonpicker.min.js', array(), $this->version, true );
	
