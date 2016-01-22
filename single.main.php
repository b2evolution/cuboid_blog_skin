<?php
/**
 * This is the main/default page template for the "bootstrap_blog" skin.
 *
 * This skin only uses one single template which includes most of its features.
 * It will also rely on default includes for specific dispays (like the comment form).
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * The main page template is used to display the blog when no specific page template is available
 * to handle the request (based on $disp).
 *
 * @package evoskins
 * @subpackage bootstrap_blog
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

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
skin_include( '_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------
?>

<div id="content">
   <div class="container">
      <div class="row">

      	<div class="<?php echo $Skin->get_column_class( 'single_layout' ); ?>">

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
                  'block_start'     => '<nav><ul class="pager">',
                  'prev_start'      => '<li class="previous">',
                  'prev_text'       => '<i class="fa fa-long-arrow-left"></i> $title$',
                  'prev_end'        => '</li>',
                  'separator'       => ' ',
                  'next_start'      => '<li class="next">',
                  'next_text'       => '$title$ <i class="fa fa-long-arrow-right"></i>',
                  'next_end'        => '</li>',
                  'block_end'       => '</ul></nav>',
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
      					'msgform_form_title'    => T_('Sending a message'),
      				) );
      			// Note: you can customize any of the sub templates included here by
      			// copying the matching php file into your skin directory.
      			// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
      		?>
      		</main>

      	</div><!-- .col -->

         <?php
            // ------------------------- SIDEBAR INCLUDED HERE --------------------------
            skin_include( '_sidebar.inc.php' );
            // Note: You can customize the sidebar by copying the
            // _sidebar.inc.php file into the current skin folder.
            // ----------------------------- END OF SIDEBAR -----------------------------
         ?>

      </div><!-- .row -->
   </div><!-- .container -->
</div><!-- #content -->


<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
skin_include( '_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------


// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// ------------------------------- END OF FOOTER --------------------------------
?>
