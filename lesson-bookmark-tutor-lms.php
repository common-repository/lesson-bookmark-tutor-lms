<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://lekcie.com/plugins-wordpress/
 * @since             1.0.0
 * @package           Tutor_Lms_Lesson_Bookmark
 *
 * @wordpress-plugin
 * Plugin Name:       Lesson Bookmark for Tutor LMS
 * Plugin URI:        https://lekcie.com/plugins-wordpress/
 * Description:       Lesson Bookmark for Tutor LMS allows to add lessons in the list of your favorite lessons and to display the favorites with the shortcode `[tllb_display_favorites]`
 * Version:           2.0.3
 * Author:            Lekcie
 * Author URI:        https://lekcie.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lesson-bookmark-tutor-lms
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('TUTOR_LMS_LESSON_BOOKMARK_VERSION', '2.0.3');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tutor-lms-lesson-bookmark-activator.php
 */
function activate_tutor_lms_lesson_bookmark()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-tutor-lms-lesson-bookmark-activator.php';
	Tutor_Lms_Lesson_Bookmark_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tutor-lms-lesson-bookmark-deactivator.php
 */
function deactivate_tutor_lms_lesson_bookmark()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-tutor-lms-lesson-bookmark-deactivator.php';
	Tutor_Lms_Lesson_Bookmark_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_tutor_lms_lesson_bookmark');
register_deactivation_hook(__FILE__, 'deactivate_tutor_lms_lesson_bookmark');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-tutor-lms-lesson-bookmark.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tutor_lms_lesson_bookmark()
{
	// dependency check
	$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
	if (!in_array( 'tutor/tutor.php', $active_plugins )) {
		add_action('admin_notices',  'lms_error_notice');
	} else {
		$plugin = new Tutor_Lms_Lesson_Bookmark();
		$plugin->run();
	}
}
run_tutor_lms_lesson_bookmark();


/**
 * Display admin error message
 *
 * @since     2.0.0
 */
function lms_error_notice()
{
	$class = 'notice notice-error';
	$message = __('<em>Lesson Bookmark for Tutor LMS</em> requires <em>Tutor LMS</em> to be installed and active.', 'lesson-bookmark-tutor-lms');
	printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
}
