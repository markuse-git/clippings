<?php

add_action('rest_api_init','registerSearch');

function registerSearch(){
    register_rest_route('clippings/v1','search', array(
        'methods' => WP_REST_SERVER::READABLE, // Umfasst POST und GET, etc.
        'callback' => 'mcsm_searchResults'
    ));
}

function mcsm_searchResults($data){
    
    global $wpdb;
    
    $clippings_search_sql = 'SELECT * FROM ' . $wpdb->prefix . 'entries
    WHERE title LIKE "%' . $data['term'] . '%"
    OR client LIKE "%' . $data['term'] . '%"
    OR publication LIKE "%' . $data['term'] . '%"
    OR date LIKE "%' . $data['term'] . '%"
    OR kind LIKE "%' . $data['term'] . '%"';
    
    $entries = $wpdb->get_results($clippings_search_sql);
    
    $results = [];
    
    foreach($entries as $entry){
        
        array_push($results,array(
            'client' => $entry->client,
            'publication' => $entry->publication,
            'title' => $entry->title,
            'kind' => $entry->kind,
            'date' => explode(' ', $entry->date)[0]
        ));
    
    }
    
    return $results;

}

?>