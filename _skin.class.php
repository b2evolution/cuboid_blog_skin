<?php
/**
 * This file implements a class derived of the generic Skin class in order to provide custom code for
 * the skin in this folder.
 *
 * This file is part of the b2evolution project - {@link http://b2evolution.net/}
 *
 * @package skins
 * @subpackage starter_skin
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
 * Specific code for this skin.
 *
 * ATTENTION: if you make a new skin you have to change the class name below accordingly
 */
class cuboid_blog_Skin extends Skin
{
	var $version = '1.0';
	/**
	 * Do we want to use style.min.css instead of style.css ?
	 */
	var $use_min_css = 'check';  // true|false|'check' Set this to true for better optimization
	// Note: we leave this on "check" in the bootstrap_blog_skin so it's easier for beginners to just delete the .min.css file
	// But for best performance, you should set it to true.

	/**
	 * Get default name for the skin.
	 * Note: the admin can customize it.
	 */
	function get_default_name()
	{
		return 'Cuboid Blog';
	}


	/**
	 * Get default type for the skin.
	 */
	function get_default_type()
	{
		return 'normal';
	}


	/**
	 * What evoSkins API does has this skin been designed with?
	 *
	 * This determines where we get the fallback templates from (skins_fallback_v*)
	 * (allows to use new markup in new b2evolution versions)
	 */
	function get_api_version()
	{
		return 6;
	}


	/**
	 * Get definitions for editable params
	 *
	 * @see Plugin::GetDefaultSettings()
	 * @param local params like 'for_editing' => true
	 */
	function get_param_definitions( $params )
	{

      // Load to use function get_available_thumb_sizes()
      load_funcs( 'files/model/_image.funcs.php' );

		$r = array_merge( array(
            'general_settings_start' => array(
               'layout' => 'begin_fieldset',
               'label'  => T_('General settings')
            ),
               // Layout
               'layout' => array(
                  'label'        => T_('Layout'),
                  'note'         => '',
                  'defaultvalue' => 'right_sidebar',
                  'type'         => 'select',
                  'options'      => array(
                     'single_column'              => T_('Single Column Large'),
                     'single_column_normal'       => T_('Single Column'),
                     'single_column_narrow'       => T_('Single Column Narrow'),
                     'single_column_extra_narrow' => T_('Single Column Extra Narrow'),
                     'left_sidebar'               => T_('Left Sidebar'),
                     'right_sidebar'              => T_('Right Sidebar'),
                  ),
               ),
               'max_image_height' => array(
                  'label'        => T_('Max image height'),
                  'note'         => 'px',
                  'defaultvalue' => '',
                  'type'         => 'integer',
                  'allow_empty'  => true,
               ),
               'color_schemes' => array(
                  'label'        => T_('Color Schemes'),
                  'note'         => T_('Default value is #1ABC9C'),
                  'defaultvalue' => '#1ABC9C',
                  'type'         => 'color',
               ),
               'background_type' => array(
                  'label'    => T_('Site Background Style'),
                  'note'     => '',
                  'type'     => 'radio',
                  'options'  => array(
                     array( 'color', T_('Background Color') ),
                     array( 'images', T_('Image Pattern') ),
                  ),
                  'defaultvalue' => 'images',
               ),
               'bg_image' => array(
                  'label'    => T_('Background Image Pattern'),
                  'note'     => T_('Choose your favorite background image pattern'),
                  'type'     => 'select',
                  'options'  => array(
                     'bg_1'     => T_('Pattern 1'),
                     'bg_2'     => T_('Pattern 2'),
                     'bg_3'     => T_('Pattern 3'),
                     'bg_4'     => T_('Pattern 4'),
                     'bg_5'     => T_('Pattern 5'),
                     'bg_6'     => T_('Pattern 6'),
                  ),
                  'defaultvalue' => 'bg_1',
               ),
               'site_background_color' => array(
                  'label'        => T_('Site Background Color'),
                  'note'         => T_('Default value is #F5F7F9'),
                  'defaultvalue' => '#F5F7F9',
                  'type'         => 'color',
               ),

               // Favicon
               'favicon' => array (
                  'label'        => T_( 'Favicon' ),
                  'note'         => T_( 'Change the default favicon' ),
                  'defaultvalue' => 'assets/images/favicon.png',
                  'type'         => 'text',
                  'size'         => '50'
               ),

               // Back To Top
               'bt_top' => array(
                  'label'        => T_('Display Button Back To Top'),
                  'note'         => T_('Check to enable button back to top.'),
                  'defaultvalue' => 1,
                  'type'         => 'checkbox',
               ),
            'general_settings_end' => array(
               'layout' => 'end_fieldset',
            ),

            /**
             * ============================================================================
             * Header Settings
             * ============================================================================
             */
            'header_settings_start' => array(
               'layout' => 'begin_fieldset',
               'label'  => T_('Header settings')
            ),
               'header_bg_color' => array(
                  'label'        => T_('Header Background Color'),
                  'note'         => T_('Default value is #262626'),
                  'defaultvalue' => '#262626',
                  'type'         => 'color',
               ),
            'header_settings_end' => array(
               'layout' => 'end_fieldset',
            ),
            // End Header Settings

            /**
             * ============================================================================
             * Posts Disp
             * ============================================================================
             */
            'posts_settings_start' => array(
               'layout' => 'begin_fieldset',
               'label'  => T_('Post Settings')
            ),
               'posts_layout' => array(
                  'label'        => T_('Posts Layout'),
                  'note'         => T_('Select Single Layout for post 3 column'),
                  'type'         => 'select',
                  'options'      => array(
                     'single_column'              => T_('Single Column Large'),
                     'single_column_normal'       => T_('Single Column'),
                     'single_column_narrow'       => T_('Single Column Narrow'),
                     'single_column_extra_narrow' => T_('Single Column Extra Narrow'),
                     'left_sidebar'               => T_('Left Sidebar'),
                     'right_sidebar'              => T_('Right Sidebar'),
                  ),
                  'defaultvalue' => 'right_sidebar',
               ),
               'posts_column' => array(
                  'label'    => T_('Posts Content Masonry'),
                  'note'     => '',
                  'type'     => 'radio',
                  'options'  => array(
                     array( 'one', T_('1 Column') ),
                     array( 'two', T_('2 Column') ),
                     array( 'three', T_('3 Column') ),
                  ),
                  'defaultvalue' => 'one',
               ),
               'posts_content_mode' => array(
                  'label'    => T_('Posts Content Mode'),
                  'note'     => '',
                  'type'     => 'radio',
                  'options'  => array(
                     array( 'auto', T_('Auto') ),
                     array( 'excerpt', T_('Excerpt') ),
                  ),
                  'defaultvalue' => 'excerpt',
               ),
               'pagination_layout' => array(
                  'label'        => T_('Pagination Layout'),
                  'note'         => T_('Select Layout for Pagination'),
                  'type'         => 'select',
                  'options'      => array(
                     'left'   => T_('Left'),
                     'center' => T_('Centers'),
                     'right'  => T_('Right'),
                  ),
                  'defaultvalue' => 'center',
               ),
            'posts_settings_end' => array(
               'layout' => 'end_fieldset',
            ),
            // End Single Disp

            /**
             * ============================================================================
             * Single Disp
             * ============================================================================
             */
            'single_settings_start' => array(
               'layout' => 'begin_fieldset',
               'label'  => T_('Single and Page Disp')
            ),
               // Single Layout
               'single_layout' => array(
                  'label'        => T_('Single and Page Layout'),
                  'note'         => '',
                  'defaultvalue' => 'single_column',
                  'type'         => 'select',
                  'options'      => array(
                     'single_column'              => T_('Single Column Large'),
                     'single_column_normal'       => T_('Single Column'),
                     'single_column_narrow'       => T_('Single Column Narrow'),
                     'single_column_extra_narrow' => T_('Single Column Extra Narrow'),
                     'left_sidebar'               => T_('Left Sidebar'),
                     'right_sidebar'              => T_('Right Sidebar'),
                  ),
               ),
            'single_settings_end' => array(
               'layout' => 'end_fieldset',
            ),
            // End Single Disp

            /**
             * ============================================================================
             * Footer Settings
             * ============================================================================
             */
            'footer_settings_start' => array(
               'layout' => 'begin_fieldset',
               'label'  => T_('Footer Settings')
            ),
               'footer_bg_color' => array(
                  'label'        => T_('Footer Main Background Color'),
                  'note'         => T_('Default value is #262626'),
                  'defaultvalue' => '#262626',
                  'type'         => 'color',
               ),
               'footer_widget' => array(
                  'label'        => T_('Display Footer Widget'),
                  'note'         => T_('Check to enable footer widget.'),
                  'defaultvalue' => 1,
                  'type'         => 'checkbox',
               ),
               'footer_border_color' => array(
                  'label'        => T_('Footer Border Color'),
                  'note'         => T_('Default value is #3c3c3c'),
                  'defaultvalue' => '#3c3c3c',
                  'type'         => 'color',
               ),
               'footer_tags_bg' => array(
                  'label'        => T_('Tags Widget Background Color'),
                  'note'         => T_('Default value is #333333'),
                  'defaultvalue' => '#333333',
                  'type'         => 'color',
               ),
               'footer_user_link' => array(
                  'label'        => T_('Display Footer User Links'),
                  'note'         => T_('Check to enable widget user links.'),
                  'defaultvalue' => 1,
                  'type'         => 'checkbox',
               ),
               'footer_copyright' => array(
                  'label'        => T_('Display Footer Copyright'),
                  'note'         => T_('Check to display footer copyright.'),
                  'defaultvalue' => 1,
                  'type'         => 'checkbox',
               ),
               'footer_sm_bgcolor' => array(
                  'label'        => T_('Social Media Background Color'),
                  'note'         => T_('Default value is #212121'),
                  'defaultvalue' => '#212121',
                  'type'         => 'color',
               ),
            'footer_settings_end' => array(
               'layout' => 'end_fieldset',
            ),
            // End Footer Settings

            /**
             * ============================================================================
             * Mediaidx Posts
             * ============================================================================
             */
            'section_media_start' => array(
               'layout'   => 'begin_fieldset',
               'label'    => T_( 'Media Posts' )
            ),
               // Single Layout
               'mediaidx_layout' => array(
                  'label'        => T_('Media Posts Layout'),
                  'note'         => '',
                  'defaultvalue' => 'single_column',
                  'type'         => 'select',
                  'options'      => array(
                     'single_column'              => T_('Single Column Large'),
                     'single_column_normal'       => T_('Single Column'),
                     'single_column_narrow'       => T_('Single Column Narrow'),
                     'single_column_extra_narrow' => T_('Single Column Extra Narrow'),
                     'left_sidebar'               => T_('Left Sidebar'),
                     'right_sidebar'              => T_('Right Sidebar'),
                  ),
               ),
               'mediaidx_thumb_size' => array(
                  'label'        => T_('Thumbnail size for media index'),
                  'note'         => '',
                  'defaultvalue' => 'crop-480x320',
                  'options'      => get_available_thumb_sizes(),
                  'type'         => 'select',
               ),
               'mediaidx_grid' => array(
						'label'          => T_('Column'),
						'note'           => '',
						'defaultvalue'   => 'three_column',
                  'type'           => 'select',
						'options'        => array(
                        'one_column'     => T_('1 Column'),
								'two_column'     => T_('2 Column'),
								'three_column'   => T_('3 Column'),
							),
					),
               'padding_column' => array(
                  'label'          => T_('Padding Image Column'),
                  'note'           => T_('px ( default padding 15px )'),
                  'defaultvalue'   => '15',
                  'type'           => 'integer',
                  'allow_empty'    => true,
               ),
            'section_media_end'   => array(
               'layout'   => 'end_fieldset',
            ),

            /**
             * ============================================================================
             * Colorbox Image Zoom
             * ============================================================================
             */
				'section_colorbox_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Colorbox Image Zoom')
				),
					'colorbox' => array(
						'label'        => T_('Colorbox Image Zoom'),
						'note'         => T_('Check to enable javascript zooming on images (using the colorbox script)'),
						'defaultvalue' => 1,
						'type'         => 'checkbox',
					),
					'colorbox_vote_post' => array(
						'label'        => T_('Voting on Post Images'),
						'note'         => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
						'defaultvalue' => 1,
						'type'         => 'checkbox',
					),
					'colorbox_vote_post_numbers' => array(
						'label'        => T_('Display Votes'),
						'note'         => T_('Check to display number of likes and dislikes'),
						'defaultvalue' => 1,
						'type'         => 'checkbox',
					),
					'colorbox_vote_comment' => array(
						'label'        => T_('Voting on Comment Images'),
						'note'         => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
						'defaultvalue' => 1,
						'type'         => 'checkbox',
					),
					'colorbox_vote_comment_numbers' => array(
						'label'        => T_('Display Votes'),
						'note'         => T_('Check to display number of likes and dislikes'),
						'defaultvalue' => 1,
						'type'         => 'checkbox',
					),
					'colorbox_vote_user' => array(
						'label'        => T_('Voting on User Images'),
						'note'         => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
						'defaultvalue' => 1,
						'type'         => 'checkbox',
					),
					'colorbox_vote_user_numbers' => array(
						'label'        => T_('Display Votes'),
						'note'         => T_('Check to display number of likes and dislikes'),
						'defaultvalue' => 1,
						'type'         => 'checkbox',
					),
				'section_colorbox_end' => array(
					'layout' => 'end_fieldset',
				),


				'section_username_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Username options')
				),
					'gender_colored' => array(
						'label'        => T_('Display gender'),
						'note'         => T_('Use colored usernames to differentiate men & women.'),
						'defaultvalue' => 0,
						'type'         => 'checkbox',
					),
					'bubbletip' => array(
						'label'        => T_('Username bubble tips'),
						'note'         => T_('Check to enable bubble tips on usernames'),
						'defaultvalue' => 0,
						'type'         => 'checkbox',
					),
					'autocomplete_usernames' => array(
						'label'        => T_('Autocomplete usernames'),
						'note'         => T_('Check to enable auto-completion of usernames entered after a "@" sign in the comment forms'),
						'defaultvalue' => 1,
						'type'         => 'checkbox',
					),
				'section_username_end' => array(
					'layout' => 'end_fieldset',
				),

				'section_access_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('When access is denied or requires login...')
				),
					'access_login_containers' => array(
						'label'   => T_('Display on login screen'),
						'note'    => '',
						'type'    => 'checklist',
						'options' => array(
							array( 'header',   sprintf( T_('"%s" container'), NT_('Header') ),    1 ),
							array( 'page_top', sprintf( T_('"%s" container'), NT_('Page Top') ),  1 ),
							array( 'menu',     sprintf( T_('"%s" container'), NT_('Menu') ),      0 ),
							array( 'sidebar',  sprintf( T_('"%s" container'), NT_('Sidebar') ),   0 ),
							array( 'sidebar2', sprintf( T_('"%s" container'), NT_('Sidebar 2') ), 0 ),
							array( 'footer',   sprintf( T_('"%s" container'), NT_('Footer') ),    1 ) ),
						),
				'section_access_end' => array(
					'layout' => 'end_fieldset',
				),

			), parent::get_param_definitions( $params ) );

		return $r;
	}


	/**
	 * Get ready for displaying the skin.
	 *
	 * This may register some CSS or JS...
	 */
	function display_init()
	{
		global $Messages, $debug, $disp;

		// Request some common features that the parent function (Skin::display_init()) knows how to provide:
		parent::display_init( array(
			'jquery',                  // Load jQuery
			'font_awesome',            // Load Font Awesome (and use its icons as a priority over the Bootstrap glyphicons)
			'bootstrap',               // Load Bootstrap (without 'bootstrap_theme_css')
			'bootstrap_evo_css',       // Load the b2evo_base styles for Bootstrap (instead of the old b2evo_base styles)
			'bootstrap_messages',      // Initialize $Messages Class to use Bootstrap styles
			'style_css',               // Load the style.css file of the current skin
			'colorbox',                // Load Colorbox (a lightweight Lightbox alternative + customizations for b2evo)
			'bootstrap_init_tooltips', // Inline JS to init Bootstrap tooltips (E.g. on comment form for allowed file extensions)
			'disp_auto',               // Automatically include additional CSS and/or JS required by certain disps (replace with 'disp_off' to disable this)
		) );

      // Include Masonry Grind for MediaIdx
      if ( $disp == 'mediaidx' || $disp == 'posts' ) {
         require_js( $this->get_url() . 'assets/js/masonry.pkgd.min.js' );
         require_js( $this->get_url() . 'assets/js/imagesloaded.pkgd.min.js' );
      }

      if( $disp == 'posts' ) {
         add_js_headline("
				jQuery( document ).ready( function($) {
               $('.main_item_posts').imagesLoaded().done( function( instance ) {
                  $('.main_item_posts').masonry({
                   // options
                    itemSelector: '.item_posts',
                 });
               });
				});
			");
      }

      if ( $disp == 'mediaidx' ) {
         add_js_headline("
				jQuery( document ).ready( function($) {
               $('.evo_image_index').imagesLoaded().done( function( instance ) {
                  $('.evo_image_index').masonry({
                   // options
                    itemSelector: '.grid-item',
                 });
               });
				});
			");
      }

      require_js( $this->get_url().'assets/js/script.js' );

		// Skin specific initializations:

		// Limit images by max height:
		$max_image_height = intval( $this->get_setting( 'max_image_height' ) );
		if( $max_image_height > 0 )
		{
			add_css_headline( '.evo_image_block img { max-height: '.$max_image_height.'px; width: auto; }' );
		}

      // Skin specific initializations:
		// Add custom CSS:
		$custom_css = '';


      /**
       * ============================================================================
       * General Settings Output
       * ============================================================================
       */
      if ( $color = $this->get_setting( 'color_schemes' ) ) {
         // General
         $custom_css .= '
         a, a:hover, a:active, a:focus,
         .disp_search #main-content .search_result .search_content_wrap .search_title a:hover, .disp_search #main-content .search_result .search_content_wrap .search_title a:active, .disp_search #main-content .search_result .search_content_wrap .search_title a:focus,
         .widget_plugin_evo_Calr .bCalendarTable tfoot a:hover
         { color: '.$color.'; }

         /* Header */
         .navbar-collapse .nav.nav-tabs li a::after
         { background-color: '.$color.'; }

         /* Posts */
         #content .evo_post_title h2 a:hover,
         #main-content .evo_post .small.text-muted a:hover, #main-content .evo_featured_post .small.text-muted a:hover,
         .disp_search #main-content .search_result .search_result_score.dimmed
         { color: '.$color.'; }

         #main-content .evo_intro_post, #main-content .featurepost,
         .pagination > .active > span, .pagination > .active > span:hover, .pagination > li > a:hover,
         #main-content .post_tags a:hover, #main-content .post_tags a:active, #main-content .post_tags a:focus,
         #main-content .evo_post .evo_post__full .evo_post_more_link a:hover, #main-content .evo_featured_post .evo_post__full .evo_post_more_link a:hover, #main-content .evo_post .evo_post__excerpt .evo_post_more_link a:hover, #main-content .evo_featured_post .evo_post__excerpt .evo_post_more_link a:hover, #main-content .evo_post .evo_post__full .evo_post__excerpt_more_link a:hover, #main-content .evo_featured_post .evo_post__full .evo_post__excerpt_more_link a:hover, #main-content .evo_post .evo_post__excerpt .evo_post__excerpt_more_link a:hover, #main-content .evo_featured_post .evo_post__excerpt .evo_post__excerpt_more_link a:hover, #main-content .evo_post .evo_post__full .evo_post_more_link a:active, #main-content .evo_featured_post .evo_post__full .evo_post_more_link a:active, #main-content .evo_post .evo_post__excerpt .evo_post_more_link a:active, #main-content .evo_featured_post .evo_post__excerpt .evo_post_more_link a:active, #main-content .evo_post .evo_post__full .evo_post__excerpt_more_link a:active, #main-content .evo_featured_post .evo_post__full .evo_post__excerpt_more_link a:active, #main-content .evo_post .evo_post__excerpt .evo_post__excerpt_more_link a:active, #main-content .evo_featured_post .evo_post__excerpt .evo_post__excerpt_more_link a:active, #main-content .evo_post .evo_post__full .evo_post_more_link a:focus, #main-content .evo_featured_post .evo_post__full .evo_post_more_link a:focus, #main-content .evo_post .evo_post__excerpt .evo_post_more_link a:focus, #main-content .evo_featured_post .evo_post__excerpt .evo_post_more_link a:focus, #main-content .evo_post .evo_post__full .evo_post__excerpt_more_link a:focus, #main-content .evo_featured_post .evo_post__full .evo_post__excerpt_more_link a:focus, #main-content .evo_post .evo_post__excerpt .evo_post__excerpt_more_link a:focus, #main-content .evo_featured_post .evo_post__excerpt .evo_post__excerpt_more_link a:focus,
         .disp_front #main-content .widget_core_coll_featured_intro .jumbotron,
         .disp_front #main-content .widget_core_poll .btn-default.active, .disp_front #main-content .widget_core_poll .btn-default.focus, .disp_front #main-content .widget_core_poll .btn-default:active, .disp_front #main-content .widget_core_poll .btn-default:focus, .disp_front #main-content .widget_core_poll .btn-default:hover, .disp_front #main-content .widget_core_poll .open > .dropdown-toggle.btn-default,
         .disp_search #main-content .search_result .search_result_score.dimmed::after,
         .disp_threads #main-content .SaveButton.btn-primary, .disp_messages #main-content .SaveButton.btn-primary, .disp_contacts #main-content .SaveButton.btn-primary,
         .disp_contacts .form_send_contacts .btn-default:hover, .disp_contacts .form_send_contacts .btn-default:active, .disp_contacts .form_send_contacts .btn-default:focus,
         .filters .btn-info,
         .disp_threads #main-content .results .action_icon.btn-primary, .disp_messages #main-content .results .action_icon.btn-primary, .disp_contacts #main-content .results .action_icon.btn-primary,
         .btn-success
         { background-color: '.$color.'; }

         .disp_front #main-content .widget_core_poll .btn-default.active, .disp_front #main-content .widget_core_poll .btn-default.focus, .disp_front #main-content .widget_core_poll .btn-default:active, .disp_front #main-content .widget_core_poll .btn-default:focus, .disp_front #main-content .widget_core_poll .btn-default:hover, .disp_front #main-content .widget_core_poll .open > .dropdown-toggle.btn-default,
         .disp_search #main-content .search_result .search_result_score.dimmed,
         .disp_threads #main-content .SaveButton.btn-primary, .disp_messages #main-content .SaveButton.btn-primary, .disp_contacts #main-content .SaveButton.btn-primary,
         .disp_contacts .form_send_contacts .btn-default:hover, .disp_contacts .form_send_contacts .btn-default:active, .disp_contacts .form_send_contacts .btn-default:focus,
         .filters .btn-info,
         .disp_threads #main-content .results .action_icon.btn-primary, .disp_messages #main-content .results .action_icon.btn-primary, .disp_contacts #main-content .results .action_icon.btn-primary,
         .disp_threads #main-content .evo_form__thread input:focus, .disp_messages #main-content .evo_form__thread input:focus, .disp_contacts #main-content .evo_form__thread input:focus, .disp_threads #main-content .evo_form__thread textarea:focus, .disp_messages #main-content .evo_form__thread textarea:focus, .disp_contacts #main-content .evo_form__thread textarea:focus,
         .btn-success
         { border-color: '.$color.'; }

         .disp_posts #content .evo_featured_post
         { border-left-color: '.$color.'; }

         /* Sidebar - Widget - Single */
         .evo_widget a:hover, .evo_widget a:active, .evo_widget a:focus,
         #main-footer .main_widget a:hover, #main-footer .main_widget a:active, #main-footer .main_widget a:focus,
         .evo_comment .evo_comment_info .delete_link:hover, .evo_comment__preview .evo_comment_info .delete_link:hover, .evo_comment .evo_comment_info .edit_link:hover, .evo_comment__preview .evo_comment_info .edit_link:hover, .evo_comment .evo_comment_info .delete_link:active, .evo_comment__preview .evo_comment_info .delete_link:active, .evo_comment .evo_comment_info .edit_link:active, .evo_comment__preview .evo_comment_info .edit_link:active, .evo_comment .evo_comment_info .delete_link:focus, .evo_comment__preview .evo_comment_info .delete_link:focus, .evo_comment .evo_comment_info .edit_link:focus, .evo_comment__preview .evo_comment_info .edit_link:focus,
         .disp_comments #main-content .evo_comment .evo_comment_title.first a,
         .evo_comment .evo_comment_title a:hover, .evo_comment__preview .evo_comment_title a:hover
         { color: '.$color.'; }

         .widget_core_coll_search_form .search .search_submit,
         .tag_cloud a:hover, .tag_cloud a:active, .tag_cloud a:focus,
         .widget_plugin_evo_Calr .bCalendarTable #bCalendarToday,
         #main-footer .main_widget .widget_core_coll_tag_cloud .tag_cloud a:hover, #main-footer .main_widget .widget_core_coll_tag_cloud .tag_cloud a:active, #main-footer .main_widget .widget_core_coll_tag_cloud .tag_cloud a:focus,
         .bt-top:hover, .bt-top:focus, .bt-top:active,
         .disp_single #feedbacks .evo_comment__meta_info a:hover, .disp_page #feedbacks .evo_comment__meta_info a:hover,
         #comment_form .evo_form .submit,
         #comment_form .evo_form .preview:hover, #comment_form .evo_form .preview:focus, #comment_form .evo_form .preview:active,
         .widget_core_user_login .submit:hover, .widget_core_user_register .submit:hover,
         .disp_single #main-content .pager .previous a::before, .disp_page #main-content .pager .previous a::before, .disp_single #main-content .pager .next a::before, .disp_page #main-content .pager .next a::before,
         .evo_post_comment_notification .btn:hover, .evo_post_comment_notification .btn:active, .evo_post_comment_notification .btn:focus
         { background-color: '.$color.'; }

         .widget_core_coll_search_form .search .search_field,
         .widget_core_coll_search_form .search .search_submit,
         .bt-top:hover, .bt-top:focus, .bt-top:active,
         .disp_single #feedbacks .evo_comment__meta_info a:hover, .disp_page #feedbacks .evo_comment__meta_info a:hover,
         #comment_form .evo_form .form_text_input:focus, #comment_form .evo_form .form_textarea_input:focus,
         #comment_form .evo_form .submit,
         #comment_form .evo_form .preview:hover, #comment_form .evo_form .preview:focus, #comment_form .evo_form .preview:active,
         .widget_core_user_login .submit:hover, .widget_core_user_register .submit:hover,
         .disp_single #main-content .pager .previous a:hover, .disp_page #main-content .pager .previous a:hover, .disp_single #main-content .pager .next a:hover, .disp_page #main-content .pager .next a:hover,
         .evo_post_comment_notification .btn:hover, .evo_post_comment_notification .btn:active, .evo_post_comment_notification .btn:focus
         { border-color: '.$color.'; }
         ';
      }


      // Site Background
      $bg_image = $this->get_setting( 'bg_image' );
      if ( $this->get_setting( 'background_type' ) == 'images' && $bg_image ) {
         switch( $bg_image ) {
            case 'bg_1': // When regular layout is chosen, nothing happens, since regular is default
               $custom_css .= 'body { background-image: url("assets/images/bg-1.png"); }';
            break;

            case 'bg_2':
               $custom_css .= 'body { background-image: url("assets/images/bg-2.png"); }';
            break;

            case 'bg_3':
               $custom_css .= 'body { background-image: url("assets/images/bg-3.png"); }';
            break;

            case 'bg_4':
               $custom_css .= 'body { background-image: url("assets/images/bg-4.png"); }';
            break;

            case 'bg_5':
               $custom_css .= 'body { background-image: url("assets/images/bg-5.png"); }';
            break;

            case 'bg_6':
               $custom_css .= 'body { background-image: url("assets/images/bg-6.png"); }';
            break;
         }
      }

      if ( $this->get_setting( 'background_type' ) == 'color' ) {
         $color = $this->get_setting( 'site_background_color' );
         $custom_css .= 'body {background-color: '.$color.';}';
      }

      /**
       * ============================================================================
       * Header Settings Output
       * ============================================================================
       */
		if( $color = $this->get_setting( 'header_bg_color' ) ) {
			$custom_css .= 'body #main-header { background-color: '.$color." }\n";
		}
      if( $color = $this->get_setting( 'head_tagline_bg_color' ) ) {
			$custom_css .= 'body #head_tagline { background-color: '.$color." }\n";
		}

      /**
       * ============================================================================
       * Footer Settings Output
       * ============================================================================
       */
		if ( $bg_color = $this->get_setting( 'footer_bg_color' ) ) {
			$custom_css .= 'body #main-footer { background-color: '.$bg_color." }\n";
		}

      if ( $bg_color = $this->get_setting( 'footer_sm_bgcolor' ) ) {
         $custom_css .= '#main-footer .footer_social_media{ background-color: '.$bg_color.'; }';
      }

      if ( $border_color = $this->get_setting( 'footer_border_color' ) ) {
         $custom_css .= '#main-footer .main_widget ul li, #main-footer .main_widget ul > ul > li:last-child { border-color: '.$border_color.'; }';
         $custom_css .= '#main-footer .footer_social_media, #main-footer .copyright,
         #main-footer .main_widget .widget_core_coll_xml_feeds .notes
         { border-top-color: '.$border_color.'; }';
      }

      if ( $bg_color = $this->get_setting( 'footer_tags_bg' ) ) {
         $custom_css .= '#main-footer .evo_widget .tag_cloud a { background-color: '.$bg_color.'; }';
      }

      /**
       * ============================================================================
       * Mediaidx Custom Style
       * ============================================================================
       */
      if ( $padding = $this->get_setting( 'padding_column' ) ) {
         $custom_css .= '.disp_mediaidx #main-content .evo_image_index .grid-item { padding: '.$padding.'px; }';
         $custom_css .= '.disp_mediaidx #main-content .evo_image_index { margin-left: -'.$padding.'px; margin-right: -'.$padding.'px; }';
      }

      /**
       * ============================================================================
       * Output CSS
       * ============================================================================
       */
      if( ! empty( $custom_css ) )
		{ // Function for custom_css:
		$custom_css = '<style type="text/css">
         <!--
         '.$custom_css.'
         -->
		</style>';
		add_headline( $custom_css );
		}

	}


	/**
	 * Those templates are used for example by the messaging screens.
	 */
	function get_template( $name )
	{
		switch( $name )
		{
			case 'Results':
				// Results list (Used to view the lists of the users, messages, contacts and etc.):
				return array(
					'page_url'                => '', // All generated links will refer to the current page
					'before'                  => '<div class="results panel panel-default">',
					'content_start'           => '<div id="$prefix$ajax_content">',
					'header_start'            => '',
					'header_text'             => '<div class="center"><ul class="pagination">'
                     						   .'$prev$$first$$list_prev$$list$$list_next$$last$$next$'
            						            .'</ul></div>',
					'header_text_single'      => '',
					'header_end'              => '',
					'head_title'              => '<div class="panel-heading fieldset_title"><span class="pull-right">$global_icons$</span><h3 class="panel-title">$title$</h3></div>'."\n",
					'global_icons_class'      => 'btn btn-default btn-sm',
					'filters_start'           => '<div class="filters panel-body">',
					'filters_end'             => '</div>',
					'filter_button_class'     => 'btn-sm btn-info',
					'filter_button_before'    => '<div class="form-group pull-right">',
					'filter_button_after'     => '</div>',
					'messages_start'          => '<div class="messages form-inline">',
					'messages_end'            => '</div>',
					'messages_separator'      => '<br />',
					'list_start'              => '<div class="table_scroll">'."\n"
					                            .'<table class="table table-striped table-bordered table-hover table-condensed" cellspacing="0">'."\n",
					'head_start'              => "<thead>\n",
					'line_start_head'         => '<tr>',  // TODO: fusionner avec colhead_start_first; mettre a jour admin_UI_general; utiliser colspan="$headspan$"
					'colhead_start'           => '<th $class_attrib$>',
					'colhead_start_first'     => '<th class="firstcol $class$">',
					'colhead_start_last'      => '<th class="lastcol $class$">',
					'colhead_end'             => "</th>\n",
					'sort_asc_off'            => get_icon( 'sort_asc_off' ),
					'sort_asc_on'             => get_icon( 'sort_asc_on' ),
					'sort_desc_off'           => get_icon( 'sort_desc_off' ),
					'sort_desc_on'            => get_icon( 'sort_desc_on' ),
					'basic_sort_off'          => '',
					'basic_sort_asc'          => get_icon( 'ascending' ),
					'basic_sort_desc'         => get_icon( 'descending' ),
					'head_end'                => "</thead>\n\n",
					'tfoot_start'             => "<tfoot>\n",
					'tfoot_end'               => "</tfoot>\n\n",
					'body_start'              => "<tbody>\n",
					'line_start'              => '<tr class="even">'."\n",
					'line_start_odd'          => '<tr class="odd">'."\n",
					'line_start_last'         => '<tr class="even lastline">'."\n",
					'line_start_odd_last'     => '<tr class="odd lastline">'."\n",
					'col_start'               => '<td $class_attrib$>',
					'col_start_first'         => '<td class="firstcol $class$">',
					'col_start_last'          => '<td class="lastcol $class$">',
					'col_end'                 => "</td>\n",
					'line_end'                => "</tr>\n\n",
					'grp_line_start'          => '<tr class="group">'."\n",
					'grp_line_start_odd'      => '<tr class="odd">'."\n",
					'grp_line_start_last'     => '<tr class="lastline">'."\n",
					'grp_line_start_odd_last' => '<tr class="odd lastline">'."\n",
					'grp_col_start'           => '<td $class_attrib$ $colspan_attrib$>',
					'grp_col_start_first'     => '<td class="firstcol $class$" $colspan_attrib$>',
					'grp_col_start_last'      => '<td class="lastcol $class$" $colspan_attrib$>',
					'grp_col_end'             => "</td>\n",
					'grp_line_end'            => "</tr>\n\n",
   				'body_end'                => "</tbody>\n\n",
   				'total_line_start'        => '<tr class="total">'."\n",
					'total_col_start'         => '<td $class_attrib$>',
					'total_col_start_first'   => '<td class="firstcol $class$">',
					'total_col_start_last'    => '<td class="lastcol $class$">',
					'total_col_end'           => "</td>\n",
   				'total_line_end'          => "</tr>\n\n",
					'list_end'                => "</table></div>\n\n",
					'footer_start'            => '',
					'footer_text'             => '<div class="center"><ul class="pagination">'
							                       .'$prev$$first$$list_prev$$list$$list_next$$last$$next$'
						                          .'</ul></div><div class="center">$page_size$</div>'
            					                  /* T_('Page $scroll_list$ out of $total_pages$   $prev$ | $next$<br />'. */
            					                  /* '<strong>$total_pages$ Pages</strong> : $prev$ $list$ $next$' */
            					                  /* .' <br />$first$  $list_prev$  $list$  $list_next$  $last$ :: $prev$ | $next$') */,
					'footer_text_single'       => '<div class="center">$page_size$</div>',
					'footer_text_no_limit'     => '', // Text if theres no LIMIT and therefor only one page anyway
					'page_current_template'    => '<span>$page_num$</span>',
					'page_item_before'         => '<li>',
					'page_item_after'          => '</li>',
					'page_item_current_before' => '<li class="active">',
					'page_item_current_after'  => '</li>',
					'prev_text'                => T_('Previous'),
					'next_text'                => T_('Next'),
					'no_prev_text'             => '',
					'no_next_text'             => '',
					'list_prev_text'           => T_('...'),
					'list_next_text'           => T_('...'),
					'list_span'                => 11,
					'scroll_list_range'        => 5,
					'footer_end'               => "\n\n",
					'no_results_start'         => '<div class="panel-footer">'."\n",
					'no_results_end'           => '$no_results$</div>'."\n\n",
					'content_end'              => '</div>',
					'after'                    => '</div>',
					'sort_type'                => 'basic'
				);
				break;

			case 'blockspan_form':
				// Form settings for filter area:
				return array(
					'layout'         => 'blockspan',
					'formclass'      => 'form-inline',
					'formstart'      => '',
					'formend'        => '',
					'title_fmt'      => '$title$'."\n",
					'no_title_fmt'   => '',
					'fieldset_begin' => '<fieldset $fieldset_attribs$>'."\n"
												.'<legend $title_attribs$>$fieldset_title$</legend>'."\n",
					'fieldset_end'   => '</fieldset>'."\n",
					'fieldstart'     => '<div class="form-group form-group-sm" $ID$>'."\n",
					'fieldend'       => "</div>\n\n",
					'labelclass'     => 'control-label',
					'labelstart'     => '',
					'labelend'       => "\n",
					'labelempty'     => '<label></label>',
					'inputstart'     => '',
					'inputend'       => "\n",
					'infostart'      => '<div class="form-control-static">',
					'infoend'        => "</div>\n",
					'buttonsstart'   => '<div class="form-group form-group-sm">',
					'buttonsend'     => "</div>\n\n",
					'customstart'    => '<div class="custom_content">',
					'customend'      => "</div>\n",
					'note_format'    => ' <span class="help-inline">%s</span>',
					// Additional params depending on field type:
					// - checkbox
					'fieldstart_checkbox'    => '<div class="form-group form-group-sm checkbox" $ID$>'."\n",
					'fieldend_checkbox'      => "</div>\n\n",
					'inputclass_checkbox'    => '',
					'inputstart_checkbox'    => '',
					'inputend_checkbox'      => "\n",
					'checkbox_newline_start' => '',
					'checkbox_newline_end'   => "\n",
					// - radio
					'inputclass_radio'       => '',
					'radio_label_format'     => '$radio_option_label$',
					'radio_newline_start'    => '',
					'radio_newline_end'      => "\n",
					'radio_oneline_start'    => '',
					'radio_oneline_end'      => "\n",
				);

			case 'compact_form':
			case 'Form':
				// Default Form settings (Used for any form on front-office):
				return array(
					'layout'         => 'fieldset',
					'formclass'      => 'form-horizontal',
					'formstart'      => '',
					'formend'        => '',
					'title_fmt'      => '<span style="float:right">$global_icons$</span><h2>$title$</h2>'."\n",
					'no_title_fmt'   => '<span style="float:right">$global_icons$</span>'."\n",
					'fieldset_begin' => '<div class="fieldset_wrapper $class$" id="fieldset_wrapper_$id$"><fieldset $fieldset_attribs$><div class="panel panel-default">'."\n"
												.'<legend class="panel-heading" $title_attribs$>$fieldset_title$</legend><div class="panel-body $class$">'."\n",
					'fieldset_end'   => '</div></div></fieldset></div>'."\n",
					'fieldstart'     => '<div class="form-group" $ID$>'."\n",
					'fieldend'       => "</div>\n\n",
					'labelclass'     => 'control-label col-sm-3',
					'labelstart'     => '',
					'labelend'       => "\n",
					'labelempty'     => '<label class="control-label col-sm-3"></label>',
					'inputstart'     => '<div class="controls col-sm-9">',
					'inputend'       => "</div>\n",
					'infostart'      => '<div class="controls col-sm-9"><div class="form-control-static">',
					'infoend'        => "</div></div>\n",
					'buttonsstart'   => '<div class="form-group"><div class="control-buttons col-sm-offset-3 col-sm-9">',
					'buttonsend'     => "</div></div>\n\n",
					'customstart'    => '<div class="custom_content">',
					'customend'      => "</div>\n",
					'note_format'    => ' <span class="help-inline">%s</span>',
					// Additional params depending on field type:
					// - checkbox
					'inputclass_checkbox'    => '',
					'inputstart_checkbox'    => '<div class="controls col-sm-9"><div class="checkbox"><label>',
					'inputend_checkbox'      => "</label></div></div>\n",
					'checkbox_newline_start' => '<div class="checkbox">',
					'checkbox_newline_end'   => "</div>\n",
					// - radio
					'fieldstart_radio'       => '<div class="form-group radio-group" $ID$>'."\n",
					'fieldend_radio'         => "</div>\n\n",
					'inputclass_radio'       => '',
					'radio_label_format'     => '$radio_option_label$',
					'radio_newline_start'    => '<div class="radio"><label>',
					'radio_newline_end'      => "</label></div>\n",
					'radio_oneline_start'    => '<label class="radio-inline">',
					'radio_oneline_end'      => "</label>\n",
				);

			case 'fixed_form':
				// Form with fixed label width (Used for form on disp=user):
				return array(
					'layout'         => 'fieldset',
					'formclass'      => 'form-horizontal',
					'formstart'      => '',
					'formend'        => '',
					'title_fmt'      => '<span style="float:right">$global_icons$</span><h2>$title$</h2>'."\n",
					'no_title_fmt'   => '<span style="float:right">$global_icons$</span>'."\n",
					'fieldset_begin' => '<div class="fieldset_wrapper $class$" id="fieldset_wrapper_$id$"><fieldset $fieldset_attribs$><div class="panel panel-default">'."\n".'<legend class="panel-heading" $title_attribs$>$fieldset_title$</legend><div class="panel-body $class$">'."\n",
					'fieldset_end'   => '</div></div></fieldset></div>'."\n",
					'fieldstart'     => '<div class="form-group fixedform-group" $ID$>'."\n",
					'fieldend'       => "</div>\n\n",
					'labelclass'     => 'control-label fixedform-label',
					'labelstart'     => '',
					'labelend'       => "\n",
					'labelempty'     => '<label class="control-label fixedform-label"></label>',
					'inputstart'     => '<div class="controls fixedform-controls">',
					'inputend'       => "</div>\n",
					'infostart'      => '<div class="controls fixedform-controls"><div class="form-control-static">',
					'infoend'        => "</div></div>\n",
					'buttonsstart'   => '<div class="form-group"><div class="control-buttons fixedform-controls">',
					'buttonsend'     => "</div></div>\n\n",
					'customstart'    => '<div class="custom_content">',
					'customend'      => "</div>\n",
					'note_format'    => ' <span class="help-inline">%s</span>',
					// Additional params depending on field type:
					// - checkbox
					'inputclass_checkbox'    => '',
					'inputstart_checkbox'    => '<div class="controls fixedform-controls"><div class="checkbox"><label>',
					'inputend_checkbox'      => "</label></div></div>\n",
					'checkbox_newline_start' => '<div class="checkbox">',
					'checkbox_newline_end'   => "</div>\n",
					// - radio
					'fieldstart_radio'       => '<div class="form-group radio-group" $ID$>'."\n",
					'fieldend_radio'         => "</div>\n\n",
					'inputclass_radio'       => '',
					'radio_label_format'     => '$radio_option_label$',
					'radio_newline_start'    => '<div class="radio"><label>',
					'radio_newline_end'      => "</label></div>\n",
					'radio_oneline_start'    => '<label class="radio-inline">',
					'radio_oneline_end'      => "</label>\n",
				);

			case 'user_navigation':
				// The Prev/Next links of users (Used on disp=user to navigate between users):
				return array(
					'block_start'  => '<ul class="pager">',
					'prev_start'   => '<li class="previous">',
					'prev_end'     => '</li>',
					'prev_no_user' => '',
					'back_start'   => '<li>',
					'back_end'     => '</li>',
					'next_start'   => '<li class="next">',
					'next_end'     => '</li>',
					'next_no_user' => '',
					'block_end'    => '</ul>',
				);

			case 'button_classes':
				// Button classes (Used to initialize classes for action buttons like buttons to spam vote, or edit an intro post):
				return array(
					'button'       => 'btn btn-default btn-xs',
					'button_red'   => 'btn-danger',
					'button_green' => 'btn-success',
					'text'         => 'btn btn-default btn-xs',
					'group'        => 'btn-group',
				);

			case 'tooltip_plugin':
				// Plugin name for tooltips: 'bubbletip' or 'popover'
				// We should use 'popover' tooltip plugin for bootstrap skins
				// This tooltips appear on mouse over user logins or on plugin help icons
				return 'popover';
				break;

			case 'plugin_template':
				// Template for plugins:
				return array(
					// This template is used to build a plugin toolbar with action buttons above edit item/comment area:
					'toolbar_before'       => '<div class="btn-toolbar $toolbar_class$" role="toolbar">',
					'toolbar_after'        => '</div>',
					'toolbar_title_before' => '<div class="btn-toolbar-title">',
					'toolbar_title_after'  => '</div>',
					'toolbar_group_before' => '<div class="btn-group btn-group-xs" role="group">',
					'toolbar_group_after'  => '</div>',
					'toolbar_button_class' => 'btn btn-default',
				);

			case 'modal_window_js_func':
				// JavaScript function to initialize Modal windows, @see echo_user_ajaxwindow_js()
				return 'echo_modalwindow_js_bootstrap';
				break;

			default:
				// Delegate to parent class:
				return parent::get_template( $name );
		}
	}


	/**
	 * Check if we can display a widget container
	 *
	 * @param string Widget container key: 'header', 'page_top', 'menu', 'sidebar', 'sidebar2', 'footer'
	 * @param string Skin setting name
	 * @return boolean TRUE to display
	 */
	function is_visible_container( $container_key, $setting_name = 'access_login_containers' )
	{
		$access = $this->get_setting( $setting_name );

		return ( ! empty( $access ) && ! empty( $access[ $container_key ] ) );
	}


	/**
	 * Check if we can display a sidebar for the current layout
	 *
	 * @param boolean TRUE to check if at least one sidebar container is visible
	 * @return boolean TRUE to display a sidebar
	 */
	function is_visible_sidebar( $layout, $check_containers = false )
	{
		$layout = $this->get_setting( $layout );

		if( $layout != 'left_sidebar' && $layout != 'right_sidebar' )
		{ // Sidebar is not displayed for selected skin layout
			return false;
		}

		if( $check_containers )
		{ // Check if at least one sidebar container is visible
			return ( $this->is_visible_container( 'sidebar' ) ||  $this->is_visible_container( 'sidebar2' ) );
		}
		else
		{ // We should not check the visibility of the sidebar containers for this case
			return true;
		}
	}


	/**
	 * Get value for attbiute "class" of column block
	 * depending on skin setting "Layout"
	 *
	 * @return string
	 */
	function get_column_class( $settings )
	{
      $settings = $this->get_setting( $settings );

		switch( $settings )
		{
			case 'single_column':
				// Single Column Large
				return 'col-md-12';

			case 'single_column_normal':
				// Single Column
				return 'col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1';

			case 'single_column_narrow':
				// Single Column Narrow
				return 'col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2';

			case 'single_column_extra_narrow':
				// Single Column Extra Narrow
				return 'col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3';

			case 'left_sidebar':
				// Left Sidebar
				return 'col-xs-12 col-sm-12 col-md-8 pull-right';

			case 'right_sidebar':
				// Right Sidebar
			default:
				return 'col-xs-12 col-sm-12 col-md-8';
		}
	}

}

?>
