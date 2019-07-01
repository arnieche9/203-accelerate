jQuery(document).ready(function($) {
	var icon_list;
	$("select#wow_icons_lib").val("none");
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
	$('#wow_icons_list, #wow_icon_position, #wow_icon_color').on("change",function() {
		var iconhtml = $('#wow_icons_list').val();		
		if (iconhtml !='')
		$('#wow_icon_class').text('wow-position '+iconhtml+' wow-icon');		
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
});