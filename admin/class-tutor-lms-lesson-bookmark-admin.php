<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://lekcie.com
 * @since      1.0.0
 *
 * @package    Tutor_Lms_Lesson_Bookmark
 * @subpackage Tutor_Lms_Lesson_Bookmark/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tutor_Lms_Lesson_Bookmark
 * @subpackage Tutor_Lms_Lesson_Bookmark/admin
 * @author     Lekcie <plugins@lekcie.com>
 */
class Tutor_Lms_Lesson_Bookmark_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tutor_Lms_Lesson_Bookmark_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tutor_Lms_Lesson_Bookmark_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/tutor-lms-lesson-bookmark-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tutor_Lms_Lesson_Bookmark_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tutor_Lms_Lesson_Bookmark_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/tutor-lms-lesson-bookmark-admin.js', array('jquery', 'wp-color-picker'), $this->version, false);
	}
	/**
	 * Displays review notice
	 *
	 * @since    1.1.0
	 */
	public function display_review_notice()
	{
		//creates option if not exists
		$option = 'tllb_activated_date';
		$date = date("Y-m-d");
		$activated_date = get_option($option);
		if (FALSE === $activated_date) {
			add_option($option, $date);
		}

		$datetime1 = date_create($activated_date);
		$datetime2 = date_create(date('Y-m-d'));

		$interval = date_diff($datetime1, $datetime2);

		$date_diff = $interval->format("%d");
		$cookie_hide_review = isset($_COOKIE['tllb_hide_review']) ? $_COOKIE['tllb_hide_review'] : "";
		if ($date_diff >= 7 && !$cookie_hide_review) {
			//checks if option date is older than 7 days, then show the notice
			echo '<div class="notice notice-info" id="tllb_review_notice">';
			echo '<h5 style="padding-top:10px;font-size: 20px;margin: 10px 0;">' . __("It only takes 1 min", "lesson-bookmark-tutor-lms") . '</h5>';
			echo '<p>';
			echo __("Wonderful! You have been using Lesson Bookmark for Tutor LMS for more than a week. <b>Help us</b> and tell us what you think", "lesson-bookmark-tutor-lms");
			echo '</p>';
			echo '<p style="padding-bottom: 15px;">';
			echo '<a class="button button-primary" href="https://wordpress.org/support/plugin/lesson-bookmark-tutor-lms/reviews/#new-post" target="_blank"> ' . __("Post a review", "lesson-bookmark-tutor-lms") . '</a>';
			echo '<a class="button button-secondary tllb_hide_notice" data-duration="7" style="margin: 0 10px;"> ' . __("Maybe later", "lesson-bookmark-tutor-lms") . '</a>';
			echo '<a href="" class="tllb_hide_notice" data-duration="60"> ' . __("Nope, I don't want to help :(", "lesson-bookmark-tutor-lms") . '</a>';
			echo '</p>';
			echo '</div>';
		}
	}

	/**
	 * Adds a tutor lms tab
	 *
	 * @since    2.0.0
	 */
	public function lmsOptionsMenu()
	{
		add_submenu_page(
			'tutor',
			__('Lesson bookmark settings', 'lesson-bookmark-tutor-lms'),
			__('Lesson bookmark', 'lesson-bookmark-tutor-lms'),
			'manage_options',
			'lms_options_page',
			array($this, 'lmsOptionsPage')
		);
	}

	/**
	 * Front Lesson bookmark page
	 *
	 * @since    2.0.0
	 */
	public function lmsOptionsPage()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/lesson-bookmark-menu-admin-display.php';
	}

	/**
	 * Settings link on plugins page
	 *
	 * @since    2.0.0
	 */
	public function addSettingsUrl($links)
	{
		$settingsLink = '<a href="admin.php?page=lms_options_page">' . __("Settings", "lesson-bookmark-tutor-lms") . '</a>';
		array_unshift($links, $settingsLink);
		return $links;
	}
}
