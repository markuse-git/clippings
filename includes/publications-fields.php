<?php

add_action('add_meta_boxes_mcsm_publications','mcsm_add_publications_metaboxes');

function mcsm_add_publications_metaboxes($post){
    add_meta_box(
        'mcsm-publications-details', //ID
        'Publication Details', //Title
        'mcsm_publications_metabox', //Callback Function
        'mcsm_publications', //Post-Type Name
        'normal',//Context (wo innhalb des Screens die Box angezeigt werden soll)
        'default'//Priority
    );
}

function mcsm_publications_metabox(){
    global $post;
    
    $post_id = $post->ID;
    
    $nonce = wp_nonce_field(basename(__FILE__),'mcsm_publications_fields_nonce');
    
    $publication = (!empty(get_post_meta($post_id, 'mcsm_publication', true))) ? get_post_meta($post_id, 'mcsm_publication',true) : '';
    $category = (!empty(get_post_meta($post_id, 'mcsm_category',true))) ? get_post_meta($post_id, 'mcsm_category',true) : '';
    $circulation = (!empty(get_post_meta($post_id, 'mcsm_circulation',true))) ? get_post_meta($post_id, 'mcsm_circulation',true) : '';
    $frequency = (!empty(get_post_meta($post_id, 'mcsm_frequency',true))) ? get_post_meta($post_id, 'mcsm_frequency',true) : '';
    $country = (!empty(get_post_meta($post_id, 'mcsm_country',true))) ? get_post_meta($post_id, 'mcsm_country',true) : '';
    
?>

    <p>
        <label>Publication</label>
        <input type="text" name="mcsm_publication" required="required" class="widefat" value="<?php echo $publication;?>">
    </p>

    <p>
        <label>Category</label>
        <select name="mcsm_category" id="mcsm_category" required="required" class="widefat">
            <option <?php echo($category == 'Networking') ? 'selected="selected"' : '';?>>Networking</option>
            <option <?php echo($category == 'General IT') ? 'selected="selected"' : '';?>>General IT</option>
            <option <?php echo($category == 'Business') ? 'selected="selected"' : '';?>>Business</option>
            <option <?php echo($category == 'Financial') ? 'selected="selected"' : '';?>>Financial</option>
            <option <?php echo($category == 'Channel') ? 'selected="selected"' : '';?>>Channel</option>
            <option <?php echo($category == 'Vertical') ? 'selected="selected"' : '';?>>Vertical</option>
        </select>
    </p>

    <p>
        <label>Circulation</label>
        <input type="text" name="mcsm_circulation" required="required" class="widefat" value="<?php echo $circulation;?>">
    </p>

    <p>
        <label>Frequency</label>
        <input type="text" name="mcsm_frequency" required="required" class="widefat" value="<?php echo $frequency;?>">
    </p>

    <p>
        <label>Country</label>
        <select name="mcsm_country" id="mcsm_country" required="required" class="widefat">
                        
            <?php
                $countries = get_option('mcsm_countries_option');
                $single_countries = explode(',',$countries);
    
                foreach($single_countries as $cntry){
                    $country_clean = trim($cntry); ?>
                    <option <?php echo($country == $country_clean) ? 'selected="selected"' : '';?>><?php echo $country_clean;?></option>
                <?php }
            ?>
            
        </select>
    </p>

<?php

}


add_action('save_post','mcsm_save_mcsm_publications_meta',10,2);

function mcsm_save_mcsm_publications_meta($post_id,$post){
     if(!isset($_POST['mcsm_publications_fields_nonce']) || !wp_verify_nonce($_POST['mcsm_publications_fields_nonce'], basename(__FILE__))){
         return $post_id;
     }
     $post_type = get_post_type_object($post->post_type);
    
    if(!current_user_can($post_type->cap->edit_post, $post_id)){
        return $post_id;
    }
    
    $publication =   (isset($_POST['mcsm_publication'])) ? sanitize_text_field($_POST['mcsm_publication']) : '';
    $category =    (isset($_POST['mcsm_category'])) ? sanitize_text_field($_POST['mcsm_category']) : '';
    $circulation =    (isset($_POST['mcsm_circulation'])) ? sanitize_text_field($_POST['mcsm_circulation']) : '';
    $frequency =    (isset($_POST['mcsm_frequency'])) ? sanitize_text_field($_POST['mcsm_frequency']) : '';
    $country =    (isset($_POST['mcsm_country'])) ? sanitize_text_field($_POST['mcsm_country']) : '';
            
    update_post_meta($post_id,'mcsm_publication',$publication);
    update_post_meta($post_id,'mcsm_category',$category);
    update_post_meta($post_id,'mcsm_circulation',$circulation);
    update_post_meta($post_id,'mcsm_frequency',$frequency);
    update_post_meta($post_id,'mcsm_country',$country);
    
}

?>