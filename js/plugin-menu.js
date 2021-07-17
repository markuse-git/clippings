jQuery(document).ready(function($){
    
    // stop our admin menus from collapsing
    if( $('body[class*=" mcsm_"]').length || $('body[class*=" post-type-"]').length ) {

        $mcsm_menu_li = $('#toplevel_page_mcsm_menu_info_page');
        
        $mcsm_menu_li
        .removeClass('wp-not-current-submenu')
        .addClass('wp-has-current-submenu')
        .addClass('wp-menu-open');
        
        $('a:first',$mcsm_menu_li)
        .removeClass('wp-not-current-submenu')
        .addClass('wp-has-submenu')
        .addClass('wp-has-current-submenu')
        .addClass('wp-menu-open');
        
    }
    
});