<?php

add_action('init', 'mcsm_press_releases_register_post_types');

function mcsm_press_releases_register_post_types(){
    
    $press_releases_args = array(
        'public' => true,
        'query_var' => 'press_releases',
        'show_in_menu' => false,
        'rewrite' => array(
            'slug' => 'press_releases',
            'with_front' => false
        ),
        'show_in_rest' => true,
        'supports' => array(''),
        'labels' => array(
            'name' => 'Press Releases',
            'singular_name' => 'Press Release',
            'add_new' => 'Add New Press Release',
            'add_new_item' => 'Add New Press Release',
            'edit_item' => 'Edit Press Release',
            'new_item' => 'New Press Release',
            'view_item' => 'View Press Release',
            'search_items' => 'Search Press Releases',
            'not_found' => 'No Press Releases found',
            'not_found_in_trash' => 'No Press Releases found in Trash'
        ),
        'menu_icon' => 'dashicons-businessman'
    );
    register_post_type('mcsm_press_releases',$press_releases_args);
}

add_filter('manage_edit-mcsm_press_releases_columns', 'mcsm_press_releases_column_headers');
add_filter('manage_mcsm_press_releases_posts_custom_column','mcsm_press_releases_column_data', 1,2);
add_filter('admin_head-edit.php','mcsm_register_custom_press_releases_titles');

function mcsm_press_releases_column_headers($columns){
    $columns = array(
        'cb' => '<input type="checkbox">',
        'title' => __('Title'),
        'client' => __('Client'),
        'dte' => __('Published')
    );
    return $columns;
}

function mcsm_press_releases_column_data($column, $post_id){
    $output = '';
    
    switch($column){
        case 'title':
            $name = get_post_meta($post_id,'mcsm_press_release',true);
            $output .= $name;
            break;
        case 'client':
            $client = get_post_meta($post_id,'mcsm_pr_client',true);
            $output .= $client;
            break;
        case 'dte':
            $date = get_post_meta($post_id,'mcsm_pr_date',true);
            $output .= $date;
            break;
    }
    echo $output;
}

function mcsm_register_custom_press_releases_titles(){
    add_filter(
        'the_title',
        'mcsm_press_releases_custom_admin_titles',
        99,
        2
    );
}

function mcsm_press_releases_custom_admin_titles($title,$post_id){
    global $post;
    $output = $title;
    if(isset($post->post_type)){
        switch($post->post_type){
            case 'mcsm_press_releases':
                $name = get_post_meta($post_id,'mcsm_press_release',true);
                $output = $name;
                break;
        }
    }
    return $output;
}

?>