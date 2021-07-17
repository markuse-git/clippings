<?php

/*
Plugin Name: Clippings
Description: Organizes client's clippings and generates reports
Version: 1.0
Author: Markus Eichelhardt
License: GLP2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

require __DIR__ . '/includes/shortcode.php';
require __DIR__ . '/includes/clients.php';
require __DIR__ . '/includes/clients-fields.php';
require __DIR__ . '/includes/publications.php';
require __DIR__ . '/includes/publications-fields.php';
require __DIR__ . '/includes/publications-tax.php';
require __DIR__ . '/includes/submitted-material.php';
require __DIR__ . '/includes/submitted-material-fields.php';
require __DIR__ . '/includes/press-releases.php';
require __DIR__ . '/includes/press-releases-fields.php';
require __DIR__ . '/includes/search-clippings-route.php';
require __DIR__ . '/includes/search-sma-route.php';
require __DIR__ . '/includes/plugin-menu.php';

define('MCSM_INSERT_JS', plugin_dir_url(__FILE__).'js');
define('MCSM_INSERT_CSS', plugin_dir_url(__FILE__).'styles');

add_action('wp_enqueue_scripts','mcsm_plugin_files');

function mcsm_plugin_files(){
    wp_enqueue_script('tools_menu_js',MCSM_INSERT_JS.'/tools-menu.js',array('jquery'),'',true);
    wp_enqueue_script('sm_menu',MCSM_INSERT_JS.'/sm-menu.js',array('jquery'),'',true);
    wp_enqueue_script('fields_and_alerts_js',MCSM_INSERT_JS.'/fields-and-alerts.js',array('jquery'),'',true);
    wp_enqueue_script('search_clippings_js',MCSM_INSERT_JS.'/search-clippings.js',array('jquery'),'',true);
    wp_enqueue_script('search_sma_js',MCSM_INSERT_JS.'/search-sma.js',array('jquery'),'',true);
    wp_enqueue_script('jquery-ui-datepicker');
    
    wp_enqueue_style('uni-style',MCSM_INSERT_CSS.'/uni-style.css');
    
    wp_localize_script('search_clippings_js','searchClippings',array(
        'root_url' => get_site_url()
    ));
    
    wp_localize_script('search_sma_js','searchSma',array(
        'root_url' => get_site_url()
    ));
}

add_action('admin_enqueue_scripts','mcsm_admin_scripts');

function mcsm_admin_scripts(){
    wp_register_script('mcsm-plugin-menu', plugins_url('/js/plugin-menu.js',__FILE__), array('jquery'),'',true);    
    wp_enqueue_script('mcsm-plugin-menu');
    wp_register_script('fields_and_alerts_js',MCSM_INSERT_JS.'/fields-and-alerts.js',array('jquery'),'',true);
    wp_enqueue_script('fields_and_alerts_js');
    wp_enqueue_script('jquery-ui-datepicker');
}

?>