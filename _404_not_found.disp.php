<?php
/**
 * This is the template that displays the 404 disp content
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template.
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2016 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $disp_detail, $baseurl, $app_name;

?>

<div class="error_404">
   <i class="fa fa-warning" aria-hidden="true"></i>
   <?php
       skin_container( /* TRANS: Widget container name */ NT_('404 Page'), array(
           'widget_context' 			 => 'item',	// Signal that we are displaying within an Item
           // The following (optional) params will be used as defaults for widgets included in this container:
           // This will enclose each widget in a block:
           'block_start' 				 => '<div class="$wi_class$">',
           'block_end' 				     => '</div>',
           // This will enclose the title of each widget:
           'block_title_start' 		     => '<h3>',
           'block_title_end' 			 => '</h3>',
           // Template params for "Item Tags" widget
           'widget_item_tags_before'     => '<div class="small">'.T_('Tags').': ',
           'widget_item_tags_after'      => '</div>',
           // Params for skin file "_item_content.inc.php"
           'widget_item_content_params'  => $params,
           // Search
           'search_input_before'   => '<div class="input-group">',
           'search_input_after'    => '',
           'search_submit_before'  => '<span class="input-group-btn">',
           'search_submit_after'   => '</span></div>',
       ) );
   ?>
   <!-- <h2>404 Not Found</h2>
   <p><a href="<?php echo $baseurl; ?>"><?php echo $app_name; ?></a> cannot resolve the requested URL.</p> -->
</div>
