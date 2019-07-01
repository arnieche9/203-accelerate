<?php
	/*
		* Plugin Name:	 Wow Icons
		* Plugin URI:	 https://wordpress.org/plugins/wow-icons/
		* Description:	 Easily create any icon for content and menu.
		* Author:		 Wow-Company.		
		* Version:		 2.0.1
		* Author URI:	 http://wow-company.com/
		* License:       GPL-2.0+
		* License URI:   http://www.gnu.org/licenses/gpl-2.0.txt	
	*/
	if ( ! defined( 'WPINC' ) ) {die;}
	// Declaration Wow-Company class
	if( !class_exists( 'Wow_Company' )) {
		require_once plugin_dir_path( __FILE__ ) . 'asset/class-wow-company.php';				
	}	
	if( !class_exists( 'WOW_DATA' )) {
		require_once plugin_dir_path( __FILE__ ) . 'include/class/data.php';
	}
	if( !class_exists( 'JavaScriptPacker' )) {
		require_once plugin_dir_path( __FILE__ ) . 'include/class/packer.php';
	}	
	
	// Declaration of the plugin class
	if( !class_exists( 'Wow_Icons_Class' ) ) {
		class Wow_Icons_Class
		{	
			const PREF = 'wip';
			
			function __construct() {
				$this->name = 'Wow Icons';
				$this->menuname = 'Wow Icons';
				$this->version = '2.0.1';				
				$this->pluginname = dirname(plugin_basename(__FILE__));
				$this->plugindir = plugin_dir_path( __FILE__ );
				$this->pluginurl = plugin_dir_url( __FILE__ );	
				$this->plugin_url = 'wow-icons';			
				
				// admin pages
				add_action( 'admin_menu', array($this, 'add_menu_page') );				
				add_action( 'wp_ajax_wow_get_icons', array($this, 'wow_get_icons' ) );
				add_action( 'init', array($this, 'wow_global_init_icons' ) );
				add_action( 'admin_enqueue_scripts', array($this, 'wow_admin_script_icons' ) );
				add_action( 'wp_enqueue_scripts', array($this, 'wow_frontend_script_icon') );
				add_shortcode('wow-icons', array($this, 'shortcode') );
				add_filter( 'nav_menu_css_class', array($this, 'wow_nav_menu_css_class_icon' ) );
				add_filter( 'walker_nav_menu_start_el', array($this, 'wow_walker_nav_menu_start_el_icon'), 10, 4 );
				// admin links
				add_filter( 'plugin_row_meta', array($this, 'row_meta'), 10, 4 );
				add_filter( 'plugin_action_links', array($this, 'action_links'), 10, 2 );				
				
			}				
			
			// AdminPanel
			function add_menu_page() {
				add_submenu_page('wow-company', $this->name.' version '.$this->version, $this->menuname, 'manage_options', $this->pluginname, array( $this, 'plugin_admin' ));
			}
			function plugin_admin() {
				require_once plugin_dir_path( __FILE__ ) . 'admin/index.php';			
			}		
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
					case 'typicons':					
					$icons = wow_typicons_icons();					
					break;
					default:					
					$icons = '';					
				} 				
				echo json_encode( $icons ); //Send to Icons in Array				
				die();				
			}
			function wow_global_init_icons() {
				if( is_admin() ) {			
					require_once dirname( __FILE__ ) .'/admin/icons/fontello.php';
					require_once dirname( __FILE__ ) .'/admin/icons/fontawesome.php';
					require_once dirname( __FILE__ ) .'/admin/icons/icomoon.php';
					require_once dirname( __FILE__ ) .'/admin/icons/dashicons.php';
					require_once dirname( __FILE__ ) .'/admin/icons/openiconic.php';
					require_once dirname( __FILE__ ) .'/admin/icons/material-icons.php';
					require_once dirname( __FILE__ ) .'/admin/icons/justvector.php';
					require_once dirname( __FILE__ ) .'/admin/icons/paymentfont.php';
					require_once dirname( __FILE__ ) .'/admin/icons/typicons.php';
				} 
			}
			function wow_admin_script_icons( $hook ) {
				$inpost = array ( 'post-new.php', 'post.php' );
				
				if ( ! in_array( $hook, $inpost )) {
					return;
				}		
				wp_enqueue_style( $this->pluginname.'-button',  $this->pluginurl . 'admin/css/button.css', false, $this->version );		
				wp_enqueue_script( $this->pluginname.'-button', $this->pluginurl. 'admin/js/button.js', array( 'wp-color-picker' ), $this->version, true );		
				add_action( 'media_buttons_context', array( $this, 'wow_picker_button_icons'), 1 );
				include_once ('admin/partials/stylescript.php');
				wp_enqueue_style( 'wp-color-picker' );	
				add_action('admin_footer', array( $this, 'wow_picker_content_icons') );
			}
			function wow_picker_button_icons( $context ) {
				$img = $this->pluginurl . '/admin/img/wow-icon.png';
				$container_id = 'wow-icons-up';
				$title = 'Wow Icons';
				$context .= '<a class="thickbox button" id="wow_picker_button" title="'.$title.'" style="outline: medium none !important; cursor: pointer;" ><img class="wow_ico" src="'.$img.'" alt="Wow Icons"/>Wow Icons</a>';
				return $context;
			}
			function wow_picker_content_icons() {
				require_once plugin_dir_path( __FILE__ ) . 'admin/partials/button.php';			
			}
			function wow_frontend_script_icon() {
				require_once plugin_dir_path( __FILE__ ) . 'public/style.php';			
			}
			// Show on Front end
			function shortcode($attr) {
				ob_start();
				include ('public/shortcode.php');				
				$form = ob_get_contents();
				ob_end_clean();					
				return $form;				
			}	
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
			function wow_walker_nav_menu_start_el_icon( $item_output, $item, $depth, $args ){
				if( is_array( $item->classes ) ){
					$classes_str = implode(" ", $item->classes);
					preg_match("/wow-position(.*?)wow-icon/",$classes_str,$matches);
					$classes = ( empty($matches[0]) ? '' : $matches[0] );
					if( !empty( $classes ) ){
						$item_output = self::wow_replace_item_icon( $item_output, $classes );
					}
				}
				return $item_output;
			}
			function wow_replace_item_icon( $item_output, $classes ){
				$before = true;
				if( strpos($classes, 'after') !== false ){            
					$before = false;
				}
				$pos_color = stripos($classes, 'iconcolor-');
				if ($pos_color !== false){
					preg_match("/iconcolor-(.*?)\s/",$classes,$m_matches);
					$iconcolor = ' style="color:'.$m_matches[1].';"';			
				}
				else {
					$iconcolor = '';
				}
				$icon = '<i class="' . $classes  . '"'.$iconcolor.'></i>';
				$pos = stripos($classes, 'material-icons');
				if ($pos !== false){
					preg_match("/material-icons(.*?)wow-icon/",$classes,$c_matches);
					$icon = '<i class="' . $classes  . '"'.$iconcolor.'>'.$c_matches[1].'</i>';
				}
				preg_match( '/(<a.+>)(.+)(<\/a>)/i', $item_output, $matches );
				if( 4 === count( $matches ) ){
					$item_output = $matches[1];
					if( $before ){
						$item_output .= $icon . ' <span class="wow-text">' . $matches[2] . '</span>';
						} else {
						$item_output .= '<span class="wow-text">' . $matches[2] . '</span> ' . $icon;
					}
					$item_output .= $matches[3];
				}
				return $item_output;
			}
			// Admin links
			function row_meta( $meta, $plugin_file ){
				if( false === strpos( $plugin_file, basename(__FILE__) ) )
				return $meta;
				$meta[] = '<a href="https://wow-estore.com/item/wow-icons-pro/" target="_blank">Pro version</a>';
				return $meta;
			}
			function action_links( $actions, $plugin_file ){
				if( false === strpos( $plugin_file, basename(__FILE__) ) )
				return $actions;
				$settings_link = '<a href="admin.php?page='. $this->pluginname .'">Settings</a>'; 
				array_unshift( $actions, $settings_link ); 
				return $actions; 
			}			
		}
		$plugin = new Wow_Icons_Class();		
	}							