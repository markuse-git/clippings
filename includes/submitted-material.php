<?php

add_action('init', 'mcsm_mcsm_sm_register_post_types');

function mcsm_mcsm_sm_register_post_types(){
    
    $mcsm_sm_args = array(
        'public' => true,
        'query_var' => 'mcsm_sm',
        'show_in_menu' => false,
        'rewrite' => array(
            'slug' => 'mcsm_sm',
            'with_front' => false
        ),
        'show_in_rest' => true,
        'supports' => array(''),
        'labels' => array(
            'name' => 'Submitted Material',
            'singular_name' => 'Submitted Material',
            'add_new' => 'Add New Submitted Material',
            'add_new_item' => 'Add New Submitted Material',
            'edit_item' => 'Edit Submitted Material',
            'new_item' => 'New Submitted Material',
            'view_item' => 'View Submitted Material',
            'search_items' => 'Search Submitted Material',
            'not_found' => 'No Submitted Material found',
            'not_found_in_trash' => 'No Submitted Material found in Trash'
        ),
        'menu_icon' => 'dashicons-businessman'
    );
    register_post_type('mcsm_sm',$mcsm_sm_args);
}

//--------------Custom Admin Columns-----------------------------------------

add_filter('manage_edit-mcsm_sm_columns', 'mcsm_mcsm_sm_column_headers');
add_filter('manage_mcsm_sm_posts_custom_column','mcsm_mcsm_sm_column_data', 1,2);
add_action('admin_head-edit.php','mcsm_register_custom_mcsm_sm_titles');

function mcsm_mcsm_sm_column_headers($columns){
    $columns = array(
        'cb' => '<input type="checkbox">',
        'title' => __('Title'),
        'client' => __('Client'),
        'kind' => __('Kind'),
        'dte' => __('Date')
    );
    return $columns;
}

function mcsm_mcsm_sm_column_data($column, $post_id){
    $output = '';
    
    switch($column){
        case 'client':
            $client = get_post_meta($post_id,'mcsm_client',true);
            $output .= $client;
            break;
        case 'title':
            $name = get_post_meta($post_id,'mcsm_title',true);
            $output .= $name;
            break;
        case 'kind':
            $kind = get_post_meta($post_id,'mcsm_kind',true);
            $output .= $kind;
            break;
        case 'dte':
            $date = get_post_meta($post_id,'mcsm_date',true);
            $output .= $date;
            break;
    }
    echo $output;
}

function mcsm_register_custom_mcsm_sm_titles(){
    add_filter(
        'the_title',
        'mcsm_mcsm_sm_custom_admin_titles',
        99,
        2
    );
}

function mcsm_mcsm_sm_custom_admin_titles($title,$post_id){
    global $post;
    $output = $title;
    if(isset($post->post_type)){
        switch($post->post_type){
            case 'mcsm_sm':
                $name = get_post_meta($post_id,'mcsm_title',true);
                $output = $name;
                break;
        }
    }
    return $output;
}

?>