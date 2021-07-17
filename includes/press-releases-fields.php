<?php

add_action('add_meta_boxes_mcsm_press_releases','mcsm_add_press_release_metaboxes');

function mcsm_add_press_release_metaboxes($post){
    add_meta_box(
        'mcsm-press_release-details', //ID
        'Client Details', //Title
        'mcsm_press_release_metabox', //Callback Function
        'mcsm_press_releases', //Post-Type Name
        'normal',//Context (wo innhalb des Screens die Box angezeigt werden soll)
        'default'//Priority
    );
}

function mcsm_press_release_metabox(){
    global $post;
    $post_id = $post->ID;
    
    $nonce = wp_nonce_field(basename(__FILE__),'mcsm_press_releases_fields_nonce');
    
    $press_release = (!empty(get_post_meta($post_id, 'mcsm_press_release', true))) ? get_post_meta($post_id, 'mcsm_press_release',true) : '';
    $client = (!empty(get_post_meta($post_id, 'mcsm_pr_client',true))) ? get_post_meta($post_id, 'mcsm_pr_client',true) : '';
    $date = (!empty(get_post_meta($post_id, 'mcsm_pr_date',true))) ? get_post_meta($post_id, 'mcsm_pr_date',true) : '';
    
    $clients = new WP_Query(array(
        'post_type' => 'mcsm_clients',
        'posts_per_page' => -1
    ));
    
?>

    <p>
        <label>Release Title</label>
        <input type="text" name="mcsm_press_release" required="required" class="widefat" value="<?php echo $press_release;?>">
    </p>

    <p>
        <label>Client</label>
        <select name="mcsm_pr_client" required="required" class="widefat">
            
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
        <label>Release Date</label>
        <input type="text" name="mcsm_pr_date" id="mcsm_pr_date" required="required" class="widefat" value="<?php echo $date;?>">
    </p>

<?php

}


add_action('save_post','mcsm_save_mcsm_press_releases_meta',10,2);

function mcsm_save_mcsm_press_releases_meta($post_id,$post){
     if(!isset($_POST['mcsm_press_releases_fields_nonce']) || !wp_verify_nonce($_POST['mcsm_press_releases_fields_nonce'], basename(__FILE__))){
         return $post_id;
     }
     $post_type = get_post_type_object($post->post_type);
    
    if(!current_user_can($post_type->cap->edit_post, $post_id)){
        return $post_id;
    }
    
    $press_release =   (isset($_POST['mcsm_press_release'])) ? sanitize_text_field($_POST['mcsm_press_release']) : '';
    $client =    (isset($_POST['mcsm_pr_client'])) ? sanitize_text_field($_POST['mcsm_pr_client']) : '';
    $date =    (isset($_POST['mcsm_pr_date'])) ? sanitize_text_field($_POST['mcsm_pr_date']) : '';
            
    update_post_meta($post_id,'mcsm_press_release',$press_release);
    update_post_meta($post_id,'mcsm_pr_client',$client);
    update_post_meta($post_id,'mcsm_pr_date',$date);
    
}

?>