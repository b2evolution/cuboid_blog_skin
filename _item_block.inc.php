<?php
/**
 * This is the template that displays the item block: title, author, content (sub-template), tags, comments (sub-template)
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template (or other templates)
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2015 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $Item, $Skin, $app_version;

// Default params:
$params = array_merge( array(
	'feature_block'             => false,			// fp>yura: what is this for??
	// Classes for the <article> tag:
	'item_class'                => 'evo_post evo_content_block',
	'item_type_class'           => 'evo_post__ptyp_',
	'item_status_class'         => 'evo_post__',
	// Controlling the title:
	'disp_title'                => true,
	'item_title_line_before'    => '<div class="evo_post_title">',	// Note: we use an extra class because it facilitates styling
	'item_title_before'         => '<h2>',
	'item_title_after'          => '</h2>',
	'item_title_single_before'  => '<h1>',	// This replaces the above in case of disp=single or disp=page
	'item_title_single_after'   => '</h1>',
	'item_title_line_after'     => '</div>',

	// Controlling the content:
	'before_content_teaser'     => '',
	'after_content_teaser'      => '',
	'content_mode'              => 'auto',		// excerpt|full|normal|auto -- auto will auto select depending on $disp-detail
	'image_class'               => 'img-responsive',
	'image_size'                => 'fit-1280x720',
	'image_link_to'             => 'original', // Can be 'original', 'single' or empty
	'author_link_text'          => 'preferredname',

	'before_images'             => '<div class="evo_post_images">',
	'before_image'              => '<figure class="evo_image_block">',
	'before_image_legend'       => '<figcaption class="evo_image_legend">',
	'after_image_legend'        => '</figcaption>',
	'after_image'               => '</figure>',
	'after_images'              => '</div>',

	'before_gallery'            => '<div class="evo_post_gallery clearfix">',
	'after_gallery'             => '</div>',
), $params );


// Post Column
$column = '';
if ( $disp == 'posts' && ($Skin->get_setting( 'posts_column' ) == 'two') ) {
   $column = 'two_column';
} else if ( $disp == 'posts' && ($Skin->get_setting( 'posts_column' ) == 'three') ) {
   $column = 'three_column';
}

// Content Block
$content_block = 'evo_content_block';
if ( $disp === 'posts' && $Item->is_intro() ) {
	$content_block = "item_posts intro_post";
} elseif( $disp === 'posts' ) {
   $content_block = "item_posts $column";
}


echo '<div class="'.$content_block.'">'; // Beginning of post display
?>

<article id="<?php $Item->anchor_id() ?>" class="<?php $Item->div_classes( $params ) ?>" lang="<?php $Item->lang() ?>">
<?php
	if ( $disp == 'posts' ) {
		// Display images that are linked to this post:
		$Item->images( array(
			// Optionally restrict to files/images linked to specific position: 'teaser'|'teaserperm'|'teaserlink'|'aftermore'|'inline'|'cover'
			'restrict_to_image_position' => 'teaser',
			'before'                     => $params['before_images'],
			'before_image'               => $params['before_image'],
			'before_image_legend'        => $params['before_image_legend'],
			'after_image_legend'         => $params['after_image_legend'],
			'after_image'                => $params['after_image'],
			'after'                      => $params['after_images'],
			'image_class'                => $params['image_class'],
			'image_size'                 => $params['image_size'],
			'limit'                      => 2,
			'image_link_to'              => $params['image_link_to'],

			'before_gallery'             => $params['before_gallery'],
			'after_gallery'              => $params['after_gallery'],
		) );
	}

	if ( $disp == 'single' || $disp == 'page' ) {
		// Display images that are linked to this post:
		$Item->images( array(
			// Optionally restrict to files/images linked to specific position: 'teaser'|'teaserperm'|'teaserlink'|'aftermore'|'inline'|'cover'
			'restrict_to_image_position' => 'cover',
			'before'                     => '<div class="evo_post_images cover_image">',
			'before_image'               => $params['before_image'],
			'before_image_legend'        => $params['before_image_legend'],
			'after_image_legend'         => $params['after_image_legend'],
			'after_image'                => $params['after_image'],
			'after'                      => $params['after_images'],
			'image_class'                => $params['image_class'],
			'image_size'                 => 'original',
			'limit'                      => 1,
			'image_link_to'              => $params['image_link_to'],
		) );
	}

	if( $Item->is_intro() )
		{	// Display images that are linked to this post:
			$Item->images( array(
				'before_image'             => '<div class="evo_post_images"><figure class="special_cover_intro">',
				'before_image_legend'      => '<figcaption class="evo_image_legend">',
				'after_image_legend'       => '</figcaption>',
				'after_image'              => '</figure></div>',
				'image_class'              => 'img-responsive',
				'image_size'               => 'fit-1280x720',
				'image_limit'              =>  1,
				'image_link_to'            => 'original', // Can be 'original', 'single' or empty
				// We DO NOT want to display galleries here, only one cover image
				'gallery_image_limit'      => 0,
				'gallery_colls'            => 0,
				// We want ONLY cover image to display here
				'restrict_to_image_position' => 'cover',
			) );
		}

   ?>

	<header>
	<?php
		$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)

		if( $disp == 'single' || $disp == 'page' )
		{
			$title_before = $params['item_title_single_before'];
			$title_after = $params['item_title_single_after'];
		}
		else
		{
			$title_before = $params['item_title_before'];
			$title_after = $params['item_title_after'];
		}

		if( $disp == 'page' )
		{
			// ------- Title -------
			if( $params['disp_title'] )
			{
				echo $params['item_title_line_before'];

				// POST TITLE:
				$Item->title( array(
					'before'    => $title_before,
					'after'     => $title_after,
					'link_type' => '#'
				) );

				// EDIT LINK:
				if( $Item->is_intro() )
				{	// Display edit link only for intro posts, because for all other posts the link is displayed on the info line.
					$Item->edit_link( array(
						'before' => '<div class="'.button_class( 'group' ).'">',
						'after'  => '</div>',
						'text'   => $Item->is_intro() ? get_icon( 'edit' ).' '.T_('Edit Intro') : '#',
						'class'  => button_class( 'text' ),
					) );
				}

				echo $params['item_title_line_after'];
			}
		}
	?>

	<?php
	if( ! $Item->is_intro() )
	{	// Don't display the following for intro posts
	?>
		<?php
		if( $disp == 'posts' )
		{
			// ------------------------- "Item in List" CONTAINER EMBEDDED HERE --------------------------
			// Display container contents:
			widget_container( 'item_in_list', array(
				'widget_context' => 'item',	// Signal that we are displaying within an Item
				// The following (optional) params will be used as defaults for widgets included in this container:
				'container_display_if_empty' => false, // If no widget, don't display container at all
				// This will enclose each widget in a block:
				'block_start' => '<div class="evo_widget $wi_class$">',
				'block_end' => '</div>',
				// This will enclose the title of each widget:
				'block_title_start' => '<h3>',
				'block_title_end' => '</h3>',

				'author_link_text' => $params['author_link_text'],

				// Controlling the title:
				'widget_item_title_params'  => array(
					'before' => '<div class="evo_post_title">'.$title_before,
					'after' => $title_after.'</div>',
				),
				// Item Visibility Badge widge template
				'widget_item_visibility_badge_display'  => ( ! $Item->is_intro() && $Item->status != 'published' ),
				'widget_item_visibility_badge_template' => '<div class="small text-muted pull-right">
						<div class="evo_status evo_status__$status$ badge" data-toggle="tooltip" data-placement="top" title="$tooltip_title$">$status_title$</div></div>',
			) );
			// ----------------------------- END OF "Item in List" CONTAINER -----------------------------
		}
		elseif( $disp != 'page' )
		{
			// ------------------------- "Item Single - Header" CONTAINER EMBEDDED HERE --------------------------
			// Display container contents:
			widget_container( 'item_single_header', array(
				'widget_context' => 'item',	// Signal that we are displaying within an Item
				// The following (optional) params will be used as defaults for widgets included in this container:
				'container_display_if_empty' => false, // If no widget, don't display container at all
				// This will enclose each widget in a block:
				'block_start' => '<div class="evo_widget $wi_class$">',
				'block_end' => '</div>',
				// This will enclose the title of each widget:
				'block_title_start' => '<h3>',
				'block_title_end' => '</h3>',

				'author_link_text' => $params['author_link_text'],

				// Controlling the title:
				'widget_item_title_params'  => array(
						'before' => '<div class="evo_post_title">'.$title_before,
						'after' => $title_after.'</div>',
					),
				// Item Previous Next widget
				'widget_item_next_previous_params' => array(
						'block_start' => '<nav><ul class="pager">',
						'block_end' => '</ul></nav>',
						'prev_start' => '<li class="previous">',
						'prev_end' => '</li>',
						'next_start' => '<li class="next">',
						'next_end' => '</li>',
					),
				// Item Visibility Badge widge template
				'widget_item_visibility_badge_display'  => ( ! $Item->is_intro() && $Item->status != 'published' ),
				'widget_item_visibility_badge_template' => '<div class="evo_status evo_status__$status$ badge pull-right small text-muted" data-toggle="tooltip" data-placement="top" title="$tooltip_title$">$status_title$</div>',
			) );
			// ----------------------------- END OF "Item Single - Header" CONTAINER -----------------------------
		}
		?>
		<div class="small text-muted">
		<?php
			if( $disp != 'page' )
			{
				// Permalink:
				$Item->permanent_link( array(
					'text' => '',
				) );

				// We want to display the post time:
				$Item->issue_time( array(
					'before'      => ' '.T_( 'Posted on <span>' ).' ',
					'after'       => '</span>',
					'time_format' => 'M j, Y',
				) );

				// Author
				$Item->author( array(
					'before'    => ' '.T_('<span>/</span> By').' ',
					'after'     => '',
					'link_text' => $params['author_link_text'],
				) );

				// Categories
				$Item->categories( array(
					'before'          => T_(' <span>/</span> in').' ',
					'after'           => ' ',
					'include_main'    => true,
					'include_other'   => true,
					'include_external'=> true,
					'link_categories' => true,
				) );

				// Link for editing
				$Item->edit_link( array(
					'before'    => ' &bull; ',
					'after'     => '',
				) );
			}
		?>
		</div>
	<?php
	}
	?>
	</header>

	<?php
	if( $disp == 'single' )
	{
		// ------------------------- "Item Single" CONTAINER EMBEDDED HERE --------------------------
			// Display container contents:
			widget_container( 'item_single', array(
				'widget_context' 			 => 'item',	// Signal that we are displaying within an Item
				// The following (optional) params will be used as defaults for widgets included in this container:
				'container_display_if_empty' => false, // If no widget, don't display container at all
				'container_start' => '<div class="evo_container $wico_class$">',
				'container_end'   => '</div>',
				// This will enclose each widget in a block:
				'block_start' 				 => '<div class="evo_widget $wi_class$">',
				'block_end' 				 => '</div>',
				// This will enclose the title of each widget:
				'block_title_start' 		 => '<h3>',
				'block_title_end' 			 => '</h3>',
				// Template params for "Item Tags" widget
				'widget_item_tags_before'    => '<div class="post_tags"><h3>'.T_('Tags').'</h3>: ',
				'widget_item_tags_after'     => '</div>',
				'widget_item_tags_separator' => '',
				// Params for skin file "_item_content.inc.php"
				'widget_item_content_params' => $params,
			) );
		// ----------------------------- END OF "Item Single" CONTAINER -----------------------------
	}
	elseif( $disp == 'page' )
	{
		// ------------------------- "Item Page" CONTAINER EMBEDDED HERE --------------------------
			// Display container contents:
			widget_container( 'item_page', array(
				'widget_context' 			 => 'item',	// Signal that we are displaying within an Item
				// The following (optional) params will be used as defaults for widgets included in this container:
				'container_display_if_empty' => false, // If no widget, don't display container at all
				'container_start' => '<div class="evo_container $wico_class$">',
				'container_end'   => '</div>',
				// This will enclose each widget in a block:
				'block_start' 				 => '<div class="evo_widget $wi_class$">',
				'block_end' 				 => '</div>',
				// This will enclose the title of each widget:
				'block_title_start' 		 => '<h3>',
				'block_title_end' 			 => '</h3>',
				// Template params for "Item Tags" widget
				'widget_item_tags_before'    => '<div class="post_tags"><h3>'.T_('Tags').'</h3>: ',
				'widget_item_tags_after'     => '</div>',
				'widget_item_tags_separator' => '',
				// Params for skin file "_item_content.inc.php"
				'widget_item_content_params' => $params,
			) );
		// ----------------------------- END OF "Item Page" CONTAINER -----------------------------
	}
	else
	{
	// this will create a <section>
		// ---------------------- POST CONTENT INCLUDED HERE ----------------------
		skin_include( '_item_content.inc.php', $params );
		// Note: You can customize the default item content by copying the generic
		// /skins/_item_content.inc.php file into the current skin folder.
		// -------------------------- END OF POST CONTENT -------------------------
	// this will end a </section>
	}
	?>

	<footer>

		<?php
			if( ! $Item->is_intro() && $disp == 'posts' )
			{	// List all tags attached to this post:
				$Item->tags( array(
					'before'    => '<nav class="small post_tags"><h3>'. T_( 'Tags: ' ).'</h3>',
					'after'     => '</nav>',
					'separator' => '',
				) );
			}
		?>

		<?php if( ! $Item->is_intro() ) : ?>
		<nav class="post_comments_link">
		<?php
			// Link to comments, trackbacks, etc.:
			$Item->feedback_link( array(
				'type'           => 'comments',
				'link_before'    => '',
				'link_after'     => '',
				'link_text_zero' => '#',
				'link_text_one'  => '#',
				'link_text_more' => '#',
				'link_title'     => '#',
				// fp> WARNING: creates problem on home page: 'link_class' => 'btn btn-default btn-sm',
				// But why do we even have a comment link on the home page ? (only when logged in)
			) );

			// Link to comments, trackbacks, etc.:
			$Item->feedback_link( array(
				'type'           => 'trackbacks',
				'link_before'    => ' &bull; ',
				'link_after'     => '',
				'link_text_zero' => '#',
				'link_text_one'  => '#',
				'link_text_more' => '#',
				'link_title'     => '#',
			) );
		?>
		</nav>
		<?php endif; ?>
	</footer>

	<div class="content_comment">
		<?php
			// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
			skin_include( '_item_feedback.inc.php', array(
				'Item'                   => NULL,
				'disp_comments'          => true,
				'disp_comment_form'      => true,
				'disp_trackbacks'        => true,
				'disp_trackback_url'     => true,
				'disp_pingbacks'         => true,
				'disp_meta_comments'     => false,
				'disp_section_title'     => true,
				'disp_meta_comment_info' => true,
				'disp_rating_summary'    => true,
				'before_section_title'   => '<div class="clearfix"></div><h3 class="evo_comment__list_title"><i class="fa fa-comments"></i> ',
				'after_section_title'    => '</h3>',
				'comments_title_text'    => '',
				'comment_list_start'     => "\n\n",
				'comment_list_end'       => "\n\n",
				'comment_start'          => '<article class="evo_comment">',
				'comment_end'            => '</article>',
				'comment_post_display'	 => false,	// Do we want ot display the title of the post we're referring to?
				'comment_post_before'    => '<h3 class="evo_comment_post_title">',
				'comment_post_after'     => '</h3>',
				'comment_title_before'   => '<h4 class="evo_comment_title panel-title">',
				'comment_title_after'    => '</h4>',
				'comment_avatar_before'  => '<span class="evo_comment_avatar">',
				'comment_avatar_after'   => '</span>',
				'comment_rating_before'  => '<div class="evo_comment_rating">',
				'comment_rating_after'   => '</div>',
				'comment_text_before'    => '<div class="evo_comment_text">',
				'comment_text_after'     => '</div>',
				'comment_info_before'    => '<div class="evo_comment_info clear text-muted"><small>',
				'comment_info_after'     => '</small></div>',
				'preview_start'          => '<div class="evo_comment evo_comment__preview panel panel-warning" id="comment_preview">',
				'preview_end'            => '</div>',
				'comment_error_start'    => '<div class="evo_comment evo_comment__error panel panel-default" id="comment_error">',
				'comment_error_end'      => '</div>',
				'comment_template'       => '_item_comment.inc.php',	// The template used for displaying individual comments (including preview)
				'comment_image_size'     => 'fit-1280x720',
				'author_link_text'       => 'name', // avatar_name | avatar_login | only_avatar | name | login | nickname | firstname | lastname | fullname | preferredname
				'link_to'                => 'userurl>userpage',		    // 'userpage' or 'userurl' or 'userurl>userpage' or 'userpage>userurl'
				// Comment notification functions:
				'disp_notification'      => true,
				'notification_before'    => '<nav class="evo_post_comment_notification">',
				'notification_text'      => T_( 'This is your post. You are receiving notifications when anyone comments on your posts.' ),
				'notification_text2'     => T_( 'You will be notified by email when someone comments here.' ),
				'notification_text3'     => T_( 'Notify me by email when someone comments here.' ),
				'notification_after'     => '</nav>',
				'feed_title'             => '#',
				'disp_nav_top'           => true,
				'disp_nav_bottom'        => true,
				'nav_top_inside'         => false, // TRUE to display it after start of comments list (inside), FALSE to display a page navigation before comments list
				'nav_bottom_inside'      => false, // TRUE to display it before end of comments list (inside), FALSE to display a page navigation after comments list
				'nav_block_start'        => '<div class="text-center"><ul class="pagination">',
				'nav_block_end'          => '</ul></div>',
				'nav_prev_text'          => '<i class="fa fa-angle-double-left"></i>',
				'nav_next_text'          => '<i class="fa fa-angle-double-right"></i>',
				'nav_prev_class'         => '',
				'nav_next_class'         => '',
				'nav_page_item_before'   => '<li>',
				'nav_page_item_after'    => '</li>',
				'nav_page_current_template' => '<span><b>$page_num$</b></span>',
				'comments_per_page'      => NULL, // Used instead of blog setting "comments_per_page"
				'pagination'             => array(),
			) );
			// Note: You can customize the default item feedback by copying the generic
			// /skins/_item_feedback.inc.php file into the current skin folder.
			// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
		?>
	</div>

	<?php
   if( evo_version_compare( $app_version, '6.7' ) >= 0 )
   { 	// We are running at least b2evo 6.7, so we can include this file:
		// ------------------ WORKFLOW PROPERTIES INCLUDED HERE ------------------
		skin_include( '_item_workflow.inc.php' );
		// ---------------------- END OF WORKFLOW PROPERTIES ---------------------
	}

   if( evo_version_compare( $app_version, '6.7' ) >= 0 )
   {  // We are running at least b2evo 6.7, so we can include this file:
		// ------------------ META COMMENTS INCLUDED HERE ------------------
		skin_include( '_item_meta_comments.inc.php', array(
	       'comment_start'         => '<article class="evo_comment evo_comment__meta panel panel-default">',
	       'comment_end'           => '</article>',

		   'before_section_title'   => '<div class="clearfix"></div><h3 class="evo_comment__list_title"><i class="fa fa-comments"></i> ',
		   'after_section_title'    => '</h3>',
		   'comment_start'          => '<article class="evo_comment">',
		   'comment_end'            => '</article>',
		   'comment_post_before'    => '<h3 class="evo_comment_post_title">',
		   'comment_post_after'     => '</h3>',
		   'comment_title_before'   => '<h4 class="evo_comment_title panel-title">',
		   'comment_title_after'    => '</h4>',
		   'comment_avatar_before'  => '<span class="evo_comment_avatar">',
		   'comment_avatar_after'   => '</span>',
		   'comment_rating_before'  => '<div class="evo_comment_rating">',
		   'comment_rating_after'   => '</div>',
		   'comment_text_before'    => '<div class="evo_comment_text">',
		   'comment_text_after'     => '</div>',
		   'comment_info_before'    => '<div class="evo_comment_info clear text-muted"><small>',
		   'comment_info_after'     => '</small></div>',
		   'preview_start'          => '<div class="evo_comment evo_comment__preview panel panel-warning" id="comment_preview">',
		   'preview_end'            => '</div>',
		   'comment_error_start'    => '<div class="evo_comment evo_comment__error panel panel-default" id="comment_error">',
		   'comment_error_end'      => '</div>',

	    ) );
		// ---------------------- END OF META COMMENTS ---------------------
   }
   ?>

	<?php
		locale_restore_previous();	// Restore previous locale (Blog locale)
	?>
</article>

<?php echo '</div>'; // End of post display ?>
