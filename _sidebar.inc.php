<?php
if( $Skin->is_visible_sidebar() ) { // Display sidebar: ?>
<aside id="main-sidebar" class="col-md-4<?php echo ( $Skin->get_setting( 'layout' ) == 'left_sidebar' ? ' pull-left' : '' ); ?>">
   <!-- =================================== START OF SIDEBAR =================================== -->
   <div class="evo_container evo_container__sidebar">
   <?php
      // ------------------------- "Sidebar" CONTAINER EMBEDDED HERE --------------------------
      // Display container contents:
      skin_container( NT_('Sidebar'), array(
            // The following (optional) params will be used as defaults for widgets included in this container:
            // This will enclose each widget in a block:
            'block_start'          => '<div class="panel panel-default evo_widget $wi_class$">',
            'block_end'            => '</div>',
            // This will enclose the title of each widget:
            'block_title_start'    => '<div class="panel-heading"><h4 class="panel-title">',
            'block_title_end'      => '</h4></div>',
            // This will enclose the body of each widget:
            'block_body_start'     => '<div class="panel-body">',
            'block_body_end'       => '</div>',
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
            // Widget 'Search form':
            'search_class'         => 'compact_search_form',
            'search_input_before'  => '<div class="input-group">',
            'search_input_after'   => '',
            'search_submit_before' => '<span class="input-group-btn">',
            'search_submit_after'  => '</span></div>',
         ) );
      // ----------------------------- END OF "Sidebar" CONTAINER -----------------------------
   ?>
   </div><!-- .sidebar -->

   <div class="evo_container evo_container__sidebar2">
   <?php
      // ------------------------- "Sidebar" CONTAINER EMBEDDED HERE --------------------------
      // Display container contents:
      skin_container( NT_('Sidebar 2'), array(
            // The following (optional) params will be used as defaults for widgets included in this container:
            // This will enclose each widget in a block:
            'block_start'          => '<div class="panel panel-default evo_widget $wi_class$">',
            'block_end'            => '</div>',
            // This will enclose the title of each widget:
            'block_title_start'    => '<div class="panel-heading"><h4 class="panel-title">',
            'block_title_end'      => '</h4></div>',
            // This will enclose the body of each widget:
            'block_body_start'     => '<div class="panel-body">',
            'block_body_end'       => '</div>',
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
            // Widget 'Search form':
            'search_class'         => 'compact_search_form',
            'search_input_before'  => '<div class="input-group">',
            'search_input_after'   => '',
            'search_submit_before' => '<span class="input-group-btn">',
            'search_submit_after'  => '</span></div>',
         ) );
      // ----------------------------- END OF "Sidebar" CONTAINER -----------------------------
   ?>
   </div><!-- .sidebar2 -->
</aside><!-- #main-sidebar -->
<?php } ?>
