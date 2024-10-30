<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://lekcie.com
 * @since      1.0.0
 *
 * @package    Tutor_Lms_Lesson_Bookmark
 * @subpackage Tutor_Lms_Lesson_Bookmark/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Tutor_Lms_Lesson_Bookmark
 * @subpackage Tutor_Lms_Lesson_Bookmark/includes
 * @author     Lekcie <plugins@lekcie.com>
 */
class Tutor_Lms_Lesson_Bookmark_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'tutor-lms-lesson-bookmark',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
