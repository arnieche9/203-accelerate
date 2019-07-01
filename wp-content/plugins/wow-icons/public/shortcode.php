<?php 
	/**
		* Shortcode
		*
		* @package     Public
		* @subpackage  
		* @copyright   Copyright (c) 2017, Dmytro Lobov
		* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
		* @since       2.1
	*/
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	extract( shortcode_atts( array(
		'lib' => '',
		'color' => '',
		'size' => '',
		'align' => '',
		'name' => '',
		), $attr ) );
		ob_start();
		if ( $lib && $name ) {
			$color = ( $color ? ' style="color:'.$color.' !important;" ' : '' );			
			$size = ( $size == '' ? 'nm' : $size );
			$align = ( $align == '' ? 'alignleft' : $align );
			if ( $lib == 'fa' ) { $prefix = 'fa '; }
			else if ( $lib == 'di' ) { $prefix = 'dashicons '; }
			else if ( $lib == 'oi' ) { $prefix = 'oi '; }
			else if ( $lib == 'gmi' ) { $prefix = 'material-icons '; }
			else if ( $lib == 'pf' ) { $prefix = 'pf '; }
			else if ( $lib == 'tp' ) { $prefix = 'typcn '; }
			else { $prefix = ''; }
			if ( $lib == 'gmi' ) { $ntitle = $name; }
			else { $ntitle = ''; }
			wp_enqueue_style( $this->pluginname.'-frontend' );			
			wp_enqueue_style( $this->pluginname.'-'.$lib.'' );				
			echo '<div class="wow_icon_outer_'.$align.' '.$align.'"><div class="wow_icon_element_inner" ><span class="wow_icon_element_icon_size_'.$size.' wow_icon_element_icon '.$prefix.$name.'"'.$color.'>'.$ntitle.'</span></div></div>';
		}
		$content = ob_get_clean();
		echo $content;