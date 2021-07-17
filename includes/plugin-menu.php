<?php

include('menu-info-page.php');
include('options-page.php');

add_action('admin_menu','mcsm_create_menu');

function mcsm_create_menu(){
    
    add_menu_page(
        '',
        'Clippings',
        'manage_options',
        'mcsm_menu_info_page',
        'mcsm_menu_info_page',
        'dashicons-media-document'
    );
    
    add_submenu_page(
        'mcsm_menu_info_page',
        '',
        'Info',
        'manage_options',
        'mcsm_menu_info_page',
        'mcsm_menu_info_page'
    );
    
    add_submenu_page(
        'mcsm_menu_info_page',
        '',
        'Clients',
        'manage_options',
        'edit.php?post_type=mcsm_clients'
    );
    
    add_submenu_page(
        'mcsm_menu_info_page',
        '',
        'Publications',
        'manage_options',
        'edit.php?post_type=mcsm_publications'
    );
    
    add_submenu_page(
        'mcsm_menu_info_page',
        '',
        'Submitted Material',
        'manage_options',
        'edit.php?post_type=mcsm_sm'
    );
    
    add_submenu_page(
        'mcsm_menu_info_page',
        '',
        'Press Releases',
        'manage_options',
        'edit.php?post_type=mcsm_press_releases'
    );
    
    add_submenu_page(
        'mcsm_menu_info_page',
        '',
        'Options',
        'manage_options',
        'mcsm_options_page',
        'mcsm_options_page'
    );

}

?>