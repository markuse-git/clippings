<?php

if(!defined('WP_UNINSTALL_PLUGIN')){
    exit();
}

// DELETE OPTIONS
delete_option('mcsm_email_option');
delete_option('mcsm_countries_option');
delete_option('mcsm_article_option');
delete_option('mcsm_caseStudy_option');
delete_option('mcsm_comment_option');
delete_option('mcsm_news_option');
delete_option('mcsm_quote_option');
delete_option('mcsm_nameCheck_option');
delete_option('mcsm_ranking_option');
delete_option('mcsm_test_option');

// REMOVE TABLES
    global $wpdb;
    
    try{
        $table_name = $wpdb->prefix . 'entries';
        
        $wpdb->query("DROP TABLE IF EXISTS {$table_name}");
    } catch(Exception $e){
        
    }
    
// REMOVE POST DATA
    global $wpdb;
        
    try{
        $table_name = $wpdb->prefix . 'posts';
        
        $custom_post_types = array(
            'mcsm_clients',
            'mcsm_publications',
            'mcsm_sm',
            'mcsm_press_releases'
        );
        
        $wpdb->query(
            $wpdb->prepare(
            "
                DELETE FROM $table_name
                WHERE post_type = %s OR post_type = %s OR post_type = %s OR post_type = %s
            ",
            $custom_post_types[0],
            $custom_post_types[1],
            $custom_post_types[2],
            $custom_post_types[3],
            )
        );
        
        $table_name_1 = $wpdb->prefix . 'postmeta';
        $table_name_2 = $wpdb->prefix . 'posts';
        
        $wpdb->query(
            $wpdb->prepare(
                "
                    DELETE pm
                    FROM $table_name_1 pm
                    LEFT JOIN $table_name_2 wp ON wp.ID = pm.post_id
                    WHERE wp.ID IS NULL
                "
            )
        );
    } catch(Exception $e){
        
    }
      
?>