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
   <h2>404 Not Found</h2>
   <p><a href="<?php echo $baseurl; ?>"><?php echo $app_name; ?></a> cannot resolve the requested URL.</p>
</div>
