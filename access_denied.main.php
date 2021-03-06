<?php
/**
 * This file is the template that displays "access denied" for non-members.
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * @package evoskins
 * @subpackage bootstrap_blog
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );


global $app_version, $disp, $Blog;

if( version_compare( $app_version, '6.4' ) < 0 )
{ // Older skins (versions 2.x and above) should work on newer b2evo versions, but newer skins may not work on older b2evo versions.
	die( 'This skin is designed for b2evolution 6.4 and above. Please <a href="http://b2evolution.net/downloads/index.html">upgrade your b2evolution</a>.' );
}

// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );


// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php', array() );
// -------------------------------- END OF HEADER --------------------------------


// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
siteskin_include( '_site_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------

$column = '';
switch ( $disp ) {
   case 'page':
      $column = 'single_layout';
   break;
   case 'mediaidx':
      $column = 'mediaidx_layout';
   break;
   case 'user':
      $column = 'user_layout';
   break;
   default:
      $column = 'layout';
   break;
};

$content_grid = $Skin->get_column_class( $column );

?>
<?php if( $Skin->is_visible_container( 'header' ) ) { ?>
<header id="main-header">
	<div class="container">

		<div class="col-xs-9 col-sm-12 col-md-4">
			<div class="row">
				<div class="evo_container evo_container__header">
					<?php
					// ------------------------- "Header" CONTAINER EMBEDDED HERE --------------------------
					// Display container and contents:
					skin_container( NT_('Header'), array(
						// The following params will be used as defaults for widgets included in this container:
						'block_start'       => '<div class="evo_widget $wi_class$">',
						'block_end'         => '</div>',
						'block_title_start' => '<h1>',
						'block_title_end'   => '</h1>',
					) );
					// ----------------------------- END OF "Header" CONTAINER -----------------------------
					?>
				</div>
			</div><!-- .row -->
		</div><!-- .col -->

		<div id="hamburger-menu" class="col-xs-3 col-sm-4">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-8">
			<div class="row">
				<nav class="collapse navbar-collapse" id="main-menu">
					<ul class="nav nav-tabs evo_container evo_container__menu">
						<?php
						// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
						// Display container and contents:
						// Note: this container is designed to be a single <ul> list
						skin_container( NT_('Menu'), array(
							// The following params will be used as defaults for widgets included in this container:
							'block_start'         => '',
							'block_end'           => '',
							'block_display_title' => false,
							'list_start'          => '',
							'list_end'            => '',
							'item_start'          => '<li class="evo_widget $wi_class$">',
							'item_end'            => '</li>',
							'item_selected_start' => '<li class="active evo_widget $wi_class$">',
							'item_selected_end'   => '</li>',
							'item_title_before'   => '',
							'item_title_after'    => '',
						) );
						// ----------------------------- END OF "Menu" CONTAINER -----------------------------
						?>
					</ul>
				</nav><!-- #main-menu -->
			</div><!-- .row -->
		</div><!-- .col -->

	</div><!-- .container -->
</header><!-- #main-header -->
<?php } ?>


<div id="content">
	<div class="container">
		<div class="row">
			<div class="<?php if( $Skin->is_visible_container( 'sidebar' ) ){ echo $Skin->get_column_class( $column ); } else { echo 'col-md-12'; } ?>">
				<main id="main-content"><!-- This is were a link like "Jump to main content" would land -->
					<!-- ================================= START OF MAIN AREA ================================== -->

				<?php
				if( ! in_array( $disp, array( 'login', 'lostpassword', 'register', 'activateinfo', 'access_requires_login' ) ) )
				{ // Don't display the messages here because they are displayed inside wrapper to have the same width as form
					// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
					messages( array(
						'block_start' => '<div class="action_messages">',
						'block_end'   => '</div>',
					) );
					// --------------------------------- END OF MESSAGES ---------------------------------
				}
				?>

				<?php
				// ------------------- PREV/NEXT POST LINKS (SINGLE POST MODE) -------------------
				item_prevnext_links( array(
					'block_start' => '<nav><ul class="pager">',
					'prev_start'  => '<li class="previous">',
					'prev_end'    => '</li>',
					'next_start'  => '<li class="next">',
					'next_end'    => '</li>',
					'block_end'   => '</ul></nav>',
				) );
				// ------------------------- END OF PREV/NEXT POST LINKS -------------------------
				?>

				<?php
				// ------------------------ TITLE FOR THE CURRENT REQUEST ------------------------
				request_title( array(
					'title_before'       => '<h2 class="title_head_post">',
					'title_after'        => '</h2>',
					'title_none'         => '',
					'glue'               => ' - ',
					'title_single_disp'  => false,
					'title_page_disp'    => false,
					'format'             => 'htmlbody',
					'register_text'      => '',
					'login_text'         => '',
					'lostpassword_text'  => '',
					'account_activation' => '',
					'msgform_text'       => '',
					'user_text'          => '',
					'users_text'         => '',
					'display_edit_links' => false,
				) );
				// ----------------------------- END OF REQUEST TITLE ----------------------------
				?>

				<?php
				// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
				skin_include( '$disp$', array(
      					'author_link_text' => 'preferredname',
      					// Profile tabs to switch between user edit forms
      					'profile_tabs' => array(
      						'block_start'         => '<nav><ul class="nav nav-tabs profile_tabs">',
      						'item_start'          => '<li>',
      						'item_end'            => '</li>',
      						'item_selected_start' => '<li class="active">',
      						'item_selected_end'   => '</li>',
      						'block_end'           => '</ul></nav>',
      					),

      					// Pagination
      					'pagination' => array(
      						'block_start'              => '<div class="center"><ul class="pagination">',
      						'block_end'                => '</ul></div>',
      						'page_current_template'    => '<span>$page_num$</span>',
      						'page_item_before'         => '<li>',
      						'page_item_after'          => '</li>',
      						'page_item_current_before' => '<li class="active">',
      						'page_item_current_after'  => '</li>',
      						'prev_text'                => '<i class="fa fa-angle-double-left"></i>',
      						'next_text'                => '<i class="fa fa-angle-double-right"></i>',
      					),

      					// Form params for the forms below: login, register, lostpassword, activateinfo and msgform
      					'skin_form_before'      => '<div class="panel panel-default skin-form">'
                           							.'<div class="panel-heading">'
                           								.'<h3 class="panel-title">$form_title$</h3>'
                           							.'</div>'
                           							.'<div class="panel-body">',
      					'skin_form_after'       => '</div></div>',
      					// Login
      					'display_form_messages' => true,
      					'form_title_login'      => T_('Log in to your account').'$form_links$',
      					'form_title_lostpass'   => get_request_title().'$form_links$',
      					'lostpass_page_class'   => 'evo_panel__lostpass',
      					'login_form_inskin'     => false,
      					'login_page_class'      => 'evo_panel__login',
      					'login_page_before'     => '<div class="$form_class$">',
      					'login_page_after'      => '</div>',
      					'display_reg_link'      => true,
      					'abort_link_position'   => 'form_title',
      					'abort_link_text'       => '<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
      					// Register
      					'register_page_before'          => '<div class="evo_panel__register">',
      					'register_page_after'           => '</div>',
      					'register_form_title'           => T_('Register'),
      					'register_links_attrs'          => '',
      					'register_use_placeholders'     => true,
      					'register_field_width'          => 252,
      					'register_disabled_page_before' => '<div class="evo_panel__register register-disabled">',
      					'register_disabled_page_after'  => '</div>',

      					// Activate form
      					'activate_form_title'   => T_('Account activation'),
      					'activate_page_before'  => '<div class="evo_panel__activation">',
      					'activate_page_after'   => '</div>',

      					// Search
      					'search_input_before'   => '<div class="input-group">',
      					'search_input_after'    => '',
      					'search_submit_before'  => '<span class="input-group-btn">',
      					'search_submit_after'   => '</span></div>',

      					// Front page
      					'featured_intro_before' => '<div class="jumbotron"><div class="intro_background_image"></div>',
      					'featured_intro_after'  => '</div>',

      					// Form "Sending a message"
      					'msgform_form_title'    => T_('Messages'),
      				) );
      			// Note: you can customize any of the sub templates included here by
      			// copying the matching php file into your skin directory.
      			// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
					?>
				</main>

			</div><!-- .col -->

			<?php
			if ( $Skin->is_visible_container( 'sidebar' ) ) {
				// ------------------------- SIDEBAR INCLUDED HERE --------------------------
				skin_include( '_sidebar.inc.php' );
				// Note: You can customize the sidebar by copying the
				// _sidebar.inc.php file into the current skin folder.
				// ----------------------------- END OF SIDEBAR -----------------------------
			}
			?>

		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- #content -->


<footer id="main-footer">
	<?php if( $Skin->is_visible_container( 'footer' ) ) { ?>
		<!-- =================================== START OF FOOTER =================================== -->
		<?php if( $Skin->get_setting( 'footer_widget' ) == '1' ) : ?>
		<div class="main_widget">
			<div class="container">
				<div class="row">
					<?php
					// Display container and contents:
					skin_container( NT_("Footer"), array(
						// The following params will be used as defaults for widgets included in this container:
						'block_start'          => '<div class="evo_widget $wi_class$ col-xs-12 col-sm-6 col-md-3 clearfix">',
						'block_end'            => '</div>',
						// This will enclose the title of each widget:
						'block_title_start'    => '<h3 class="title_widget">',
						'block_title_end'      => '</h3>',
						// If a widget displays a list, this will enclose that list:
						'list_start'           => '<ul>',
						'list_end'             => '</ul>',
						// This will enclose each item in a list:
						'item_start'           => '<li>',
						'item_end'             => '</li>',
						// This will enclose sub-lists in a list:
						'group_start'          => '<ul>',
						'group_end'            => '</ul>',
						// This will enclose (foot)notes:
						'notes_start'          => '<div class="notes">',
						'notes_end'            => '</div>',
						// Search
						'search_class'         => 'compact_search_form',
						'search_input_before'  => '<div class="input-group">',
						'search_input_after'   => '',
						'search_submit_before' => '<span class="input-group-btn">',
						'search_submit_after'  => '</span></div>',
					) );
					// Note: Double quotes have been used around "Footer" only for test purposes.
					?>
				</div><!-- .row -->
			</div><!-- end .container-->
		</div><!-- .main_widger -->
		<?php endif; ?>

		<!-- Social Media -->
		<?php if( $Skin->get_setting( 'footer_user_link' ) == 1 ) : ?>
		<div class="footer_social_media">
			<div class="container">
				<div class="row">
					<?php
					// ------------------------- "Page Top" CONTAINER EMBEDDED HERE --------------------------
					// Display container and contents:
					skin_widget( array(
						// The following params will be used as defaults for widgets included in this container:
						'widget'              => 'user_links',
						'block_start'         => '<div class="evo_widget $wi_class$">',
						'block_end'           => '</div>',
						'block_display_title' => false,
						'list_start'          => '<ul>',
						'list_end'            => '</ul>',
						'item_start'          => '<li>',
						'item_end'            => '</li>',
					) );
					// ----------------------------- END OF "Page Top" CONTAINER -----------------------------
					?>
				</div>
			</div>
		</div><!-- .col -->
		<?php endif; ?>
		<!-- End Social Media -->
	<?php } ?><!-- End Required Access Login -->

	<?php if( $Skin->get_setting( 'footer_copyright' ) == 1 ) : ?>
	<div class="copyright">
		<div class="container">
			<p class="copyright_text">
			<?php
			// Display footer text (text can be edited in Blog Settings):
				$Blog->footer_text( array(
					'before' => '',
					'after'  => ' &bull; ',
				) );
			?>

			<?php
			// Display a link to contact the owner of this blog (if owner accepts messages):
			$Blog->contact_link( array(
				'before' => '',
				'after'  => ' &bull; ',
				'text'   => T_('Contact'),
				'title'  => T_('Send a message to the owner of this blog...'),
			) );

			// Display a link to help page:
			$Blog->help_link( array(
				'before' => ' ',
				'after'  => ' ',
				'text'   => T_('Help'),
			) );
			?>

			<?php
			// Display additional credits:
			// If you can add your own credits without removing the defaults, you'll be very cool :))
			// Please leave this at the bottom of the page to make sure your blog gets listed on b2evolution.net
			credits( array(
				'list_start'  => '&bull;',
				'list_end'    => ' ',
				'separator'   => '&bull;',
				'item_start'  => ' ',
				'item_end'    => ' ',
			) );
			?>
			</p>
			<!-- <a href="#skin_wrapper" class="back_top">Top</a> -->
		</div><!-- .container -->
	</div><!-- .copyright -->
	<?php endif; ?>

</footer><!-- #main-footer -->

<?php if ($Skin->get_setting( 'bt_top' ) == 1 ) { ?>
<a href="#0" class="bt-top"><i class="fa fa-angle-up"></i></a>
<?php } ?>


<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
siteskin_include( '_site_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------


// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// ------------------------------- END OF FOOTER --------------------------------
?>
