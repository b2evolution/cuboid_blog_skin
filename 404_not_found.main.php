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
      	<div class="col-md-12">

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
      			// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
      			skin_include( '$disp$', array( ) );
      			// Note: you can customize any of the sub templates included here by
      			// copying the matching php file into your skin directory.
      			// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
      		?>
      		</main>

      	</div><!-- .col -->
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
