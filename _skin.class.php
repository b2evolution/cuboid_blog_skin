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
		return 'Cuboid Blog Skin';
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
	* Get supported collection kinds.
	*
	* This should be overloaded in skins.
	*
	* For each kind the answer could be:
	* - 'yes' : this skin does support that collection kind (the result will be was is expected)
	* - 'partial' : this skin is not a primary choice for this collection kind (but still produces an output that makes sense)
	* - 'maybe' : this skin has not been tested with this collection kind
	* - 'no' : this skin does not support that collection kind (the result would not be what is expected)
	* There may be more possible answers in the future...
	*/
	public function get_supported_coll_kinds()
	{
		$supported_kinds = array(
			'main'   => 'partial',
			'std'    => 'yes',		// Blog
			'photo'  => 'Yes',
			'forum'  => 'no',
			'manual' => 'maybe',
			'group'  => 'maybe',  // Tracker
			// Any kind that is not listed should be considered as "maybe" supported
		);
		return $supported_kinds;
	}


	/**
	* Judge if the file is the image we want to use
	*
	* @param string filepath: the path of a file
	* array arr_types: the file type we want to use
	* @return array
	*/
	function isImage( $filepath, $arr_types=array( ".gif", ".jpeg", ".png", ".bmp" ) )
	{
		if(file_exists($filepath)) {
			$info = getimagesize($filepath);
			$ext  = image_type_to_extension($info['2']);
			return in_array($ext,$arr_types);
		} else {
			return false;
		}
	}


	/**
	* Get the pictures of one local folder as an array
	*
	* @param string img_folder; the image folder;
	* string img_folder_url; folder url, we would like to show the img of this folder on the screen for user viewing;
	* int thumb_width: thumb image whdth shown on the skin setting page
	* int thumb_height: thumb image height shown on the skin setting page
	* @return array
	*/
	function get_arr_pics_from_folder( $img_folder, $img_folder_url, $thumb_width = 50, $thumb_height = 50 )
	{
		$arr_filenames = $filesnames =array();
		if(file_exists($img_folder))
		{
			$filesnames = scandir($img_folder);
		}
		$count = 0;
		foreach ( $filesnames as $name )
		{
			$count++;
			if ( $name != "." && $name != ".." && $name != "_evocache" && $this->isImage($img_folder.$name) ) //not the folder and other files
			{
				$arr_filenames[] = array( $img_folder_url.$name,
				"<a href='".$img_folder_url.$name."' target='blank'><img src='".$img_folder_url.$name."' width=".$thumb_width."px heigh=".$thumb_height."px /></a>" );
			}
			if ($count==30) break; // The max number of the images we want to show
		}
		$arr_filenames[] = array("none",T_("Transparent"));
		return $arr_filenames;
	}


	/**
	* Get definitions for editable params
	*
	* @see Plugin::GetDefaultSettings()
	* @param local params like 'for_editing' => true
	*/
	function get_param_definitions( $params )
	{
		global $Blog;
		// Load to use function get_available_thumb_sizes()
		load_funcs( 'files/model/_image.funcs.php' );
		// System provide bg images
		$bodybg_cat = 'assets/images/bodybg/'; // Background images folder relative to this skin folder
		$arr_bodybg = $this -> get_arr_pics_from_folder( $this->get_path().$bodybg_cat, $this->get_url().$bodybg_cat, 60, 60 );
		// User Custom bg images
		$custom_bodybg_cat = "bodybg/"; // Background images folder which created by users themselves, and it's relative to collection media dir
		$arr_custom_bodybg = $this->get_arr_pics_from_folder( $Blog->get_media_dir().$custom_bodybg_cat, $Blog->get_media_url().$custom_bodybg_cat, 65 ,65);

		$r = array_merge( array(
            'general_settings_start' => array(
               'layout' => 'begin_fieldset',
               'label'  => T_('General Settings (All disps)')
            ),
				// Layout
				'layout' => array(
					'label'        => T_('Front Page Layout'),
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
					'note'     => T_('Select your favorite <strong>Background Style</strong> for your site.'),
					'type'     => 'select',
					'options'  => array(
						'color'         => T_('Site Background Color'),
						'images'        => T_('Background Image Pattern'),
						'custom_images' => T_('Custom Background Image'),
					),
					'defaultvalue' => 'images',
				),
				'site_background_color' => array(
					'label'        => T_('Site Background Color'),
					'note'         => T_('Default value is #F5F7F9'),
					'defaultvalue' => '#F5F7F9',
					'type'         => 'color',
				),
				'bg_image' => array(
					'label'        => T_('Background Image Pattern'),
					'note'         => T_('Choose your favorite background image pattern'),
					'type'         => 'radio',
					'options'      => $arr_bodybg,
					'defaultvalue' => reset($arr_bodybg[0]),
				),
				'bg_image_custom' => array(
					'label'        => T_('User Custom Background Image'),
					'note'         => T_('（Please create a folder named <b><i>'.str_replace("/","",$custom_bodybg_cat).'</i></b> in your collection media folder and put the images into it. Now <a href="admin.php?ctrl=files" target="_blank"><i>Create folder or Upload images</i></a>）'),
					'type'         => 'radio',
					'options'      => $arr_custom_bodybg,
					'defaultvalue' => reset($arr_custom_bodybg[0]),
				),
				'bg_image_custom_attach' => array(
					'label'    => T_('Custom Background Attachment'),
					'note'     => T_('Select the Background Attachment for Custom Background Image.'),
					'type'     => 'select',
					'options'  => array(
						'initial'    => T_('Initial'),
						'fixed'      => T_('Fixed'),
					),
					'defaultvalue' => 'initial',
				),
				'bg_image_custom_size' => array(
					'label'    		=> T_('Custom Background Size'),
					'note'     		=> T_('Select the background size for Custom Background Image.'),
					'type'     		=> 'select',
					'defaultvalue' 	=> 'auto',
					'options'  		=> array(
						'auto'    => T_('Auto'),
						'contain' => T_('Contain'),
						'cover'   => T_('Cover'),
					),
				),

				// Back To Top
				'bt_top' => array(
					'label'        	=> T_('Display Button Back To Top'),
					'note'         	=> T_('Check to enable button back to top.'),
					'defaultvalue' 	=> 1,
					'type'         	=> 'checkbox',
				),
				'bg_wrap_content' => array(
					'label'			=> T_( 'Content Background Wrapper' ),
					'note'			=> T_( 'Change Background wrapper for Posts, Widget, Search Results and other ' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#FFFFFF',

				),
            'general_settings_end' => array(
               'layout' => 'end_fieldset',
            ),

			/* Page Setting
			 * ========================================================================== */
			'page_setting_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Page Settings (All disps)' ),
			),
				'page_content_color' => array(
				   'label'			=> T_('Page Content Color'),
				   'note'         	=> T_('Default value is #6F6F6F'),
				   'defaultvalue' 	=> '',
				   'type'         	=> 'color',
				),
				'page_heading_color' => array(
					'label'			=> T_( 'Page Heading Color' ),
					'note'			=> T_( 'Default value is #555555' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#555555',
				),
				'page_font_size' => array(
					'label'			=> T_( 'Font Size Page' ),
					'note'			=> T_( 'px. Change font size for content all page.' ),
					'type'			=> 'integer',
					'defaultvalue'	=> '',
					'size'			=> 5,
					'allow_empty'	=> true,
				),
				'page_info_color' => array(
				   'label'        	=> T_('Page Info Text Color'),
				   'note'        	=> T_('Default value is #777777'),
				   'defaultvalue' 	=> '#777777',
				   'type'         	=> 'color',
				),
				'page_info_link' => array(
				   'label'        	=> T_('Page Info Link Color'),
				   'note'         	=> T_('Default value is #A9A9A9'),
				   'defaultvalue'	=> '#A9A9A9',
				   'type'         	=> 'color',
				),
			'page_setting_end' => array(
				'layout'	=> 'end_fieldset',
			),

            /**
             * ============================================================================
             * Header Settings
             * ============================================================================
             */
			'header_settings_start' => array(
				'layout' => 'begin_fieldset',
				'label'  => T_('Header settings (All disps)')
			),
				'head_center_mode' => array(
					'label'        => T_('Max Width Header Center Mode'),
					'note'         => T_('px - Set Max Width for Header Center Mode. Default ( 992px ), example: 1170px'),
					'defaultvalue' => '992',
					'size'         => '5',
					'type'         => 'integer',
					'allow_empty'  => true,
				),
				'header_bg_color' => array(
					'label'        => T_('Header Background Color'),
					'note'         => T_('Default value is #262626'),
					'defaultvalue' => '#262626',
					'type'         => 'color',
				),
				'nav_color_link' => array(
					'label'        => T_('Navigation Link Color'),
					'note'         => T_('Default value is #FFFFFF'),
					'defaultvalue' => '#FFFFFF',
					'type'         => 'color',
				),
				'nav_color_hovlink' => array(
					'label'        => T_('Navigation Hover Link Color'),
					'note'         => T_('Default value is #FFFFFF'),
					'defaultvalue' => '#FFFFFF',
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
               'label'  => T_('Posts Settings (disp=posts)')
            ),
               'posts_layout' => array(
                  'label'        => T_('Posts Layout'),
                  'note'         => T_('Select "Single Column Large" Layout for Post 3 Column'),
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
                  'label'    => T_('Posts Columns'),
                  'note'     => T_('( Number of posts columns in posts disp. )'),
                  'type'     => 'select',
                  'options'  => array(
                    	'one' 	=> T_('1 Column'),
                    	'two' 	=> T_('2 Columns'),
                    	'three' => T_('3 Columns'),
                  ),
                  'defaultvalue' => 'one',
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
               'posts_title_color' => array(
                  'label'        => T_('Posts Title Color'),
                  'note'         => T_('Default value is #555555'),
                  'defaultvalue' => '#555555',
                  'type'         => 'color',
               ),
            'posts_settings_end' => array(
               'layout' => 'end_fieldset',
            ),
            // End Single Disp


            /**
             * ============================================================================
             * Tags Layout
             * ============================================================================
             */
            'tags_settings_start' => array(
               'layout' => 'begin_fieldset',
               'label'  => T_('Tags Layout Settings (All disps)')
            ),
               'tags_color' => array(
                  'label'        => T_('Tags Text Color'),
                  'note'         => T_('Default value is #FFFFFF'),
                  'defaultvalue' => '#FFFFFF',
                  'type'         => 'color',
               ),
               'tags_bg' => array(
                  'label'        => T_('Tags Background Color'),
                  'note'         => T_('Default value is #333333'),
                  'defaultvalue' => '#333333',
                  'type'         => 'color',
               ),
               'tags_icon' => array(
                  'label'        => T_('Show Icon Tags'),
                  'note'         => T_('Check to show icon tags.'),
                  'defaultvalue' => 1,
                  'type'         => 'checkbox',
               ),
            'tags_settings_end' => array(
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
               'label'  => T_('Single and Page Disp Settings (disp=single and disp=page)')
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
             * Sidebar Options
             * ============================================================================
             */
            'sidebar_settings_start' => array(
               'layout' => 'begin_fieldset',
               'label'  => T_('Sidebar Settings (All disps)')
            ),
               'side_widget_title' => array(
                  'label'        => T_('Widget Title Color'),
                  'note'         => T_('Default value is #555555'),
                  'defaultvalue' => '#555555',
                  'type'         => 'color',
               ),
               'side_widget_content' => array(
                  'label'        => T_('Widget Content Color'),
                  'note'         => T_('Default value is #6F6F6F'),
                  'defaultvalue' => '#6F6F6F',
                  'type'         => 'color',
               ),
               'side_widget_link' => array(
                  'label'        => T_('Widget Link Color'),
                  'note'         => T_('Default value is <strong>Empty</strong>. The empty value link color will be follow Color Schemes.'),
                  'defaultvalue' => '',
                  'type'         => 'color',
                  'allow_empty'  => true,
               ),
               'side_border' => array(
                  'label'        => T_('Widget Border Color'),
                  'note'         => T_('Default value is #EEEEEE'),
                  'defaultvalue' => '#EEEEEE',
                  'type'         => 'color',
               ),
            'sidebar_settings_end' => array(
               'layout' => 'end_fieldset',
            ),
            // End Single Disp

			/* Special Widget Settings (All Disps)
			 * ========================================================================== */
			'uil_widget_settings_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Special Widget Settings (All Disps)' ),
			),
				'uil_widget_readmore' => array(
					'label'			=> T_( 'List-type Widgets "Read more" button' ),
					'note'			=> T_( 'Check to display the "Read more" button after content on all list-type widgets (Excerpt and Teaser)' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
			'uil_widget_settings_end' => array(
				'layout'	=> 'end_fieldset',
			),

            /**
             * ============================================================================
             * Footer Settings
             * ============================================================================
             */
            'footer_settings_start' => array(
               'layout' => 'begin_fieldset',
               'label'  => T_('Footer Settings (All disps)')
            ),
               'footer_widget' => array(
                  'label'        => T_('Display Footer Widget'),
                  'note'         => T_('Check to enable footer widget.'),
                  'defaultvalue' => 1,
                  'type'         => 'checkbox',
               ),
               'footer_bg_color' => array(
                  'label'        => T_('Footer Main Background Color'),
                  'note'         => T_('Default value is #262626'),
                  'defaultvalue' => '#262626',
                  'type'         => 'color',
               ),
               'footer_widget_title' => array(
                  'label'        => T_('Footer Widget Title Color'),
                  'note'         => T_('Default value is #FFFFFF'),
                  'defaultvalue' => '#FFFFFF',
                  'type'         => 'color',
               ),
               'footer_widget_content' => array(
                  'label'        => T_('Footer Widget Content Color'),
                  'note'         => T_('Default value is #FFFFFF'),
                  'defaultvalue' => '#FFFFFF',
                  'type'         => 'color',
               ),
               'footer_widget_link' => array(
                  'label'        => T_('Footer Widget Link Color'),
                  'note'         => T_('Default value is <strong>Empty</strong>.'),
                  'defaultvalue' => '#FFFFFF',
                  'type'         => 'color',
               ),
               'footer_border_color' => array(
                  'label'        => T_('Footer Border Color'),
                  'note'         => T_('Default value is #3C3C3C'),
                  'defaultvalue' => '#3C3C3C',
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
               'footer_sm_color' => array(
                  'label'        => T_('Social Media Icon Color'),
                  'note'         => T_('Default value is #FFFFFF'),
                  'defaultvalue' => '#FFFFFF',
                  'type'         => 'color',
               ),
               'footer_sm_bgcolor' => array(
                  'label'        => T_('Social Media Background Color'),
                  'note'         => T_('Default value is #212121'),
                  'defaultvalue' => '#212121',
                  'type'         => 'color',
               ),
               'footer_copyright' => array(
                  'label'        => T_('Display Footer Copyright'),
                  'note'         => T_('Check to display footer copyright.'),
                  'defaultvalue' => 1,
                  'type'         => 'checkbox',
               ),
               'footer_copyright_content' => array(
                  'label'        => T_('Copyright Content Color'),
                  'note'         => T_('Default value is #FFFFFF'),
                  'defaultvalue' => '#FFFFFF',
                  'type'         => 'color',
               ),
               'footer_copyright_link' => array(
                  'label'        => T_('Copyright Link Color'),
                  'note'         => T_('Default value is <strong>Empty</strong>. The color follow Color Schemes.'),
                  'defaultvalue' => '',
                  'type'         => 'color',
                  'allow_empty'  => true,
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
               'label'    => T_( 'Media Posts Settings (disp=mediaidx)' )
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
             * Single Disp
             * ============================================================================
             */
            'user_settings_start' => array(
               'layout' => 'begin_fieldset',
               'label'  => T_('User Disp Layout (All disps)')
            ),
               // Single Layout
               'user_layout' => array(
                  'label'        => T_('Page Layout'),
                  'note'         => '',
                  'defaultvalue' => 'single_column_normal',
                  'type'         => 'select',
                  'options'      => array(
                     'single_column_normal'  => T_('Single Column'),
                     'left_sidebar'          => T_('Left Sidebar'),
                     'right_sidebar'         => T_('Right Sidebar'),
                  ),
               ),
            'user_settings_end' => array(
               'layout' => 'end_fieldset',
            ),
            // End Single Disp

            /**
             * ============================================================================
             * Colorbox Image Zoom
             * ============================================================================
             */
				'section_colorbox_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Colorbox Image Zoom (All disps)')
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
					'label'  => T_('Username options (All disp)')
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
					'label'  => T_('When access is denied or requires login... (disp=access_denied and disp=access_requires_login)')
				),
					'access_login_containers' => array(
						'label'   => T_('Display on login screen'),
						'note'    => '',
						'type'    => 'checklist',
						'options' => array(
							array( 'header',   sprintf( T_('"%s" container'), NT_('Header') ),    1 ),
							array( 'sidebar',  sprintf( T_('"%s" container'), NT_('Sidebar') ),   0 ),
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
			require_js( 'assets/js/masonry.pkgd.min.js', 'relative' );
			require_js( 'assets/js/imagesloaded.pkgd.min.js', 'relative');
		}

		if( $disp == 'posts' ) {
			add_js_headline("
			jQuery( document ).ready( function($) {
				$('.main_item_posts').imagesLoaded().done( function( instance ) {
					$('.main_item_posts').masonry({
						// options
						itemSelector: '.item_posts',
						percentPosition: true,
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
						percentPosition: true,
					});
				});
			});
			");
		}

		require_js( 'assets/js/script.js', 'relative' );
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
			.widget_plugin_evo_Calr .bCalendarTable tfoot a:hover, #main-content .evo_post .small.text-muted a:hover span, #main-content .evo_featured_post .small.text-muted a:hover span
			{ color: '.$color.'; }

			/* Header */
			.navbar-collapse .nav.nav-tabs li a::after, .navbar-collapse ul li.active a
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
			.btn-success, .pagination li.active a:hover, .pagination li.active span:hover, .pagination li.active a:active, .pagination li.active span:active, .pagination li.active a:focus, .pagination li.active span:focus, .pagination li.active a, .pagination li.active span, .pagination li a:hover, .pagination li span:hover, .pagination li a:active, .pagination li span:active, .pagination li a:focus, .pagination li span:focus,
			.disp_profile #main-content .profile_tabs li.active a, .disp_avatar #main-content .profile_tabs li.active a, .disp_pwdchange #main-content .profile_tabs li.active a, .disp_userprefs #main-content .profile_tabs li.active a, .disp_subs #main-content .profile_tabs li.active a,
			.disp_profile #main-content .profile_tabs a:hover, .disp_avatar #main-content .profile_tabs a:hover, .disp_pwdchange #main-content .profile_tabs a:hover, .disp_userprefs #main-content .profile_tabs a:hover, .disp_subs #main-content .profile_tabs a:hover, .disp_profile #main-content .profile_tabs a:active, .disp_avatar #main-content .profile_tabs a:active, .disp_pwdchange #main-content .profile_tabs a:active, .disp_userprefs #main-content .profile_tabs a:active, .disp_subs #main-content .profile_tabs a:active, .disp_profile #main-content .profile_tabs a:focus, .disp_avatar #main-content .profile_tabs a:focus, .disp_pwdchange #main-content .profile_tabs a:focus, .disp_userprefs #main-content .profile_tabs a:focus, .disp_subs #main-content .profile_tabs a:focus,
			.disp_profile #main-content .evo_form .panel-heading, .disp_avatar #main-content .evo_form .panel-heading, .disp_pwdchange #main-content .evo_form .panel-heading, .disp_userprefs #main-content .evo_form .panel-heading, .disp_subs #main-content .evo_form .panel-heading,
			.evo_panel__login .btn.btn-success, .evo_panel__lostpass .btn.btn-success, .evo_panel__register .btn.btn-success, .evo_panel__activation .btn.btn-success,
			.disp_edit #item_checkchanges .panel .panel-heading
			{ background-color: '.$color.'; }

			.disp_front #main-content .widget_core_poll .btn-default.active, .disp_front #main-content .widget_core_poll .btn-default.focus, .disp_front #main-content .widget_core_poll .btn-default:active, .disp_front #main-content .widget_core_poll .btn-default:focus, .disp_front #main-content .widget_core_poll .btn-default:hover, .disp_front #main-content .widget_core_poll .open > .dropdown-toggle.btn-default,
			.disp_search #main-content .search_result .search_result_score.dimmed,
			.disp_threads #main-content .SaveButton.btn-primary, .disp_messages #main-content .SaveButton.btn-primary, .disp_contacts #main-content .SaveButton.btn-primary,
			.disp_contacts .form_send_contacts .btn-default:hover, .disp_contacts .form_send_contacts .btn-default:active, .disp_contacts .form_send_contacts .btn-default:focus,
			.filters .btn-info,
			.disp_threads #main-content .results .action_icon.btn-primary, .disp_messages #main-content .results .action_icon.btn-primary, .disp_contacts #main-content .results .action_icon.btn-primary,
			.disp_threads #main-content .evo_form__thread input:focus, .disp_messages #main-content .evo_form__thread input:focus, .disp_contacts #main-content .evo_form__thread input:focus, .disp_threads #main-content .evo_form__thread textarea:focus, .disp_messages #main-content .evo_form__thread textarea:focus, .disp_contacts #main-content .evo_form__thread textarea:focus,
			.btn-success, .pagination li.active a:hover, .pagination li.active span:hover, .pagination li.active a:active, .pagination li.active span:active, .pagination li.active a:focus, .pagination li.active span:focus, .disp_msgform #main-content .form_text_input:hover, .disp_msgform #main-content .form_textarea_input:hover, .disp_msgform #main-content .form_text_input:active, .disp_msgform #main-content .form_textarea_input:active, .disp_msgform #main-content .form_text_input:focus, .disp_msgform #main-content .form_textarea_input:focus,

			.disp_profile #main-content .evo_form .panel-body .form-control:hover, .disp_avatar #main-content .evo_form .panel-body .form-control:hover, .disp_pwdchange #main-content .evo_form .panel-body .form-control:hover, .disp_userprefs #main-content .evo_form .panel-body .form-control:hover, .disp_subs #main-content .evo_form .panel-body .form-control:hover, .disp_profile #main-content .evo_form .panel-body .form-control:active, .disp_avatar #main-content .evo_form .panel-body .form-control:active, .disp_pwdchange #main-content .evo_form .panel-body .form-control:active, .disp_userprefs #main-content .evo_form .panel-body .form-control:active, .disp_subs #main-content .evo_form .panel-body .form-control:active, .disp_profile #main-content .evo_form .panel-body .form-control:focus, .disp_avatar #main-content .evo_form .panel-body .form-control:focus, .disp_pwdchange #main-content .evo_form .panel-body .form-control:focus, .disp_userprefs #main-content .evo_form .panel-body .form-control:focus, .disp_subs #main-content .evo_form .panel-body .form-control:focus,

			#login_form input:focus:invalid:focus, #login_form select:focus:invalid:focus, #login_form textarea:focus:invalid:focus, .evo_panel__login .btn.btn-success, .evo_panel__lostpass .btn.btn-success, .evo_panel__register .btn.btn-success, .evo_panel__activation .btn.btn-success, .form-control:focus,

			.disp_edit #item_checkchanges .panel
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
			.evo_post_comment_notification .btn:hover, .evo_post_comment_notification .btn:active, .evo_post_comment_notification .btn:focus,
			.disp_threads #main-content .submit, .disp_messages #main-content .submit, .disp_contacts #main-content .submit, .disp_msgform #main-content .submit,
			.disp_user #main-content .pager a:hover, .disp_user #main-content .pager a:focus, .disp_user #main-content .pager a:active
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
			.evo_post_comment_notification .btn:hover, .evo_post_comment_notification .btn:active, .evo_post_comment_notification .btn:focus,
			.disp_threads #main-content .submit, .disp_messages #main-content .submit, .disp_contacts #main-content .submit, .disp_msgform #main-content .submit
			{ border-color: '.$color.'; }
			';
		}


		// Site Background
		if ( $this->get_setting( 'background_type' ) == 'color' ) {
			$color = $this->get_setting( 'site_background_color' );
			$custom_css .= 'body {background-color: '.$color.';}';
		}

		$bg_image = $this->get_setting( 'bg_image' );
		if ( $this->get_setting( 'background_type' ) == 'images' && $bg_image ) {
			if($bg_image == "none") {
				$custom_css .= "body { background: transparent; }";
			} else {
				$custom_css .= "body { background-image: url('".$bg_image."');}";
			}
		}

		// User custom bg images setting
		$bg_image_custom = $this->get_setting( 'bg_image_custom' );
		if ( $this->get_setting( 'background_type' ) == 'custom_images' && $bg_image_custom ) {
			if($bg_image_custom == "none")
			{
				$custom_css .= "body { background: transparent; }";
			} else {
				$custom_css .= "body { background-image: url('".$bg_image_custom."');}";
			}
		}

		$bg_image_custom_attach = $this->get_setting( 'bg_image_custom_attach' );
		if ( $this->get_setting( 'background_type' ) == 'custom_images' && $bg_image_custom_attach ) {
			if ( $bg_image_custom_attach == 'initial' ) {
				$custom_css .= "body { background-attachment: initial; }";
			} else {
				$custom_css .= "body { background-attachment: fixed; }";
			}
		}

		$bg_image_custom_size = $this->get_setting( 'bg_image_custom_size' );
		if ( $this->get_setting( 'background_type' ) == 'custom_images' && $bg_image_custom_size ) {
			if ( $bg_image_custom_size == 'auto' ) {
				$custom_css .= "body { background-size: auto; }";
			} else if ( $bg_image_custom_size == 'contain' ){
				$custom_css .= "body { background-size: contain; }";
			} else {
				$custom_css .= "body { background-size: cover; }";
			}
		}

		if ( $bg = $this->get_setting( 'bg_wrap_content' ) ) {
			$custom_css .= '#main-content .evo_post, #main-content .evo_featured_post, .disp_posts #main-content .evo_featured_post, div.error_404, .msg_nothing, #main-content .title_head_post, #main-sidebar .evo_widget, #content .evo_widget, .disp_comments #main-content .evo_comment, .disp_user #main-content .profile_content, .disp_threads #main-content, .disp_messages #main-content, .disp_contacts #main-content, .disp_msgform #main-content, .disp_threads #main-content .title_head_post, .disp_messages #main-content .title_head_post, .disp_contacts #main-content .title_head_post, .disp_msgform #main-content .title_head_post, .disp_help #main-content, .disp_users .results .filters, .disp_users .results .table_scroll, .disp_access_requires_login #main-content, .disp_lostpassword #main-content, .disp_login #main-content, .disp_register #main-content, .disp_search #main-content, .disp_search #main-content .title_head_post, .disp_search #main-content .search_result, .disp_404 #main-content, .disp_front #main-content .evo_widget, .disp_sitemap #main-content h3, .disp_messages #main-content, .disp_messages #main-content .title_head_post, .disp_profile #main-content .evo_form .panel-body, .disp_avatar #main-content .evo_form .panel-body, .disp_pwdchange #main-content .evo_form .panel-body, .disp_userprefs #main-content .evo_form .panel-body, .disp_subs #main-content .evo_form .panel-body, .disp_mediaidx #main-content .evo_image_index .note
			{ background-color: '.$bg.'; }';
			$custom_css .= '.disp_mediaidx #main-content .evo_image_index .item{ border-color: '.$bg.' }';
		}

		/**
		 * ============================================================================
		 * Page Setting
		 * ============================================================================
		 */
		if( $font = $this->get_setting('page_font_size') ) {
			$custom_css .= 'body{ font-size: '.$font.'px }';
		}

		if ( $color = $this->get_setting( 'page_info_color' ) ) {
			$custom_css .= '.disp_posts #main-content .evo_post .small.text-muted, .disp_posts #main-content .evo_featured_post .small.text-muted, .disp_page #main-content .evo_post .small.text-muted, .disp_page #main-content .evo_featured_post .small.text-muted, .disp_single #main-content .evo_post .small.text-muted, .disp_single #main-content .evo_featured_post .small.text-muted { color: '.$color.' }';
		}

		if ( $color =$this->get_setting( 'page_info_link' ) ) {
			$custom_css .= '.disp_posts #main-content .evo_post .small.text-muted span, .disp_posts #main-content .evo_featured_post .small.text-muted span, #main-content .evo_post .small.text-muted a, .disp_posts #main-content .evo_featured_post .small.text-muted a, .disp_page #main-content .evo_post .small.text-muted span, .disp_page #main-content .evo_featured_post .small.text-muted span, #main-content .evo_post .small.text-muted a, .disp_page #main-content .evo_featured_post .small.text-muted a, .disp_single #main-content .evo_post .small.text-muted span, .disp_single #main-content .evo_featured_post .small.text-muted span, #main-content .evo_post .small.text-muted a, .disp_single #main-content .evo_featured_post .small.text-muted a { color: '.$color.' }';
		}

		if ( $color = $this->get_setting( 'page_content_color' ) ) {
			$custom_css .= 'html, body, .disp_single #feedbacks, .disp_page #feedbacks, #content .evo_widget, .disp_posts #main-content .evo_post__full_text, .disp_posts #main-content .evo_post__excerpt_text, .disp_page #main-content .evo_post__full_text, .disp_page #main-content .evo_post__excerpt_text, .disp_single #main-content .evo_post__full_text, .disp_single #main-content .evo_post__excerpt_text, .disp_comments #main-content .evo_comment .evo_comment_text, .disp_search #main-content .msg_nothing, .disp_search #main-content .search_result .search_content_wrap .result_content
			{ color: '.$color.' !important}';
		}

		if( $color = $this->get_setting( 'page_heading_color' ) ) {
			$custom_css .= 'h1, h2, h3, h4, h5, h6,
			.disp_front #main-content .evo_widget .title_widget, .disp_mediaidx #main-content .evo_image_index .note, .disp_404 .error_404 .fa-warning, div.error_404 .fa-warning, .disp_search #main-content .search_result .search_content_wrap .search_title, .disp_search #main-content .search_result .search_content_wrap .search_title a
			{ color: '.$color.' }';
			$custom_css .= '.disp_front #main-content .evo_widget .title_widget::after { background-color: '.$color.' }';
		}



		/**
		* ============================================================================
		* Header Settings Output
		* ============================================================================
		*/
		if ( $width = $this->get_setting( 'head_center_mode' ) ) {
			$custom_css .= '
			@media only screen and ( max-width: '.$width.'px )
			and ( min-width: 768px ) {
				#main-header .col-md-4,
				#main-header .col-md-8 {
					width: 100%;
					text-align: center;
					margin: 0 auto;
				}

				#main-header {
					padding-bottom: 2rem;
				}

				#main-header .col-md-4{
					margin-bottom: 15px;
				}

				.navbar-collapse .nav.nav-tabs {
					display: inline-block;
					text-align: center;
					margin: 0 auto;
					float: none;
				}
			}
			';
		}

		if ( $color = $this->get_setting( 'header_bg_color' ) ) {
			$custom_css .= 'body #main-header { background-color: '.$color.' }';
		}

		if ( $color = $this->get_setting( 'nav_color_link' ) ) {
			$custom_css .= '.navbar-collapse .nav.nav-tabs li a{ color: '.$color.' }';
		}

		if ( $color = $this->get_setting( 'nav_color_hovlink' ) ) {
			$custom_css .= '.navbar-collapse .nav.nav-tabs li a:hover { color: '.$color.' }';
		}

		if ( $color = $this->get_setting( 'head_tagline_bg_color' ) ) {
			$custom_css .= 'body #head_tagline { background-color: '.$color." }\n";
		}

		/**
		* ============================================================================
		* Posts
		* ============================================================================
		*/
		if ( $color = $this->get_setting( 'posts_title_color' ) ) {
			$custom_css .= '
			.disp_posts #main-content .evo_post_title h1 a, .disp_posts #main-content .evo_post_title h2 a, .disp_posts #main-content .evo_post_title h3 a,
			.disp_posts #main-content .evo_post .evo_post__full h1, .disp_posts #main-content .evo_featured_post .evo_post__full h1, .disp_posts #main-content .evo_post .evo_post__excerpt h1, .disp_posts #main-content .evo_featured_post .evo_post__excerpt h1, .disp_posts #main-content .evo_post .evo_post__full h2, .disp_posts #main-content .evo_featured_post .evo_post__full h2, .disp_posts #main-content .evo_post .evo_post__excerpt h2, .disp_posts #main-content .evo_featured_post .evo_post__excerpt h2, .disp_posts #main-content .evo_post .evo_post__full h3, .disp_posts #main-content .evo_featured_post .evo_post__full h3, .disp_posts #main-content .evo_post .evo_post__excerpt h3, .disp_posts #main-content .evo_featured_post .evo_post__excerpt h3, .disp_posts #main-content .evo_post .evo_post__full h4, .disp_posts #main-content .evo_featured_post .evo_post__full h4, .disp_posts #main-content .evo_post .evo_post__excerpt h4, .disp_posts #main-content .evo_featured_post .evo_post__excerpt h4, .disp_posts #main-content .evo_post .evo_post__full h5, .disp_posts #main-content .evo_featured_post .evo_post__full h5, .disp_posts #main-content .evo_post .evo_post__excerpt h5, .disp_posts #main-content .evo_featured_post .evo_post__excerpt h5, .disp_posts #main-content .evo_post .evo_post__full h6, .disp_posts #main-content .evo_featured_post .evo_post__full h6, .disp_posts #main-content .evo_post .evo_post__excerpt h6, .disp_posts #main-content .evo_featured_post .evo_post__excerpt h6,
			.disp_posts #main-content .post_tags h3
			{ color: '.$color.' }
			';
		}

		// if ( $color = $this->get_setting( 'posts_info_color' ) ) {
		// 	$custom_css .= '.disp_posts #main-content .evo_post .small.text-muted, .disp_posts #main-content .evo_featured_post .small.text-muted { color: '.$color.' }';
		// }
		//
		// if ( $color =$this->get_setting( 'posts_info_link' ) ) {
		// 	$custom_css .= '.disp_posts #main-content .evo_post .small.text-muted span, .disp_posts #main-content .evo_featured_post .small.text-muted span, #main-content .evo_post .small.text-muted a, .disp_posts #main-content .evo_featured_post .small.text-muted a { color: '.$color.' }';
		// }
		//
		// if ( $color = $this->get_setting( 'posts_content_color' ) ) {
		// 	$custom_css .= '.disp_posts #main-content .evo_post__full_text, .disp_posts #main-content .evo_post__excerpt_text { color: '.$color.' }';
		// }

		/**
		* ============================================================================
		* Tags
		* ============================================================================
		*/
		if ( $color = $this->get_setting( 'tags_color' ) ) {
			$custom_css .= '#main-content .post_tags a, .tag_cloud a, #main-content .post_tags a::before { color: '.$color.' }';
		}
		if ( $bg = $this->get_setting( 'tags_bg' ) ) {
			$custom_css .= '#main-content .post_tags a, .tag_cloud a { background-color: '.$bg.' }';
		}
		if ( $this->get_setting( 'tags_icon' ) == 0 ) {
			$custom_css .= '#main-content .post_tags a::before, .tag_cloud a::before { content: \'\'; display: none }';
		}

		/**
		* ============================================================================
		* Sidebar Widget Options
		* ============================================================================
		*/
		// if ( $bg = $this->get_setting( 'side_bg_wrap' ) ) {
		// 	$custom_css .= '#main-sidebar .evo_widget { background-color: '. $bg .' }';
		// }
		if ( $color = $this->get_setting( 'side_widget_title' ) ) {
			$custom_css .= '#main-sidebar .evo_widget .panel-title { color: '.$color.' }';
			$custom_css .= '#main-sidebar .evo_widget .panel-title::after { background-color: '.$color.' }';
		}
		if ( $color = $this->get_setting( 'side_widget_content' ) ) {
			$custom_css .= '
			#main-sidebar .evo_widget,
			#main-sidebar .widget_core_user_login .user_group,
			#main-sidebar .widget_core_user_login .user_level
			{ color: '.$color.' }';
		}
		if ( $border = $this->get_setting( 'side_border' ) ) {
			$custom_css .= '
			#content .evo_widget ul li,
			#content .evo_widget ul > ul > li:last-child,
			.widget_core_linkblog ul ul, .widget_core_content_hierarchy ul ul,
			.widget_core_coll_xml_feeds .notes
			{ border-color: '.$border.' }';
		}
		if( $color = $this->get_setting( 'side_widget_link' ) ) {
			$custom_css .= '#main-sidebar .evo_widget a { color: '.$color.' }';
		}

		/**
		 * ============================================================================
		 * UIL Widget Settings
		 * ============================================================================
		 */
		if ( $this->get_setting( 'uil_widget_readmore' ) == 0 ) {
			$custom_css .= 'div.widget_core_coll_item_list.evo_noexcerpt.evo_withteaser div.item_content > a, div.widget_core_coll_featured_posts.evo_noexcerpt.evo_withteaser div.item_content > a, div.widget_core_coll_post_list.evo_noexcerpt.evo_withteaser div.item_content > a, div.widget_core_coll_page_list.evo_noexcerpt.evo_withteaser div.item_content > a, div.widget_core_coll_related_post_list.evo_noexcerpt.evo_withteaser div.item_content > a, div.widget_core_coll_item_list.evo_withexcerpt.evo_withteaser div.item_content > a, div.widget_core_coll_featured_posts.evo_withexcerpt.evo_withteaser div.item_content > a, div.widget_core_coll_post_list.evo_withexcerpt.evo_withteaser div.item_content > a, div.widget_core_coll_page_list.evo_withexcerpt.evo_withteaser div.item_content > a, div.widget_core_coll_related_post_list.evo_withexcerpt.evo_withteaser div.item_content > a, div.widget_core_coll_item_list.evo_withexcerpt.evo_noteaser div.item_content > a, div.widget_core_coll_featured_posts.evo_withexcerpt.evo_noteaser div.item_content > a, div.widget_core_coll_post_list.evo_withexcerpt.evo_noteaser div.item_content > a, div.widget_core_coll_page_list.evo_withexcerpt.evo_noteaser div.item_content > a, div.widget_core_coll_related_post_list.evo_withexcerpt.evo_noteaser div.item_content > a, div.widget_core_coll_item_list.evo_noexcerpt.evo_withteaser div.item_excerpt > a, div.widget_core_coll_featured_posts.evo_noexcerpt.evo_withteaser div.item_excerpt > a, div.widget_core_coll_post_list.evo_noexcerpt.evo_withteaser div.item_excerpt > a, div.widget_core_coll_page_list.evo_noexcerpt.evo_withteaser div.item_excerpt > a, div.widget_core_coll_related_post_list.evo_noexcerpt.evo_withteaser div.item_excerpt > a, div.widget_core_coll_item_list.evo_withexcerpt.evo_withteaser div.item_excerpt > a, div.widget_core_coll_featured_posts.evo_withexcerpt.evo_withteaser div.item_excerpt > a, div.widget_core_coll_post_list.evo_withexcerpt.evo_withteaser div.item_excerpt > a, div.widget_core_coll_page_list.evo_withexcerpt.evo_withteaser div.item_excerpt > a, div.widget_core_coll_related_post_list.evo_withexcerpt.evo_withteaser div.item_excerpt > a, div.widget_core_coll_item_list.evo_withexcerpt.evo_noteaser div.item_excerpt > a, div.widget_core_coll_featured_posts.evo_withexcerpt.evo_noteaser div.item_excerpt > a, div.widget_core_coll_post_list.evo_withexcerpt.evo_noteaser div.item_excerpt > a, div.widget_core_coll_page_list.evo_withexcerpt.evo_noteaser div.item_excerpt > a, div.widget_core_coll_related_post_list.evo_withexcerpt.evo_noteaser div.item_excerpt > a { display: none }';
		}

		/**
		* ============================================================================
		* Footer Settings Output
		* ============================================================================
		*/
		if ( $bg_color = $this->get_setting( 'footer_bg_color' ) ) {
			$custom_css .= 'body #main-footer { background-color: '.$bg_color." }\n";
		}

		if ( $color = $this->get_setting( 'footer_widget_title' ) ) {
			$custom_css .= '#main-footer .main_widget .title_widget,
			#main-footer .main_widget .widget_core_org_members .user_link h3 { color: '.$color.' }';
			$custom_css .= '#main-footer .main_widget .title_widget::before { background-color: '.$color.' }';
		}

		if ( $color = $this->get_setting( 'footer_sm_color' ) ) {
			$custom_css .= '#main-footer .footer_social_media .ufld_icon_links a span, #main-footer .footer_social_media .ufld_icon_links a .fa { color: '.$color.' }';
			$custom_css .= '#main-footer .footer_social_media .ufld_icon_links a:hover span, #main-footer .footer_social_media .ufld_icon_links a:hover .fa { color: #FFFFFF }';
		}

		if ( $bg_color = $this->get_setting( 'footer_sm_bgcolor' ) ) {
			$custom_css .= '#main-footer .footer_social_media{ background-color: '.$bg_color.' }';
		}

		if ( $color = $this->get_setting( 'footer_widget_content' ) ) {
			$custom_css .= '#main-footer .main_widget { color: '.$color.' }';
		}

		if( $link = $this->get_setting( 'footer_widget_link' ) ) {
			$custom_css .= '#main-footer .main_widget a { color: '.$link.' }';
		}

		if ( $border_color = $this->get_setting( 'footer_border_color' ) ) {
			$custom_css .= '#main-footer .main_widget ul li, #main-footer .main_widget ul > ul > li:last-child { border-color: '.$border_color.'; }';
			$custom_css .= '#main-footer .footer_social_media, #main-footer .copyright,
			#main-footer .main_widget .widget_core_coll_xml_feeds .notes,
			#main-footer #content .evo_widget ul li, #main-footer #content .evo_widget ul > ul > li:last-child, #main-footer .widget_core_linkblog ul ul, #main-footer .widget_core_content_hierarchy ul ul, #main-footer .widget_core_coll_xml_feeds .notes
			{ border-color: '.$border_color.'; }';
		}

		if ( $bg_color = $this->get_setting( 'footer_tags_bg' ) ) {
			$custom_css .= '#main-footer .evo_widget .tag_cloud a { background-color: '.$bg_color.'; }';
		}

		if ( $color = $this->get_setting( 'footer_copyright_content' ) ) {
			$custom_css .= '#main-footer .copyright .copyright_text { color: '.$color.' }';
		}

		if ( $link = $this->get_setting( 'footer_copyright_link' ) ) {
			$custom_css .= '#main-footer .copyright .copyright_text a { color: '.$link.' }';
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
