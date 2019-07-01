<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<form method="post" name="wow_icons_options" action="options.php">
	<?php wp_nonce_field('update-options'); ?>
	<?php $options = get_option('wow_icons'); ?>
	<div class="wowcolom">
		<div id="wow-leftcol">
			
			<div class="itembox wowbox">
				<div class="item-title">
					<h3><i class="fa fa-cogs" aria-hidden="true"></i> Settings for using icons in menu</h3>
				</div>
				
				<div class="wow-admin-col">
					<div class="wow-admin-col-4">
						Icon library:<br />
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
					<div class="wow-admin-col-6">
						Icon:<br />
						<input type="text" id="wow_icons_list" name="wow_icons_list" />
					</div>
				</div>
				<div class="wow-admin-col">
					<div class="wow-admin-col">
						
						<div class="wow-admin-col-6">
							Icon position:<br />
							<select disabled>
								<option>Before Menu item</option>							
							</select>
						</div>
						<div class="wow-admin-col-6">
							Icon color:<br />
							<select disabled>
								<option>default</option>
								
							</select>
							
						</div>
					</div>
					
				</div>
				<div class="wow-admin-col">
					
					<div class="wow-admin-col-12">
						<b>Icon Class:</b><br />
						<b><span id="wow_icon_class" style="color:#37c781;"></span> </b>
					</div>		
				</div>
				
				
				<div class="wow-admin-col wow-font">
					<div class="wow-admin-col-12">
						<b>Choose icon font for using in menu:</b><br />
						<input type="checkbox" name="wow_icons[fa]" value="1" <?php if(!empty($options['fa'])) echo 'checked' ; ?>> Font Awesome <br />
						<input type="checkbox" name="wow_icons[ft]" value="1" <?php if(!empty($options['ft'])) echo 'checked' ; ?>> Fontello <br />
						<input type="checkbox" name="wow_icons[im]" value="1" <?php if(!empty($options['im'])) echo 'checked' ; ?>> IcoMoon <br />
						<input type="checkbox" name="wow_icons[oi]" value="1" <?php if(!empty($options['oi'])) echo 'checked' ; ?>> Open Iconic <br />
						<input type="checkbox" name="wow_icons[di]" value="1" <?php if(!empty($options['di'])) echo 'checked' ; ?>> WP Dashicons <br />
						<input type="checkbox" name="wow_icons[gmi]" value="1" <?php if(!empty($options['gmi'])) echo 'checked' ; ?>> Google Material Icons <br />
						<input type="checkbox" name="wow_icons[jv]" value="1" <?php if(!empty($options['jv'])) echo 'checked' ; ?>> JustVector Social Font <br />
						<input type="checkbox" name="wow_icons[pf]" value="1" <?php if(!empty($options['pf'])) echo 'checked' ; ?>> Payment Font <br />
						<input type="checkbox" name="wow_icons[tp]" value="1" <?php if(!empty($options['tp'])) echo 'checked' ; ?>> Typicons <br />
					</div>																	
				</div>
			</div>
		</div>		
		
		<div id="wow-rightcol">
			<div class="wowbox">	
				<h3>Save Changes</h3>
				<div class="wow-admin-col">
					<div class="wow-admin-col-12 right">
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="page_options" value="wow_icons" />
						<input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes') ?>" type="submit">
						
					</div>									
				</div>
				
			</div>		
			
			<div class="wowbox">
				<center><img src="<?php echo plugin_dir_url( __FILE__ ); ?>thankyou.png" alt=""  /></center>
				<hr/>
				<div class="wow-admin wow-plugins">
					<p>We will be very grateful if you <a href="https://wow-estore.com/item/<?php echo $this->plugin_url; ?>/" target="_blank">leave a review</a> on the work of the plugin.</p>
					<p>If you have suggestions on how to improve the plugin or create a new plug-in, write to us via the <a href='admin.php?page=<?php echo $pluginname;?>&tool=support' title="Support page">support form</a>.</p>
					<p>We really appreciate your reviews and suggestions for improving the plugin.</p>
					<p>
					<b><em>Thank you for being a customer of <a href="https://wow-estore.com" target="_blank" rel="noopener">Wow-Estore</a>!</em></b></p>
					*****************<br/>
					<em><b>Best Regards</b>,<br/>						
						<a href="https://wow-estore.com/" target="_blank">Wow-Company Team</a><br/>
						Dmytro Lobov<br/>
						<a href="mailto:support@wow-company.com">support@wow-company.com</a>
					</em>
				</div>
				</div>
			</div>
		</div>
	</form>																							