<?php

add_action('add_meta_boxes_mcsm_sm','mcsm_add_sm_metaboxes');

function mcsm_add_sm_metaboxes($post){
    add_meta_box(
        'mcsm-sm-details', //ID
        'Submitted Material Details', //Title
        'mcsm_sm_metabox', //Callback Function
        'mcsm_sm', //Post-Type Name
        'normal',//Context (wo innhalb des Screens die Box angezeigt werden soll)
        'default'//Priority
    );
}

function mcsm_sm_metabox(){
    global $post;
    $post_id = $post->ID;
    
    $nonce = wp_nonce_field(basename(__FILE__),'mcsm_sm_fields_nonce');
    
    $clients = new WP_Query(array(
        'post_type' => 'mcsm_clients',
        'posts_per_page' => -1
    ));
    
    $client = (!empty(get_post_meta($post_id, 'mcsm_client', true))) ? get_post_meta($post_id, 'mcsm_client',true) : '';
    $title = (!empty(get_post_meta($post_id, 'mcsm_title',true))) ? get_post_meta($post_id, 'mcsm_title',true) : '';
    $author = (!empty(get_post_meta($post_id, 'mcsm_author',true))) ? get_post_meta($post_id, 'mcsm_author',true) : '';
    $kind = (!empty(get_post_meta($post_id, 'mcsm_kind',true))) ? get_post_meta($post_id, 'mcsm_kind',true) : '';
    $date = (!empty(get_post_meta($post_id, 'mcsm_date',true))) ? get_post_meta($post_id, 'mcsm_date',true) : '';
    
    $countries = get_option('mcsm_countries_option');
    $single_countries = explode(',',$countries);
    
    foreach($single_countries as $country){
        $country_clean = trim(strtolower($country));
        ${$country_clean} = (!empty(get_post_meta($post_id, 'mcsm_' . $country_clean, true))) ? get_post_meta($post_id, 'mcsm_' . $country_clean, true) : '';
    }
        
?>

    <p>
        <label>Client</label>
        <select name="mcsm_client" required="required" class="widefat">
        
        <?php
            while($clients->have_posts()){
                $clients->the_post(); 
                $current_client = get_post_meta(get_the_ID(),'mcsm_client',true); ?>
                <option <?php echo ($current_client == $client) ? 'selected' : '';?>><?php echo $current_client?></option>
            <?php }
        ?>
        
        </select>
    </p>

    <p>
        <label>Title</label>
        <input type="text" name="mcsm_title" required="required" class="widefat" value="<?php echo $title;?>">
    </p>

    <p>
        <label>Author</label>
        <input type="text" name="mcsm_author" required="required" class="widefat" value="<?php echo $author;?>">
    </p>

    <p>
        <label>Kind</label>
        <select name="mcsm_kind" class="widefat">
            <option <?php echo($kind == 'Article') ? 'selected="selected"' : '';?>>Article</option>
            <option <?php echo($kind == 'Case Study') ? 'selected="selected"' : '';?>>Case Study</option>
            <option <?php echo($kind == 'White Paper') ? 'selected="selected"' : '';?>>White Paper</option>
            <option <?php echo($kind == 'Comment') ? 'selected="selected"' : '';?>>Comment</option>
        </select>
    </p>

    <p>
        <label>Date</label>
        <input type="text" name="mcsm_date" id="mcsm_date" required="required" class="widefat" value="<?php echo $date;?>">
    </p>

    <p>
        <label>Published in</label><br>
        
        <?php
        
        foreach($single_countries as $country){
            echo trim($country) ?> <input type="checkbox" name="<?php echo 'mcsm_' . trim(strtolower($country));?>" value="true" <?php echo (${trim(strtolower($country))} == 'true') ? "checked='checked'" : ''; ?>>    
        <?php }
        
        ?>
        
    </p>

<?php

}

add_action('save_post','mcsm_save_mcsm_sm_meta',10,2);

function mcsm_save_mcsm_sm_meta($post_id,$post){
     if(!isset($_POST['mcsm_sm_fields_nonce']) || !wp_verify_nonce($_POST['mcsm_sm_fields_nonce'], basename(__FILE__))){
         return $post_id;
     }
     $post_type = get_post_type_object($post->post_type);
    
    if(!current_user_can($post_type->cap->edit_post, $post_id)){
        return $post_id;
    }
    
    $client =   (isset($_POST['mcsm_client'])) ? sanitize_text_field($_POST['mcsm_client']) : '';
    $title =    (isset($_POST['mcsm_title'])) ? sanitize_text_field($_POST['mcsm_title']) : '';
    $author =    (isset($_POST['mcsm_author'])) ? sanitize_text_field($_POST['mcsm_author']) : '';
    $kind =    (isset($_POST['mcsm_kind'])) ? sanitize_text_field($_POST['mcsm_kind']) : '';
    $date =    (isset($_POST['mcsm_date'])) ? sanitize_text_field($_POST['mcsm_date']) : '';
    
    $countries = get_option('mcsm_countries_option');
    $single_countries = explode(',',$countries);
    
    foreach($single_countries as $country){
        $country_clean = trim(strtolower($country));
        ${$country_clean} = (isset($_POST['mcsm_' . $country_clean])) ? sanitize_text_field($_POST['mcsm_' . $country_clean]) : '';
        
        update_post_meta($post_id,'mcsm_' . trim(strtolower($country)),${$country_clean});
    }
    
    update_post_meta($post_id,'mcsm_client',$client);
    update_post_meta($post_id,'mcsm_title',$title);
    update_post_meta($post_id,'mcsm_author',$author);
    update_post_meta($post_id,'mcsm_kind',$kind);
    update_post_meta($post_id,'mcsm_date',$date);
    
}

?>