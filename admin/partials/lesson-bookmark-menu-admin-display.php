<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://lekcie.com/plugins-wordpress
 * @since      2.0.0
 *
 * @package    Tutor_Lms_Lesson_Bookmark
 * @subpackage Tutor_Lms_Lesson_Bookmark/admin/partials
 */
?>

<?php
if ($_POST && wp_verify_nonce($_POST['sec_field'], 'sec_action')) {
    // update fields in DB
    foreach ($_POST as $key => $value) {
        if ($key != "sec_field") {
            if (!get_option($key)) {
                add_option($key, sanitize_text_field($value));
            } else {
                update_option($key, sanitize_text_field($value));
            }
        }
    }
}
?>

<div class="wrap">
    <h1 class="rsm-page-title"><?php echo esc_html(get_admin_page_title()); ?></h1>

    <div class="shortcode">
        <?php echo __("Shortcode:", "lesson-bookmark-tutor-lms"); ?> <div class="shortcode-content">[tllb_display_favorites]</div>
    </div>

    <div class="content" id="lms_form_container">
        <form method="POST" action="#" id="lms_form">
            <?php wp_nonce_field('sec_action', 'sec_field'); ?>
            <fieldset>
                <legend><?php echo __("Container", "lesson-bookmark-tutor-lms"); ?></legend>
                <div class="lms-container">
                    <h4><?php echo __("Layout", "lesson-bookmark-tutor-lms"); ?></h4>
                    <?php $lms_layout = get_option('lms_layout'); ?>
                    <label class="lms-radio <?php echo $lms_layout == "columns" ? "checked" : "" ?>" for="lms_layout_col">
                        <input type="radio" name="lms_layout" id="lms_layout_col" value="columns" <?php echo $lms_layout == "columns" ? "checked" : "" ?>><?php echo __("Columns", "lesson-bookmark-tutor-lms"); ?><span class="dashicons dashicons-columns"></span>
                    </label>
                    <label class="lms-radio <?php echo $lms_layout == "rows" ? "checked" : "" ?>" for="lms_layout_row">
                        <input type="radio" name="lms_layout" id="lms_layout_row" value="rows" <?php echo $lms_layout == "rows" ? "checked" : "" ?>><?php echo __("Rows", "lesson-bookmark-tutor-lms"); ?><span class="dashicons dashicons-columns rotate"></span>
                    </label>
                </div>
                <div class="lms-container <?php echo $lms_layout == "columns" ? "show" : "" ?>" id="lms_nb_cols_block">
                    <h4><?php echo __("Number of columns per row", "lesson-bookmark-tutor-lms"); ?></h4>
                    <input type="number" name="lms_nb_cols" value="<?php echo $lms_nb_cols = get_option('lms_nb_cols') ?: "2" ?>" min="1">
                </div>
            </fieldset>

            <fieldset>
                <legend><?php echo __("Card", "lesson-bookmark-tutor-lms"); ?></legend>
                <div class="lms-container-section">
                    <h4><?php echo __("Lesson title", "lesson-bookmark-tutor-lms"); ?></h4>
                    <div class="lms-container">
                        <h5><?php echo __("Font size", "lesson-bookmark-tutor-lms"); ?></h5>
                        <div class="lms-2-col">
                            <?php $lms_lesson_size = get_option('lms_lesson_size') ?: "25"; ?>
                            <input type="number" name="lms_lesson_size" value="<?php echo $lms_lesson_size ?>" min="0" class="change-overview" data-target="tlms-fav-title" data-style="font-size">

                            <?php $lms_lesson_unit = get_option('lms_lesson_unit') ?: "px"; ?>
                            <select name="lms_lesson_unit" class="change-overview" data-target="tlms-fav-title" data-style="font-size">
                                <option value="em" <?php echo $lms_lesson_unit == "em" ? "selected" : "" ?>>em</option>
                                <option value="px" <?php echo $lms_lesson_unit == "px" ? "selected" : "" ?>>px</option>
                            </select>
                        </div>
                    </div>
                    <div class="lms-container">
                        <h5><?php echo __("Color", "lesson-bookmark-tutor-lms"); ?></h5>
                        <input type="text" name="lms_lesson_color" value="<?php echo get_option('lms_lesson_color') ?: "#2271b1" ?>" class="lms-color-field change-overview" data-default-color="#2271b1" data-target="tlms-fav-title" data-style="color">
                    </div>
                </div>
                <div class="lms-container-section">
                    <h4><?php echo __("Subtitle", "lesson-bookmark-tutor-lms"); ?></h4>
                    <div class="lms-container">
                        <h5><?php echo __("Font size", "lesson-bookmark-tutor-lms"); ?></h5>
                        <div class="lms-2-col">
                            <input type="number" name="lms_sub_size" value="<?php echo get_option('lms_sub_size') ?: "13" ?>" min="0" class="change-overview" data-target="tlms-fav-subtitle" data-style="font-size">
                            <?php $lms_sub_unit = get_option('lms_sub_unit'); ?>
                            <select name="lms_sub_unit" class="change-overview" data-target="tlms-fav-subtitle" data-style="font-size">
                                <option value="em" <?php echo $lms_sub_unit == "em" ? "selected" : "" ?>>em</option>
                                <option value="px" <?php echo $lms_sub_unit == "px" ? "selected" : "" ?>>px</option>
                            </select>
                        </div>
                    </div>
                    <div class="lms-container">
                        <h5><?php echo __("Color", "lesson-bookmark-tutor-lms"); ?></h5>
                        <input type="text" name="lms_sub_color" value="<?php echo get_option('lms_sub_color') ?: "#3c434a" ?>" class="lms-color-field change-overview" data-default-color="#3c434a" data-target="tlms-fav-subtitle" data-style="color">
                    </div>
                </div>
                <div class="lms-container-section">
                    <h4><?php echo __("Button", "lesson-bookmark-tutor-lms"); ?></h4>
                    <div class="lms-container">
                        <h5><?php echo __("Font size", "lesson-bookmark-tutor-lms"); ?></h5>
                        <div class="lms-2-col">
                            <input type="number" name="lms_button_size" value="<?php echo get_option('lms_button_size') ?: "13" ?>" min="0" class="change-overview" data-target="tlms-fav-see-lesson-button" data-style="font-size">
                            <?php $lms_button_unit = get_option('lms_button_unit'); ?>
                            <select name="lms_button_unit" class="change-overview" data-target="tlms-fav-see-lesson-button" data-style="font-size">
                                <option value="em" <?php echo $lms_button_unit == "em" ? "selected" : "" ?>>em</option>
                                <option value="px" <?php echo $lms_button_unit == "px" ? "selected" : "" ?>>px</option>
                            </select>
                        </div>
                    </div>
                    <div class="lms-container">
                        <h5><?php echo __("Button background color", "lesson-bookmark-tutor-lms"); ?></h5>
                        <input type="text" name="lms_button_bg_color" value="<?php echo get_option('lms_button_bg_color') ?: "#1da3c9" ?>" class="lms-color-field change-overview" data-default-color="#1da3c9" data-target="tlms-fav-see-lesson-button" data-style="background-color">
                    </div>
                    <div class="lms-container">
                        <h5><?php echo __("Button text color", "lesson-bookmark-tutor-lms"); ?></h5>
                        <input type="text" name="lms_button_txt_color" value="<?php echo get_option('lms_button_txt_color') ?: "#fff" ?>" class="lms-color-field change-overview" data-default-color="#fff" data-target="tlms-fav-see-lesson-button" data-style="color">
                    </div>
                </div>
            </fieldset>
            <?php
            submit_button();
            ?>
        </form>
        <div id="overview">
            <h2><?php echo __("Overview of changes", "lesson-bookmark-tutor-lms") ?></h2>
            <?php
            $grid_template_columns = "style='grid-template-columns: ";
            for ($i = 0; $i < $lms_nb_cols; $i++) {
                $grid_template_columns .= "1fr ";
            }
            $grid_template_columns .= "'"
            ?>
            <div class="tlms-favorites <?php echo $lms_layout == "columns" ? "grid" : "" ?>" <?php echo $lms_layout == "columns" ? $grid_template_columns : ""; ?>>
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <div class="tlms-favorite-container">
                        <div class="tlms-favorite">
                            <span class="dashicons dashicons-heart"></span>
                            <a href="#">
                                <div class="tlms-fav-title"><?php echo sprintf(__('Lesson %d', 'lesson-bookmark-tutor-lms'), $i); ?></div>
                            </a>
                            <div class="tlms-fav-bottom">
                                <div class="tlms-fav-subtitle"><?php echo __('Topic: topic name - Course: course name', 'lesson-bookmark-tutor-lms') ?></div>
                                <span class="tlms-fav-see-lesson"><a href="#" class="tlms-fav-see-lesson-button"><span class="dashicons dashicons-visibility"></span><?php echo __('See lesson', 'lesson-bookmark-tutor-lms') ?></a></span>
                            </div>
                            <span class="dashicons dashicons-no quick-remove-bookmark" data-lesson-id="1808" title="<?php echo __('Remove this bookmark', 'lesson-bookmark-tutor-lms') ?>"></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>