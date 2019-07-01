jQuery(document).ready(function($) {
	var icon_list;
	var tbH = 475;
	$("body").delegate("#wow_picker_button","click",function(){
		setTimeout(function() {
			tb_show( '<img src="'+$('#wow_picker_button').find('.wow_ico').attr('src')+'" alt="Wow Icons" class="wow_picker_ttl_ico">Wow Icons <span class="cp_version">v 1.0</span>', '#TB_inline?height=475&width=800&inlineId=wow-icons-up' );
			$("select#wow_icons_lib").val("none");
			$("select#wow_icon_align").val("alignleft");
			$('#wow_icon_insert').attr('value','Insert Icon');
			$("select#wow_icon_size").val("nm");
			$("#TB_ajaxContent").css('overflow','visible');
			$(".selector-popup").css('display','none');
			$('#wow_icons_list').val('');
			$('#is_edit').val('');
			$('#wow_icons_lib').prop('disabled', false);	
			tbH = 475;
    		icon_list = $('#wow_icons_list').fontIconPicker({
				emptyIcon: true,
				iconsPerPage: 25,
        		theme: 'fip-darkgrey'
				}).on('change', function() {
				$('#wow_icons_list').attr('value', $(this).val());
			});
			icon_list.destroyPicker();
			icon_list.refreshPicker();
			$(".selector-button").unbind('click');
			var myOptions = {
				defaultColor: false,
				change: function(event, ui){},
				clear: function() {},
				hide: true,
				palettes: true
			};
			$('#wow_set_color').wpColorPicker(myOptions);
			tbReposition();
			$("#TB_closeWindowButton").replaceWith($("<div class='closetb' id='TB_closeWindowButton'><span class='screen-reader-text'>Close</span><span class='tb-close-icon'></span></div>"));
		}, 300);	
	});
	// Close Thickbox
	$("body").delegate(".closetb","click",function(){
		tb_remove();
	});
	// Select Icon Library
	$('#wow_icons_lib').on("change",function() {
		if ($("option:selected", this).attr('data-lib') == 'none') {
			$(".selector-button").unbind('click');	
			$(".selected-icon").html('<i class="fip-icon-block"></i>');
			$('#wow_icons_list').val('');
			} else {
			$(".selector-button").bind('click');
		 	$(this).prop('disabled', true);
		 	$('.wow_loader').addClass('animate_spin');
			getIcon(jQuery(this));
		}
	});
	// Get Icon AJAX
	function getIcon(el) {
		jQuery.ajax({
			url: ajaxurl,
			data:{
				'action': 'wow_get_icons',
				'library': el.val(),
				'security': el.attr('data-icnnonce'),
			},
			dataType: 'json',
			type: 'POST',
			success:function(response){
				if (response) {
					var all_icons = [];
					icon_list.destroyPicker();
					icon_list.refreshPicker();
					switch(el.val()) {
						case 'fontawesome':
						case 'fontello':
						case 'dashicons':
						case 'openiconic':
						case 'justvector':
						case 'paymentfont':
						case 'icomoon':
						case 'typicons':
						
						$.each(response.glyphs, function(i, v) {
							all_icons.push( response.css_prefix_text + v.css );
						});
						break;
						case 'gmaterialicons':
						$.each(response.glyphs, function(i, v) {
							all_icons.push( response.css_prefix_text + v.css );
						});
						icon_list.refreshPicker({
							needTitle: true,
							theme: 'fip-darkgrey'
						});
						break;
						default:
					} 
					// Set new List
					icon_list.setIcons(all_icons);
					if ($('#is_edit').val() != 'edit') {
						$('.selector-button').trigger('click');
						} else {
						$('#is_edit').attr('value','');	
					}
					$('#wow_icons_lib').prop('disabled', false);
					$('.wow_loader').removeClass('animate_spin');
					} else {
					$('#wow_icons_lib').prop('disabled', false);
					$('.wow_loader').removeClass('animate_spin');
				}
			},
			error: function(errorThrown){
				$('#wow_icons_lib').prop('disabled', false);
				$('.wow_loader').removeClass('animate_spin');
			}
		}); // End Grab	
	}
	$('#wow_icon_insert').on('click', function() {
		if ( !!$('#wow_icons_list').val() ) {
			var sccode,
			wicCol = (($('#wow_set_color').val()) ? ' color="'+$('#wow_set_color').val()+'"' : '' ),
			wicSize = ' size="'+$('#wow_icon_size').val()+'"',
			wicAlign = ' align="'+$('#wow_icon_align').val()+'"',
			sccode = "[wow-icons lib="+$('#wow_icons_lib option:selected').attr('data-lib')+" name="+$('#wow_icons_list').val().replace(/^fa |dashicons |material-icons |pf |oi |typcn\s/i, '')+""+wicCol+""+wicSize+""+wicAlign+"]";
			if( jQuery('#wp-content-editor-container > textarea').is(':visible') ) {
				var val = jQuery('#wp-content-editor-container > textarea').val() + sccode;
				jQuery('#wp-content-editor-container > textarea').val(val);	
			}
			else {
				tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sccode);
			}
			tb_remove();
		}
		else {
			alert('Please select icon first!');
			//tb_remove();
		}
	});
	// Reposition Thickbox
	function tbReposition() {
		$('#TB_window').css({
			'top' : ((jQuery(window).height() - 475) / 6) + 'px',
			'left' : ((jQuery(window).width() - 800) / 4) + 'px',
			'margin-top' : ((jQuery(window).height() - 475) / 6) + 'px',
			'margin-left' : ((jQuery(window).width() - 800) / 4) + 'px',
			'max-height' : parseInt(tbH) + 'px',
			'min-height' : parseInt(tbH) + 'px',
		});
	}
	$(window).resize(function() {
		tbReposition();
	});
	// Thickbox Close Callback
	var old_tb_remove = window.tb_remove;
	var tb_remove = function() {
		old_tb_remove();
		setTimeout(function() {
			$('.mce-inline-toolbar-grp').hide();
		}, 500);
	};
});