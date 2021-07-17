<?php

add_action('init','register_tiers');

function register_tiers(){
    
    $args = array(
        'hierarchical' => true,
        'query_var' => 'client_tiers', 
        'rewrite' => false,
        'labels' => array(
            'name' => 'Clients Tiers',
            'singular_name' => 'Clients Tiers',
            'edit_item' => 'Edit Tiers',
            'update_item' => 'Update Tiers',
            'add_new_item' => 'Add New Client Tiers',
            'new_item_name' => 'New Client Tiers',
            'all_items' => 'All Tiers',
            'search_items' => 'Search Tiers',
            'separate_items_with_commas' => 'Separate tiers with commas',
            'add_or_remove_items' => 'Add or remove tiers'
        ),
    );
    
    register_taxonomy('tiers','mcsm_publications',$args);
}

add_action('admin_init','create_category');

function create_category(){
    
    $clients = new WP_Query(array(
        'post_type' => 'mcsm_clients',
        'posts_per_page' => -1
    ));
    
    while($clients->have_posts()){
        $clients->the_post();
        
        $tiers_client = get_post_meta(get_the_ID(),'mcsm_client',true); 
        
        wp_insert_term(
            $tiers_client,
            'tiers'
        );
        
        $parent_tier_id = term_exists($tiers_client,'tiers');
        $client_shortcut = get_post_meta(get_the_ID(),'mcsm_shortcut',true);
        
        for($i=1; $i<4; $i++){
            
            wp_insert_term(
                $client_shortcut . ' Tier ' . $i,
                'tiers',
                array(
                    'parent' => $parent_tier_id['term_id']
                )
            );
            
        }
        
    }

}

?>