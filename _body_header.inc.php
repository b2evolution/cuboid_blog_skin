<?php
/**
* This is the BODY header include template.
*
* For a quick explanation of b2evo 2.0 skins, please start here:
* {@link http://b2evolution.net/man/skin-development-primer}
*
* This is meant to be included in a page template.
*
* @package evoskins
*/
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
siteskin_include( '_site_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------

?>
<header id="main-header">
    <div class="container">

                    <?php
                    // ------------------------- "Header" CONTAINER EMBEDDED HERE --------------------------
                    // Display container and contents:
                    widget_container( 'header', array(
                        // The following params will be used as defaults for widgets included in this container:
                        'container_display_if_empty' => false, // If no widget, don't display container at all
                        'container_start'   => '<div class="col-xs-9 col-sm-12 col-md-4"><div class="row"><div class="evo_container $wico_class$">',
                        'container_end'     => '</div></div></div>',
                        'block_start'       => '<div class="evo_widget $wi_class$">',
                        'block_end'         => '</div>',
                        'block_title_start' => '<h1>',
                        'block_title_end'   => '</h1>',
                    ) );
                    // ----------------------------- END OF "Header" CONTAINER -----------------------------
                    ?>

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

                        <?php
                        // ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
                        // Display container and contents:
                        // Note: this container is designed to be a single <ul> list
                        widget_container( 'menu', array(
                            // The following params will be used as defaults for widgets included in this container:
                            'container_display_if_empty' => false, // If no widget, don't display container at all
                            'container_start'     => '<div class="col-xs-12 col-sm-12 col-md-8"><div class="row"><nav class="collapse navbar-collapse" id="main-menu"><ul class="nav nav-tabs evo_container $wico_class$">',
                            'container_end'       => '</ul></nav></div></div>',
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

    </div><!-- .container -->
</header><!-- #main-header -->
