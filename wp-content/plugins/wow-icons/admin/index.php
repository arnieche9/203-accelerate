<?php 
	/**
		* Admin Pages
		*
		* @package     
		* @subpackage  
		* @copyright   Copyright (c) 2017, Dmytro Lobov
		* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
		* @since       2.2
	*/
	
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	$name = $this->name;	
	$pluginname = $this->pluginname;
	$version = $this->version;
	global $wow_company_plugin;	
	$wow_company_plugin = true;	
	include_once( 'partials/main.php' );				
	// plugin sctyle & script		
	wp_enqueue_style( $this->pluginname.'-style', $this->pluginurl . 'admin/css/style.css',false, $this->version);				
	wp_enqueue_script($this->pluginname.'-script', $this->pluginurl . 'admin/js/script.js', array('jquery'), $this->version);				
	// icon style
	wp_enqueue_style( $this->pluginname.'-icon', $this->pluginurl . 'asset/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
	