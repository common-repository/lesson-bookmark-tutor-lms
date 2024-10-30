jQuery(document).ready(function ($) {
	//hides notice
	$('.tllb_hide_notice').on('click', function () {
		let duration = $(this).data('duration');
		setCookietllb('tllb_hide_review', 'true', duration);
		$('#tllb_review_notice').slideUp();
	});

	// set up colorpicker
	$('.lms-color-field').wpColorPicker({
		change: function (event, ui) {
			let element = event.target;
			let color = ui.color.toString();
			let style = $(element).data('style');
			let target = $(element).data('target');
			$('.' + target).css(style, color);
		}
	});

	// radio is clicked, show number of col
	$('[name="lms_layout"]').on('click', function () {
		// reset style
		$('.lms-radio').removeClass('checked');
		$(this).parent().addClass('checked');

		if ($(this).val() == "columns") {
			// show/hide number of col
			$('#lms_nb_cols_block').slideDown();
			// change overview
			$('.tlms-favorites').addClass('grid');
			let number_of_col = $('[name="lms_nb_cols"]').val();
			let grid_template_columns = "";
			for (let i = 0; i < number_of_col; i++) {
				grid_template_columns += "1fr ";
			}
			$('.tlms-favorites.grid').css('grid-template-columns', grid_template_columns);

		} else {
			// show/hide number of col
			$('#lms_nb_cols_block').slideUp();
			$('.tlms-favorites').removeClass('grid');
		}
	});
	// number of col changed
	$('[name="lms_nb_cols"]').on('change', function () {
		let number_of_col = $(this).val();
		let grid_template_columns = "";
		for (let i = 0; i < number_of_col; i++) {
			grid_template_columns += "1fr ";
		}
		$('.tlms-favorites.grid').css('grid-template-columns', grid_template_columns);
	});

	// on input change, refresh overview
	$('.change-overview').on('change', function () {
		let value = $(this).val();
		let target = $(this).data("target");
		let style = $(this).data("style");
		let new_value = value;
		if (style == "font-size") {
			// special treatement for font size
			if ($(this).attr('type') == "number") {
				new_value = value + $(this).siblings('.select-container').find('select').val();
			}
			else {
				new_value = $(this).parent().parent().find('input').val() + value;
			}
		}
		console.log(new_value);
		$('.' + target).css(style, new_value);
	});

	// set up select icon
	$('select').each(function () {
		let select_container = '<div class="select-container"></div>';
		let icon_html = '<span class="dashicons dashicons-arrow-down"></span>';
		$(this).wrap(select_container);
		$(this).after(icon_html);
	});
});

function setCookietllb(name, value, days) {
	let expires = "";
	if (days) {
		let date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "") + expires + "; path=/";
}