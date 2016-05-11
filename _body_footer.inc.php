<?php
/**
* This is the BODY footer include template.
*
* For a quick explanation of b2evo 2.0 skins, please start here:
* {@link http://b2evolution.net/man/skin-development-primer}
*
* This is meant to be included in a page template.
*
* @package evoskins
*/
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

?>

<footer id="main-footer">
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
