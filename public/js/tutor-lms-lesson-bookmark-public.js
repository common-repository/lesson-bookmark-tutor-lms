jQuery(document).ready(function ($) {
	$('body').on('click','.add-to-favorites', function() {
		if($(this).data('can-load') == "false") {
			return;
		}
		var this_button = $(this);
		var datas = new FormData();
		datas.append('action', 'toggle_favorite');
		datas.append("post_id", this_button.data('lesson-id'));
		
		this_button.attr('data-can-load', 'false');
		
		jQuery.ajax({
			url: ajaxurl,
			type: 'POST',
			data: datas,
			cache: false,
			contentType: false,
			processData: false,
			success: function (response) {
				var responseParsed = JSON.parse(response);
				if(responseParsed["response"]) {
					$('.tlms-popup-response-title').html(responseParsed["response"]);
					$('.tlms-popup-response').addClass('show');
					setTimeout(function() {
						$('.tlms-popup-response').removeClass('show');
					}, 3000);
				}
				if(responseParsed["button"]) {
					$('.tlms-button-text').html(responseParsed["button"]);
				}
				if(responseParsed["action"] == "removed") {
					$('.add-to-favorites').removeClass('is-favorite');
				} else {
					$('.add-to-favorites').addClass('is-favorite');
				}
				this_button.attr('data-can-load', 'true');
			}
		})
	});
	
	$('body').on('click','.quick-remove-bookmark', function() {
		let this_button = $(this);
		let tlms_favorite_container = this_button.closest('.tlms-favorite-container');
		let datas = new FormData();
		datas.append('action', 'toggle_favorite');
		datas.append("post_id", this_button.data('lesson-id'));
				
		// freeze bookmark card
		tlms_favorite_container.addClass('frozen');
		jQuery.ajax({
			url: ajaxurl,
			type: 'POST',
			data: datas,
			cache: false,
			contentType: false,
			processData: false,
			complete: function() {
				// remove
				tlms_favorite_container.remove();
			}
		})
	});
});