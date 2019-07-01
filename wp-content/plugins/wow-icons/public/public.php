<?php if ( ! defined( 'ABSPATH' ) ) exit;
	add_action( 'wp_enqueue_scripts', 'wow_frontend_script_icon' );
	function wow_frontend_script_icon() {
		wp_register_style( WOW_ICONS_BASENAME.'-frontend', plugin_dir_url( __FILE__ ) . '/css/style.css', false, WOW_ICONS_VERSION );
		wp_register_style( WOW_ICONS_BASENAME.'-animate', plugin_dir_url( __FILE__ ) . '/css/animate.min.css', false, WOW_ICONS_VERSION );
		wp_register_style( WOW_ICONS_BASENAME.'-im', WOW_ICONS_URL . '/assets/icomoon/icomoon.css', false, WOW_ICONS_VERSION );
		wp_register_style( WOW_ICONS_BASENAME.'-ft', WOW_ICONS_URL . '/assets/fontello/css/fontello.css', false, WOW_ICONS_VERSION );
		wp_register_style( WOW_ICONS_BASENAME.'-di', includes_url( '/css/dashicons.min.css' ), false, WOW_ICONS_VERSION );
		wp_register_style( WOW_ICONS_BASENAME.'-fa', WOW_ICONS_URL . '/assets/fontawesome/font-awesome.min.css', false, WOW_ICONS_VERSION );
		wp_register_style( WOW_ICONS_BASENAME.'-oi', WOW_ICONS_URL . '/assets/openiconic/css/open-iconic-bootstrap.min.css', false, WOW_ICONS_VERSION );
		wp_register_style( WOW_ICONS_BASENAME.'-gmi', 'https://fonts.googleapis.com/icon?family=Material+Icons', false );
		wp_register_style( WOW_ICONS_BASENAME.'-jv', WOW_ICONS_URL . '/assets/justvector/stylesheets/justvector.css', false, WOW_ICONS_VERSION );
		wp_register_style( WOW_ICONS_BASENAME.'-pf', WOW_ICONS_URL . '/assets/paymentfont/css/paymentfont.min.css', false, WOW_ICONS_VERSION );
		$options = get_option('wow_icons');	
		if ($options != false){
			foreach ($options as $key => $value){
				wp_enqueue_style( WOW_ICONS_BASENAME.'-'.$key );		
			}			
		}
	}
	add_shortcode( 'wow-icons', 'wow_shortcode_icons' );
	function wow_shortcode_icons( $attr ) {
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
			else { $prefix = ''; }
			if ( $lib == 'gmi' ) { $ntitle = $name; }
			else { $ntitle = ''; }
			wp_enqueue_style( WOW_ICONS_BASENAME.'-frontend' );			
			wp_enqueue_style( WOW_ICONS_BASENAME.'-'.$lib.'' );				
			echo '<div class="wow_icon_outer_'.$align.' '.$align.'"><div class="wow_icon_element_inner" ><span class="wow_icon_element_icon_size_'.$size.' wow_icon_element_icon '.$prefix.$name.'"'.$color.'>'.$ntitle.'</span></div></div>';
		}
		$content = ob_get_clean();
		return $content;
	}
	add_filter( 'nav_menu_css_class', 'wow_nav_menu_css_class_icon' );
	function wow_nav_menu_css_class_icon( $classes ){
        if( is_array( $classes ) ){
			$classes_str = implode(" ", $classes);
            preg_match("/wow-position(.*?)wow-icon/",$classes_str,$matches);
			if (empty($matches[0])){
				$tmp_classes = $classes;
			}
			else {
				$tmp_classes = explode(" ", $matches[0]);
			}
            if( !empty( $tmp_classes ) ){
                $classes = array_values( array_diff( $classes, $tmp_classes ) );
			}
		}
        return $classes;
	}
	function wow_replace_item_icon( $item_output, $classes ){   
		$icon = '<i class="' . $classes  . '"></i>';
		$pos = stripos($classes, 'material-icons');
		if ($pos !== false){
			preg_match("/material-icons(.*?)wow-icon/",$classes,$c_matches);
			$icon = '<i class="' . $classes  . '">'.$c_matches[1].'</i>';
		}
        preg_match( '/(<a.+>)(.+)(<\/a>)/i', $item_output, $matches );
        if( 4 === count( $matches ) ){
            $item_output = $matches[1];
			$item_output .= $icon . ' <span class="wow-text">' . $matches[2] . '</span>';
            $item_output .= $matches[3];
		}
        return $item_output;
	}
	add_filter( 'walker_nav_menu_start_el', 'wow_walker_nav_menu_start_el_icon', 10, 4 );
	function wow_walker_nav_menu_start_el_icon( $item_output, $item, $depth, $args ){
        if( is_array( $item->classes ) ){
			$classes_str = implode(" ", $item->classes);
            preg_match("/wow-position(.*?)wow-icon/",$classes_str,$matches);
			$classes = ( empty($matches[0]) ? '' : $matches[0] ); 
            if( !empty( $classes ) ){
                $item_output = wow_replace_item_icon( $item_output, $classes );
			}
		}
        return $item_output;
	}		