<?php

add_action('init', 'mcsm_clients_register_post_types');

function mcsm_clients_register_post_types(){
    
    $clients_args = array(
        'public' => true,
        'query_var' => 'clients',
        'show_in_menu' => false,
        'rewrite' => array(
            'slug' => 'clients',
            'with_front' => false
        ),
        'show_in_rest' => true,
        'supports' => array(''),
        'labels' => array(
            'name' => 'Clients',
            'singular_name' => 'Client',
            'add_new' => 'Add New Client',
            'add_new_item' => 'Add New Client',
            'edit_item' => 'Edit Client',
            'new_item' => 'New Client',
            'view_item' => 'View Client',
            'search_items' => 'Search Clients',
            'not_found' => 'No Client found',
            'not_found_in_trash' => 'No Client found in Trash'
        ),
        'menu_icon' => 'dashicons-businessman'
    );
    register_post_type('mcsm_clients',$clients_args);
}

//--------------Custom Admin Columns-----------------------------------------

add_filter('manage_edit-mcsm_clients_columns', 'mcsm_clients_column_headers');
add_filter('manage_mcsm_clients_posts_custom_column','mcsm_clients_column_data',1,2);
add_action('admin_head-edit.php','mcsm_register_custom_clients_titles');

function mcsm_clients_column_headers($columns){
    $columns = array(
        'cb' => '<input type="checkbox">',
        'title' => __('Client Name'),
        'shortcut' => __('Shortcut')
    );
    return $columns;
}

function mcsm_clients_column_data($column, $post_id){
    $output = '';
    
    switch($column){
        case 'title':
            $name = get_post_meta($post_id,'mcsm_client',true);
            $output .= $name;
            break;
        case 'shortcut':
            $shortcut = get_post_meta($post_id,'mcsm_shortcut',true);
            $output .= $shortcut;
            break;
    }
    echo $output;
}

function mcsm_register_custom_clients_titles(){
    add_filter(
        'the_title',
        'mcsm_clients_custom_admin_titles',
        99,
        2
    );
}

function mcsm_clients_custom_admin_titles($title,$post_id){
    global $post;
    $output = $title;
    if(isset($post->post_type)){
        switch($post->post_type){
            case 'mcsm_clients':
                $name = get_post_meta($post_id,'mcsm_client',true);
                $output = $name;
                break;
        }
    }
    return $output;
}

?>