<?php if ( ! defined( 'ABSPATH' ) ) exit;
	?>
    <div id="wow-icons-up" style="display:none;">
		<div id="wow-colum-left">
			<div class="wow_input"><!-- Icon Library -->
				<label class="label_option has_loader" for="wow_icons_lib">Icon library</label>
				<span class="wow_loader"></span>
				<select data-icnnonce="<?php echo wp_create_nonce( "wow_get_icons" ); ?>" name="wow_icons_lib" id="wow_icons_lib">
					<option data-lib="none" value="none">- Select library -</option>
					<option data-lib="fa" value="fontawesome">Font Awesome</option> 
					<option data-lib="ft" value="fontello">Fontello</option>
					<option data-lib="im" value="icomoon">IcoMoon</option>
					<option data-lib="oi" value="openiconic">Open Iconic</option>
					<option data-lib="di" value="dashicons">WP Dashicons</option>
					<option data-lib="gmi" value="gmaterialicons">Google Material Icons</option>
					<option data-lib="jv" value="justvector">JustVector Social Font</option>
					<option data-lib="pf" value="paymentfont">Payment Font</option>
					<option data-lib="tp" value="typicons">Typicons</option>
				</select>
			</div>
			<div class="wow_input"><!-- Icon Picker -->
				<label class="label_option" for="wow_icons_list">Icon</label><input type="text" id="wow_icons_list" name="wow_icons_list" />
			</div>
			<div class="wow_input icon_col_cont"><!-- Icon Color -->
				<label class="label_option label_option_cpick" for="wow_set_color">Icon color</label><input id="wow_set_color" type="text" value="" data-default-color="#effeff"/>
			</div>
			<div class="wow_input"><!-- Icon Size -->
				<label class="label_option" for="wow_icon_size">Icon Size</label>
				<select name="wow_icon_size" id="wow_icon_size">
					<option value="xs">Mini</option>
					<option value="sm">Small</option>
					<option value="md">Medium</option>
					<option value="nm" selected="selected">Normal</option>
					<option value="lg">Large</option>
					<option value="xl">Extra Large</option>
					<option value="xxl">Double Extra Large</option>
				</select>
			</div>
			<div class="wow_input"><!-- Icon Align -->
				<label class="label_option" for="wow_icon_align">Icon Align</label>
				<select name="wow_icon_align" id="wow_icon_align">
					<option value="alignnone">None</option>
					<option value="alignleft" selected="selected">Left</option>
					<option value="alignright">Right</option>
					<option value="aligncenter">Center</option>
				</select>				
			</div>
			<div class="wow_input"><!-- Icon Link -->			
				<label class="label_option" for="wow_icon_link">Icon link <input type="checkbox" disabled="disabled"></label>
				<input type="text" value="Only Pro Version" disabled="disabled" />
				<span class="dashicons dashicons-lock" style="color:#37c781;"></span>
			</div>
			<div class="wow_input wow_link_include"><!-- Link target-->
				<label class="label_option" for="wow_link_target">Link target</label>
				<select disabled="disabled">
					<option value="" selected="selected">Only Pro Version</option>
				</select>
				<span class="dashicons dashicons-lock" style="color:#37c781;"></span>
			</div>
			<div class="wow_input wow_link_include"><!-- Background Color -->
				<label class="label_option label_option_cpick" for="wow_link_hover">Link Hover Color</label>
				<span class="wow_color"></span>
				<span class="dashicons dashicons-lock" style="color:#37c781;"></span>
			</div>
		</div>
		<div id="wow-colum-right">	
			<div class="wow_input"><!-- Background shape -->
				<label class="label_option" for="wow_icon_bg_shape">Background Shape</label>
				<select disabled="disabled">
					<option value="" selected="selected">Only Pro Version</option>					
				</select>
				<span class="dashicons dashicons-lock" style="color:#37c781;"></span>
			</div>
			<div class="wow_input"><!-- Background Color -->
				<label class="label_option label_option_cpick" for="wow_icon_bg_shape_col">Background Color</label>
				<span class="wow_color"></span>
				<span class="dashicons dashicons-lock" style="color:#37c781;"></span>
			</div>
			<div class="wow_input wow_animation"><!-- Triggers -->
				<label class="label_option" for="wow_animated_trigger">Animate Event</label>
				<select disabled="disabled">
					<option value="" selected="selected">Only Pro Version</option>					
				</select>
				<span class="dashicons dashicons-lock" style="color:#37c781;"></span>
			</div>
			<div class="wow_input wow_animation"><!-- Delay -->
				<label class="label_option" for="wow_animated_delay">Delay (sec)</label>
				<input type="text" value="0" disabled="disabled"/>
				<span class="dashicons dashicons-lock" style="color:#37c781;"></span>
			</div>	
			<div class="wow_input"><!-- Icon Title -->
				<label class="label_option" for="wow_icon_title">Icon title <input type="checkbox" disabled="disabled"></label>
				<input type="text" value="Only Pro Version" disabled="disabled"/>
				<span class="dashicons dashicons-lock" style="color:#37c781;"></span>
			</div>
			<div class="wow_input wow_title_include"><!-- Title position-->
				<label class="label_option" for="wow_title_position">Title position</label>
				<select disabled="disabled">
					<option value="" selected="selected">Only Pro Version</option>					
				</select>
				<span class="dashicons dashicons-lock" style="color:#37c781;"></span>
			</div>
			<div class="wow_input wow_title_include"><!-- Title width-->
				<label class="label_option" for="wow_title_width">Title width (px) </label>
				<input type="text" value="Only Pro Version" disabled="disabled"/>
				<span class="dashicons dashicons-lock" style="color:#37c781;"></span>
			</div>
			<div class="wow_input">
				<label class="label_option"><a href="https://wow-estore.com/item/wow-icons-pro/" target="_blank">GET PRO VERSION</a> </label>				
			</div>
		</div>
		<div id="wow-colum">		
			<div class="wow_input wow_no_border"><!-- Add Shortcode -->
				<input type="button" value="Insert Icon" name="wow_icon_insert" id="wow_icon_insert" class="btn" />
				<input type="hidden" value="" id="is_edit"/>
			</div><div style="clear:both;"></div>
		</div>
		<div style="clear:both;"></div>
	</div>
	