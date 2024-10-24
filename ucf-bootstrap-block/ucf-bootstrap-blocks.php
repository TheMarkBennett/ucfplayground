<?php

/*
Plugin Name: UCF Block Bootstrap Settings
Description: Enqueue Bootstrap for block editor and add settings for main column and wide column widths.
Version: 1.0
*/

// Enqueue Bootstrap CSS for the block editor
function enqueue_bootstrap_for_editor() {
    wp_enqueue_style(
        'my-block-editor-styles', // Handle for the stylesheet
        'https://cdn.jsdelivr.net/gh/TheMarkBennett/ucfplayground/style.min.css', // URL to the GitHub raw file
        array(), // Dependencies (if any)
        null // Version (null disables versioning)
    );
}
add_action( 'enqueue_block_editor_assets', 'enqueue_bootstrap_for_editor' );


// Register the settings page
function ucf_block_bootstrap_register_settings() {
    add_options_page(
        'UCF Block Bootstrap Settings', // Page title
        'UCF Block Bootstrap',          // Menu title
        'manage_options',               // Capability
        'ucf-block-bootstrap',          // Menu slug
        'ucf_block_bootstrap_settings_page' // Callback function to display page
    );

    // Register the settings
    register_setting('ucf_block_bootstrap_settings', 'ucf_main_column_width');
    register_setting('ucf_block_bootstrap_settings', 'ucf_wide_column_width');
}
add_action('admin_menu', 'ucf_block_bootstrap_register_settings');

// Display the settings page
function ucf_block_bootstrap_settings_page() {
    ?>
    <div class="wrap">
        <h1>UCF Block Bootstrap Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('ucf_block_bootstrap_settings');
            do_settings_sections('ucf_block_bootstrap_settings');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Main Column Width</th>
                    <td>
                        <input type="text" name="ucf_main_column_width" value="<?php echo esc_attr(get_option('ucf_main_column_width', '1200px')); ?>" />
                        <p class="description">Enter width (e.g., 1200px, 75%, 80em)</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Wide Column Width</th>
                    <td>
                        <input type="text" name="ucf_wide_column_width" value="<?php echo esc_attr(get_option('ucf_wide_column_width', '1080px')); ?>" />
                        <p class="description">Enter width (e.g., 1080px, 90%, 70em)</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Apply custom editor styles based on settings
function ucf_block_bootstrap_editor_styles() {
    $main_width = esc_attr(get_option('ucf_main_column_width', '1200px'));
    $wide_width = esc_attr(get_option('ucf_wide_column_width', '1080px'));

    echo '
        <style>
            /* Main column width */
            .wp-block { max-width: ' . $main_width . ' !important; }

            /* Width of "wide" blocks */
            .wp-block[data-align="wide"] { max-width: ' . $wide_width . '!important; }

            /* Width of "full-width" blocks */
            .wp-block[data-align="full"] { max-width: none; }
        </style>
    ';
}
add_action('admin_head', 'ucf_block_bootstrap_editor_styles');



add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_58ff540088983',
	'title' => 'College Fields',
	'fields' => array(
		array(
			'key' => 'field_58ff547f2d1ef',
			'label' => 'URL',
			'name' => 'colleges_url',
			'aria-label' => '',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'colleges',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => false,
) );

	acf_add_local_field_group( array(
	'key' => 'group_58f7a73f5fecc',
	'title' => 'Page Header Fields',
	'fields' => array(
		array(
			'key' => 'field_590ca423f6654',
			'label' => 'Header Content',
			'name' => '',
			'aria-label' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
			'selected' => 0,
		),
		array(
			'key' => 'field_59aed971c187c',
			'label' => 'Header Content - Type of Content',
			'name' => 'page_header_content_type',
			'aria-label' => '',
			'type' => 'radio',
			'instructions' => 'Specify the type of content that should be displayed within the header.	Choose "Title and subtitle" to display a styled page title and optional subtitle, or choose "Custom content" to add any arbitrary content.	If "Custom content" is selected, a page title and subtitle are NOT included by default and should be added manually.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'title_subtitle' => 'Title and subtitle',
				'custom' => 'Custom content',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'title_subtitle',
			'layout' => 'vertical',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_58fe096728bcc',
			'label' => 'Header Title Text',
			'name' => 'page_header_title',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => 'Overrides the page title.',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_59aed971c187c',
						'operator' => '==',
						'value' => 'title_subtitle',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_58fe097f28bcd',
			'label' => 'Header Subtitle Text',
			'name' => 'page_header_subtitle',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_59aed971c187c',
						'operator' => '==',
						'value' => 'title_subtitle',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5a0e009ff592e',
			'label' => 'Page h1',
			'name' => 'page_header_h1',
			'aria-label' => '',
			'type' => 'radio',
			'instructions' => 'Specify which part of the page title to use as the h1 for the page.	Styling of the title/subtitle will not be affected by this choice.',
			'required' => 1,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_59aed971c187c',
						'operator' => '==',
						'value' => 'title_subtitle',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'title' => 'Title Text',
				'subtitle' => 'Subtitle Text',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'title',
			'layout' => 'vertical',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_59aed93dc187b',
			'label' => 'Header Custom Contents',
			'name' => 'page_header_content',
			'aria-label' => '',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_59aed971c187c',
						'operator' => '==',
						'value' => 'custom',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
		array(
			'key' => 'field_590ca453f6655',
			'label' => 'Header Size',
			'name' => '',
			'aria-label' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
			'selected' => 0,
		),
		array(
			'key' => 'field_590ca47bf6656',
			'label' => 'Header Height (sm+)',
			'name' => 'page_header_height',
			'aria-label' => '',
			'type' => 'radio',
			'instructions' => 'Height of the page header at the -sm breakpoint and above.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'header-media-default' => 'Default (500px)',
				'header-media-fullscreen' => 'Fullscreen',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'header-media-default',
			'layout' => 'vertical',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_590ca625f6657',
			'label' => 'Header Images',
			'name' => '',
			'aria-label' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
			'selected' => 0,
		),
		array(
			'key' => 'field_58f7a778185ef',
			'label' => 'Header Image (-sm+)',
			'name' => 'page_header_image',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => 'Header image to display at the -sm breakpoint and up.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'header-img-sm',
			'library' => 'all',
			'min_width' => 1200,
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => 'png,jpg,jpeg',
		),
		array(
			'key' => 'field_58f7a7b8185f0',
			'label' => 'Header Image (-xs)',
			'name' => 'page_header_image_xs',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => 'Header image to display at the -xs breakpoint.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'header-img',
			'library' => 'all',
			'min_width' => 575,
			'min_height' => 575,
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => 'png,jpg,jpeg',
		),
		array(
			'key' => 'field_590ca64ef6659',
			'label' => 'Header Video',
			'name' => '',
			'aria-label' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
			'selected' => 0,
		),
		array(
			'key' => 'field_58fe08bf28bc9',
			'label' => 'Header Video (MP4)',
			'name' => 'page_header_mp4',
			'aria-label' => '',
			'type' => 'file',
			'instructions' => 'If a MP4 video is defined, video will be used instead of an image in the header at the -sm breakpoint and higher.	Note that videos will never be displayed at the -xs breakpoint, so a fallback header image should always be provided when using video.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'library' => 'all',
			'min_size' => '',
			'max_size' => '',
			'mime_types' => 'mp4',
		),
		array(
			'key' => 'field_58fe08ff28bca',
			'label' => 'Header Video (WebM)',
			'name' => 'page_header_webm',
			'aria-label' => '',
			'type' => 'file',
			'instructions' => 'Supplemental video format used by supported browsers for optimized performance.	Note that a MP4 must at least be provided for video to be displayed in the header.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'library' => 'all',
			'min_size' => '',
			'max_size' => '',
			'mime_types' => 'webm',
		),
		array(
			'key' => 'field_590c84c7a1360',
			'label' => 'Header Video Loop',
			'name' => 'page_header_video_loop',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => 'If checked, and a header video is available, the header video will loop indefinitely.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Loop video indefinitely',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5a564fecfb51d',
			'label' => 'Navigation',
			'name' => '',
			'aria-label' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
			'selected' => 0,
		),
		array(
			'key' => 'field_5a0dead0cd525',
			'label' => 'Exclude Primary Site Navigation',
			'name' => 'page_header_exclude_nav',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => 'Controls whether or not the primary site navigation should be displayed at the top of the page.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Exclude site navigation',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5a56501afb51e',
			'label' => 'Include Subnavigation',
			'name' => 'page_header_include_subnav',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => 'Enable this setting to display an affixed subnavigation bar below the page header.	Requires the Automatic Sections Menu plugin to be activated, and for at least one section within the page\'s content to be configured to appear in the navbar.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Include subnavigation',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5d655b35e8948',
			'label' => 'Subnavigation Link Population',
			'name' => 'page_header_subnav_link_population',
			'aria-label' => '',
			'type' => 'select',
			'instructions' => 'Specify how links in the subnavigation menu should be populated.	By default, the menu will be populated automatically based on sections included in the page.',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5a56501afb51e',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'automatic' => 'Automatic link detection',
				'custom' => 'Use a custom set of links',
			),
			'default_value' => 'automatic',
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5d655bc3e8949',
			'label' => 'Custom Subnavigation Links',
			'name' => 'page_header_subnav_links',
			'aria-label' => '',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5d655b35e8948',
						'operator' => '==',
						'value' => 'custom',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => 'field_5d655d3ee894a',
			'min' => 1,
			'max' => 0,
			'layout' => 'block',
			'button_label' => 'Add Link',
			'rows_per_page' => 20,
			'sub_fields' => array(
				array(
					'key' => 'field_5d655f1ae894e',
					'label' => 'General',
					'name' => '',
					'aria-label' => '',
					'type' => 'tab',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'placement' => 'top',
					'endpoint' => 0,
					'selected' => 0,
					'parent_repeater' => 'field_5d655bc3e8949',
				),
				array(
					'key' => 'field_5d655d58e894b',
					'label' => 'URL',
					'name' => 'href',
					'aria-label' => '',
					'type' => 'text',
					'instructions' => 'Accepts a standard URL (e.g. "https://www.ucf.edu/") or page anchor ("#my-anchor").',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'parent_repeater' => 'field_5d655bc3e8949',
				),
				array(
					'key' => 'field_5d655d3ee894a',
					'label' => 'Link Text',
					'name' => 'link_text',
					'aria-label' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'parent_repeater' => 'field_5d655bc3e8949',
				),
				array(
					'key' => 'field_5d655dabe894c',
					'label' => 'Open Link in New Window',
					'name' => 'new_window',
					'aria-label' => '',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '30',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
					'parent_repeater' => 'field_5d655bc3e8949',
				),
				array(
					'key' => 'field_5d655e17e894d',
					'label' => 'Relationships ("rel" Attribute)',
					'name' => 'rel',
					'aria-label' => '',
					'type' => 'text',
					'instructions' => 'Add a list of link types, separated by a single space (e.g. "noopener nofollow").	See <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Link_types">link types information</a> for more information.',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '70',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'parent_repeater' => 'field_5d655bc3e8949',
				),
				array(
					'key' => 'field_5d655f32e894f',
					'label' => 'Advanced',
					'name' => '',
					'aria-label' => '',
					'type' => 'tab',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'placement' => 'top',
					'endpoint' => 0,
					'selected' => 0,
					'parent_repeater' => 'field_5d655bc3e8949',
				),
				array(
					'key' => 'field_5d655f61e8950',
					'label' => 'List Item CSS Class',
					'name' => 'li_class',
					'aria-label' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'parent_repeater' => 'field_5d655bc3e8949',
				),
				array(
					'key' => 'field_5d655f70e8951',
					'label' => 'Link CSS Class',
					'name' => 'a_class',
					'aria-label' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'parent_repeater' => 'field_5d655bc3e8949',
				),
				array(
					'key' => 'field_5d656452a22fa',
					'label' => 'Layout',
					'name' => 'layout',
					'aria-label' => '',
					'type' => 'text',
					'instructions' => 'Specify a custom layout for how this individual link is displayed.	Requires a custom layout to be registered for Section Menu Items in the Automatic Section Menus plugin.	See the <a href="https://github.com/UCF/Section-Menus-Shortcode/wiki/Customization" target="_blank">Automatic Section Menus plugin documentation</a> for more information.',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'parent_repeater' => 'field_5d655bc3e8949',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'all',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => false,
) );

	acf_add_local_field_group( array(
	'key' => 'group_5b56304a509c9',
	'title' => 'Person Fields',
	'fields' => array(
		array(
			'key' => 'field_5b577c6238612',
			'label' => 'Title Prefix',
			'name' => 'person_title_prefix',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b577cbd38613',
			'label' => 'Title Suffix',
			'name' => 'person_title_suffix',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b563216fec03',
			'label' => 'Job Title',
			'name' => 'person_jobtitle',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b563259a2356',
			'label' => 'Email',
			'name' => 'person_email',
			'aria-label' => '',
			'type' => 'email',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_5b5632763853a',
			'label' => 'Phone',
			'name' => 'person_phone',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b563055054fb',
			'label' => 'Order By Name',
			'name' => 'person_orderby_name',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => 'The name by which this person should be sorted when people are displayed in alphabetical lists.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'person',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => false,
) );

	acf_add_local_field_group( array(
	'key' => 'group_58f8d037a370f',
	'title' => 'Section Fields',
	'fields' => array(
		array(
			'key' => 'field_58f8d03d1abb3',
			'label' => 'Background Color',
			'name' => 'section_background_color',
			'aria-label' => '',
			'type' => 'select',
			'instructions' => 'Select the background color of the section.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'custom' => 'Custom color',
				'bg-primary' => 'Gold (brand-primary)',
				'bg-secondary' => 'White (brand-secondary)',
				'bg-inverse' => 'Black (brand-inverse)',
				'bg-default' => 'Gray (brand-default)',
				'bg-primary-darkest' => 'Gold Darkest (brand-primary-darkest)',
				'bg-primary-darker' => 'Gold Darker (brand-primary-darker)',
				'bg-primary-lighter' => 'Gold Lighter (brand-primary-lighter)',
				'bg-primary-lightest' => 'Gold Lightest (brand-primary-lightest)',
				'bg-metallic-darkest' => 'Metallic Gold Darkest (brand-metallic-darkest)',
				'bg-metallic-darker' => 'Metallic Gold Darker (brand-metallic-darker)',
				'bg-metallic' => 'Metallic Gold (brand-metallic)',
				'bg-metallic-lighter' => 'Metallic Gold Lighter (brand-metallic-lighter)',
				'bg-metallic-lightest' => 'Metallic Gold Lightest (brand-metallic-lightest)',
				'bg-complementary' => 'Blue (brand-complementary)',
				'bg-success' => 'Green (brand-success)',
				'bg-info' => 'Light Blue (brand-info)',
				'bg-warning' => 'Orange (brand-warning)',
				'bg-danger' => 'Red (brand-danger)',
			),
			'default_value' => false,
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 1,
			'ajax' => 0,
			'return_format' => 'value',
			'placeholder' => '',
		),
		array(
			'key' => 'field_59088a54aa936',
			'label' => 'Custom Background Color',
			'name' => 'section_background_color_custom',
			'aria-label' => '',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_58f8d03d1abb3',
						'operator' => '==',
						'value' => 'custom',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'enable_opacity' => false,
			'return_format' => 'string',
		),
		array(
			'key' => 'field_59089420aa937',
			'label' => 'Text Color',
			'name' => 'section_text_color',
			'aria-label' => '',
			'type' => 'select',
			'instructions' => 'Override the default text color within the section.

Note that if you picked a predefined color in the Background Color field, an accessible text color will already be applied.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'custom' => 'Custom color',
				'text-primary' => 'Gold (brand-primary)',
				'text-secondary' => 'Black (brand-secondary)',
				'text-inverse' => 'White (brand-inverse)',
				'text-default' => 'Gray (brand-default)',
				'text-primary-aw' => 'Gold AW (brand-primary, against-white accessible)',
				'text-secondary-aw' => 'Black AW (brand-secondary, against-white accessible)',
				'text-inverse-aw' => 'White AW (brand-inverse, against-white accessible)',
				'text-default-aw' => 'Gray AW (brand-default, against-white accessible)',
				'text-primary-darkest' => 'Gold Darkest (brand-primary-darkest)',
				'text-primary-darker' => 'Gold Darker (brand-primary-darker)',
				'text-primary-lighter' => 'Gold Lighter (brand-primary-lighter)',
				'text-primary-lightest' => 'Gold Lightest (brand-primary-lightest)',
				'text-metallic-darkest' => 'Metallic Gold Darkest (brand-metallic-darkest)',
				'text-metallic-darker' => 'Metallic Gold Darker (brand-metallic-darker)',
				'text-metallic' => 'Metallic Gold (brand-metallic)',
				'text-metallic-lighter' => 'Metallic Gold Lighter (brand-metallic-lighter)',
				'text-metallic-lightest' => 'Metallic Gold Lightest (brand-metallic-lightest)',
				'text-complementary' => 'Blue (brand-complementary)',
				'text-success' => 'Green (brand-success)',
				'text-info' => 'Light Blue (brand-info)',
				'text-warning' => 'Orange (brand-warning)',
				'text-danger' => 'Red (brand-danger)',
				'text-complementary-aw' => 'Blue AW (brand-complementary, against-white accessible)',
				'text-success-aw' => 'Green AW (brand-success, against-white accessible)',
				'text-info-aw' => 'Light Blue AW (brand-info, against-white accessible)',
				'text-warning-aw' => 'Orange AW (brand-warning, against-white accessible)',
				'text-danger-aw' => 'Red AW (brand-danger, against-white accessible)',
			),
			'default_value' => false,
			'allow_null' => 1,
			'multiple' => 0,
			'ui' => 1,
			'ajax' => 0,
			'return_format' => 'value',
			'placeholder' => '',
		),
		array(
			'key' => 'field_59089624aa938',
			'label' => 'Custom Text Color',
			'name' => 'section_text_color_custom',
			'aria-label' => '',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_59089420aa937',
						'operator' => '==',
						'value' => 'custom',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'enable_opacity' => false,
			'return_format' => 'string',
		),
		array(
			'key' => 'field_58f8d0611abb4',
			'label' => 'Background Image (-sm+)',
			'name' => 'section_background_image',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => 'The background image to display behind the section at the -sm breakpoint and up (576px+ wide).',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'bg-img-sm',
			'library' => 'all',
			'min_width' => 767,
			'min_height' => '',
			'min_size' => '',
			'max_width' => 1600,
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_58f8d08b1abb5',
			'label' => 'Background Image (-xs)',
			'name' => 'section_background_image_xs',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => 'The background image to display behind the section at the -xs breakpoint (<=575px wide).	This image is only displayed when a -sm background image has also been selected.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'bg-img',
			'library' => 'all',
			'min_width' => 575,
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'ucf_section',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => false,
) );
} );