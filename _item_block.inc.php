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

global $Item, $Skin;

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


echo '<div class="evo_content_block">'; // Beginning of post display
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

   if ( $disp == 'single' ) {
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
   ?>

	<header>
	<?php
		$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)

		// ------- Title -------
		if( $params['disp_title'] )
		{
			echo $params['item_title_line_before'];

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

			// POST TITLE:
			$Item->title( array(
					'before'    => $title_before,
					'after'     => $title_after,
					'link_type' => '#'
				) );

			// EDIT LINK:
			if( $Item->is_intro() )
			{ // Display edit link only for intro posts, because for all other posts the link is displayed on the info line.
				$Item->edit_link( array(
					'before' => '<div class="'.button_class( 'group' ).'">',
					'after'  => '</div>',
					'text'   => $Item->is_intro() ? get_icon( 'edit' ).' '.T_('Edit Intro') : '#',
					'class'  => button_class( 'text' ),
				) );
			}

			echo $params['item_title_line_after'];
		}
	?>

	<?php
	if( ! $Item->is_intro() )
	{ // Don't display the following for intro posts
	?>
	<div class="small text-muted">
	<?php
		if( $Item->status != 'published' )
		{
			$Item->format_status( array(
				'template' => '<div class="evo_status evo_status__$status$ badge pull-right">$status_title$</div>',
			) );
		}
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
	?>
	</div>
	<?php
	}
	?>
	</header>

	<?php
	// this will create a <section>
		// ---------------------- POST CONTENT INCLUDED HERE ----------------------
		skin_include( '_item_content.inc.php', $params );
		// Note: You can customize the default item content by copying the generic
		// /skins/_item_content.inc.php file into the current skin folder.
		// -------------------------- END OF POST CONTENT -------------------------
	// this will end a </section>
	?>

	<footer>

		<?php
			if( ! $Item->is_intro() )
			{ // List all tags attached to this post:
				$Item->tags( array(
						'before'    => '<nav class="small post_tags">',
						'after'     => '</nav>',
						'separator' => ' ',
					) );
			}
		?>

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
	</footer>

	<?php
		// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
		skin_include( '_item_feedback.inc.php', array_merge( array(), $params ) );
		// Note: You can customize the default item feedback by copying the generic
		// /skins/_item_feedback.inc.php file into the current skin folder.
		// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
	?>

	<?php
		locale_restore_previous();	// Restore previous locale (Blog locale)
	?>
</article>

<?php echo '</div>'; // End of post display ?>
