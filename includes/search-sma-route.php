<?php

add_action('rest_api_init','registerSMA');

function registerSMA(){
    register_rest_route('sma/v1','search', array(
        'methods' => WP_REST_SERVER::READABLE, // Umfasst POST und GET, etc.
        'callback' => 'mcsm_searchSMA'
    ));
}

function mcsm_searchSMA($data){
    
    $sma_results = [];
    
    function make_sma_query($ssr_post_id){
        
        $results = [];
    
        //alle SM (des Client), die nicht in allen Ländern erschienen sind
        
        $smaMetaQuery = array('relation' => 'OR');
        
        $countries = get_option('mcsm_countries_option');
        $single_countries = explode(',',$countries);
        
        foreach($single_countries as $country){
            array_push($smaMetaQuery, array(
                'key' => 'mcsm_' . trim(strtolower($country)),
                'value' => NULL,
                'compare' => '='
            ));
        }
        
        $smaQuery = new WP_Query(array(
            'post_type' => array('mcsm_sm'),
            'p' => $ssr_post_id,

            'meta_query' => $smaMetaQuery

        ));

        while($smaQuery->have_posts()){
            $smaQuery->the_post();
            
            $data = array(
                'client' => get_post_meta(get_the_ID(),'mcsm_client',true),
                'title' => get_post_meta(get_the_ID(),'mcsm_title',true)
            );
            
            foreach($single_countries as $country){
                $country_clean = trim(strtolower($country));
                $data[$country_clean] = get_post_meta(get_the_ID(),'mcsm_' . $country_clean,true);
            }
            
            array_push($results,$data);
            
        }
        
        return $results;
        
    }
    
    global $wpdb;
    
    $sma_sql = 'SELECT post_id FROM ' . $wpdb->prefix . 'postmeta
    WHERE meta_key LIKE "%mcsm_' . $data['term'] . '%"
    AND meta_value <> "true"
    OR (meta_key = "mcsm_client" 
    AND meta_value LIKE "%' . $data['term'] . '%")';
    
    $sma_sql_results = $wpdb->get_results($sma_sql);
    
    foreach($sma_sql_results as $ssr){
        
        $post_id_results = make_sma_query($ssr->post_id);
        
        foreach($post_id_results as $result){
            array_push($sma_results,$result);    
        }
        
    }
    
    $sma_results = array_values(array_unique($sma_results, SORT_REGULAR));
    
    return $sma_results;
}

?>