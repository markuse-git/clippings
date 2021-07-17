<?php

add_action('init', 'mcsm_publications_register_post_types');

function mcsm_publications_register_post_types(){
    
    $publications_args = array(
        'public' => true,
        'query_var' => 'publications',
        'show_in_menu' => false,
        'rewrite' => array(
            'slug' => 'publications',
            'with_front' => false
        ),
        'show_in_rest' => true,
        'supports' => array(''),
        'labels' => array(
            'name' => 'Publications',
            'singular_name' => 'Publication',
            'add_new' => 'Add New Publication',
            'add_new_item' => 'Add New Publication',
            'edit_item' => 'Edit Publication',
            'new_item' => 'New Publication',
            'view_item' => 'View Publication',
            'search_items' => 'Search Publications',
            'not_found' => 'No Publication found',
            'not_found_in_trash' => 'No Publication found in Trash'
        ),
        'menu_icon' => 'dashicons-businessman'
    );
    register_post_type('mcsm_publications',$publications_args);
}

add_filter('manage_edit-mcsm_publications_columns', 'mcsm_publications_column_headers');
add_filter('manage_mcsm_publications_posts_custom_column','mcsm_publications_column_data', 1,2);
add_filter('admin_head-edit.php','mcsm_register_custom_publications_titles');

function mcsm_publications_column_headers($columns){
    $columns = array(
        'cb' => '<input type="checkbox">',
        'title' => __('Publication'),
        'category' => __('Category'),
        'circulation' => __('Circulation'),
        'frequency' => __('Frequency')
    );
    return $columns;
}

function mcsm_publications_column_data($column, $post_id){
    $output = '';
    
    switch($column){
        case 'title':
            $name = get_post_meta($post_id,'mcsm_publication',true);
            $output .= $name;
            break;
        case 'category':
            $category = get_post_meta($post_id,'mcsm_category',true);
            $output .= $category;
            break;
        case 'circulation':
            $circulation = get_post_meta($post_id,'mcsm_circulation',true);
            $output .= $circulation;
            break;
        case 'frequency':
            $frequency = get_post_meta($post_id,'mcsm_frequency',true);
            $output .= $frequency;
            break;
    }
    echo $output;
}

function mcsm_register_custom_publications_titles(){
    add_filter(
        'the_title',
        'mcsm_publications_custom_admin_titles',
        99,
        2
    );
}

function mcsm_publications_custom_admin_titles($title,$post_id){
    global $post;
    $output = $title;
    if(isset($post->post_type)){
        switch($post->post_type){
            case 'mcsm_publications':
                $name = get_post_meta($post_id,'mcsm_publication',true);
                $output = $name;
                break;
        }
    }
    return $output;
}

?>