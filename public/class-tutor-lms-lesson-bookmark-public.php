<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://lekcie.com
 * @since      1.0.0
 *
 * @package    Tutor_Lms_Lesson_Bookmark
 * @subpackage Tutor_Lms_Lesson_Bookmark/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tutor_Lms_Lesson_Bookmark
 * @subpackage Tutor_Lms_Lesson_Bookmark/public
 * @author     Lekcie <plugins@lekcie.com>
 */
class Tutor_Lms_Lesson_Bookmark_Public
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/tutor-lms-lesson-bookmark-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/tutor-lms-lesson-bookmark-public.js', array('jquery'), $this->version, false);
		wp_localize_script($this->plugin_name, 'ajaxurl', [admin_url('admin-ajax.php')]);
	}

	/**
	 * Action to display bookmark
	 *
	 * @since    1.0.0
	 */
	public function lesson_bookmark_button()
	{
		$current_post_id = get_the_ID();
		$user_id = get_current_user_id();
		$meta_key = "tuto_lesson_favorites";
		$current_favorites = get_user_meta($user_id, $meta_key);
		$already_in_favorites = false;

		if ($current_favorites) {
			$current_favorites_array = unserialize($current_favorites[0]);
			if (in_array($current_post_id, $current_favorites_array)) {
				$already_in_favorites = true;
			}
		}
?>
		<div class="tlms-lesson-bookmark add-to-favorites <?php echo ($already_in_favorites ? "is-favorite" : ""); ?>" data-lesson-id="<?php echo $current_post_id; ?>" data-can-load="true">
			<?php $current_favorites = get_user_meta($user_id, $meta_key); ?>
			<span class="dashicons dashicons-heart"></span>
			<span class="tlms-button-text">
				<?php echo ($already_in_favorites ? __("Remove Bookmark", "lesson-bookmark-tutor-lms") : __("Bookmark", "lesson-bookmark-tutor-lms")); ?>
			</span>
		</div>
		<div class="tlms-popup-response">
			<div class="tlms-popup-response-content">
				<div class="tlms-popup-response-title">
				</div>
			</div>
		</div>
		<?php }

	/**
	 * AJAX : Add or remove current lesson to favorites
	 *
	 * @since    1.0.0
	 */
	public function ajax_toggle_lesson_favorite()
	{
		$user_id = get_current_user_id();

		$post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : null;
		$meta_key = "tuto_lesson_favorites";

		$results = array();

		$current_favorites = get_user_meta($user_id, $meta_key);
		$is_in_favorites = false;
		$favorites = array();
		if ($current_favorites) {
			$current_favorites_array = unserialize($current_favorites[0]);

			foreach ($current_favorites_array as $fav) {
				//don't add lesson_id if already exists in favorites
				if ($fav !== $post_id) {
					$favorites[] = $fav;
				} else {
					$is_in_favorites = true;
				}
			}

			if (!$is_in_favorites) {
				$results["response"] = __("Lesson successfully bookmarked", "lesson-bookmark-tutor-lms");
				$results["button"] = __("Remove Bookmark", "lesson-bookmark-tutor-lms");
				$results["action"] = "added";
				$favorites[] = $post_id;
			} else {
				$results["response"] = __("Lesson successfully removed from bookmarks", "lesson-bookmark-tutor-lms");
				$results["button"] = __("Bookmark", "lesson-bookmark-tutor-lms");
				$results["action"] = "removed";
			}
			update_user_meta($user_id, $meta_key, serialize($favorites));
		} else {
			$favorites[] = $post_id;
			add_user_meta($user_id, $meta_key, serialize($favorites));
			$results["response"] = __("Lesson successfully bookmarked", "lesson-bookmark-tutor-lms");
			$results["button"] = __("Remove Bookmark", "lesson-bookmark-tutor-lms");
			$results["action"] = "added";
		}

		echo json_encode($results);
		die;
	}

	/**
	 * shortcode : display favorites
	 *
	 * @since    1.0.0
	 */
	public function display_favorites()
	{
		$user_id = get_current_user_id();
		$meta_key = "tuto_lesson_favorites";
		$current_favorites = get_user_meta($user_id, $meta_key);
		$has_favorites = false;

		if ($current_favorites) {
			$lms_layout = get_option('lms_layout');
			$grid_template_columns = "style='grid-template-columns: ";
			$lms_nb_cols = get_option('lms_nb_cols') ?: "2";
			for ($i = 0; $i < $lms_nb_cols; $i++) {
				$grid_template_columns .= "1fr ";
			}
			$grid_template_columns .= "'"
		?>
			<div class="tlms-favorites <?php echo $lms_layout == "columns" ? "grid" : "" ?>" <?php echo $lms_layout == "columns" ? $grid_template_columns : ""; ?>>
				<?php $current_favorites_array = unserialize($current_favorites[0]);
				foreach ($current_favorites_array as $fav_id) {
					$lesson = get_post($fav_id);
					$lesson_title = $lesson->post_title;
					$lesson_url = get_permalink($fav_id);
					$chapter_id = $lesson->post_parent;
				?>
					<div class="tlms-favorite-container">
						<div class="tlms-favorite">
							<span class="dashicons dashicons-heart"></span>
							<a href="<?php echo $lesson_url; ?>">
								<div class="tlms-fav-title">
									<?php echo $lesson_title; ?>
								</div>
							</a>
							<?php $chapter = get_post($chapter_id);
							$chapter_title = $chapter->post_title;
							$course_name = get_the_title(wp_get_post_parent_id($chapter_id));
							?>
							<div class="tlms-fav-bottom">
								<div class="tlms-fav-subtitle">
									<?php echo sprintf(__("Lesson: %s", "lesson-bookmark-tutor-lms"), $chapter_title); ?>
									-
									<?php echo sprintf(__("Course: %s", "lesson-bookmark-tutor-lms"), $course_name); ?>
								</div>
								<span class="tlms-fav-see-lesson">
									<a href="<?php echo $lesson_url; ?>"><span class="dashicons dashicons-visibility"></span><?php echo __("See lesson", "lesson-bookmark-tutor-lms") ?></a>
								</span>
							</div>
							<span class="dashicons dashicons-no quick-remove-bookmark" data-lesson-id="<?php echo $fav_id; ?>" title="<?php echo __("Remove this bookmark", "lesson-bookmark-tutor-lms"); ?>"></span>
						</div>
					</div>
				<?php }
				if (count($current_favorites_array) == 0) {
					$has_favorites = false;
				} else {
					$has_favorites = true;
				} ?>
			</div>
		<?php } ?>
		<?php if (!$has_favorites) {
			echo __("You don't have bookmarked lessons yet", "lesson-bookmark-tutor-lms");
		}
	}


	/**
	 * CSS with php
	 *
	 * @since    2.0.0
	 */
	public function lmsCSS()
	{
		$lms_lesson_size = get_option('lms_lesson_size') ?: "25";
		$lms_lesson_unit = get_option('lms_lesson_unit') ?: "px";
		$lms_lesson_color = get_option('lms_lesson_color') ?: "#2271b1";
		$lms_sub_size = get_option('lms_sub_size') ?: "13";
		$lms_sub_unit = get_option('lms_sub_unit') ?: "px";
		$lms_sub_color = get_option('lms_sub_color') ?: "#3c434a";
		$lms_button_size = get_option('lms_button_size') ?: "13";
		$lms_button_unit = get_option('lms_button_unit') ?: "px";
		$lms_button_bg_color = get_option('lms_button_bg_color') ?: "#1da3c9";
		$lms_button_txt_color = get_option('lms_button_txt_color') ?: "#fff";
		?>
		<style>
			.tlms-fav-title {
				font-size: <?php echo $lms_lesson_size . $lms_lesson_unit; ?>;
				color: <?php echo $lms_lesson_color; ?>;
			}

			.tlms-fav-subtitle {
				font-size: <?php echo $lms_sub_size . $lms_sub_unit; ?>;
				color: <?php echo $lms_sub_color; ?>;
			}

			.tlms-fav-see-lesson a {
				font-size: <?php echo $lms_button_size . $lms_button_unit; ?>;
				background-color: <?php echo $lms_button_bg_color; ?>;
				color: <?php echo $lms_button_txt_color; ?>;
			}
		</style>
<?php }
}
