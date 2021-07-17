<?php

add_action('add_meta_boxes_mcsm_clients','mcsm_add_client_metaboxes');

function mcsm_add_client_metaboxes($post){
    add_meta_box(
        'mcsm-client-details', //ID
        'Client Details', //Title
        'mcsm_client_metabox', //Callback Function
        'mcsm_clients', //Post-Type Name
        'normal',//Context (wo innhalb des Screens die Box angezeigt werden soll)
        'default'//Priority
    );
}

function mcsm_client_metabox(){
    global $post;
    
    $post_id = $post->ID;
    
    $nonce = wp_nonce_field(basename(__FILE__),'mcsm_clients_fields_nonce');
    
    $client = (!empty(get_post_meta($post_id, 'mcsm_client', true))) ? get_post_meta($post_id, 'mcsm_client',true) : '';
    $shortcut = (!empty(get_post_meta($post_id, 'mcsm_shortcut',true))) ? get_post_meta($post_id, 'mcsm_shortcut',true) : '';
    
?>

    <p>
        <label>Client</label>
        <input type="text" name="mcsm_client" required="required" class="widefat" value="<?php echo $client;?>">
    </p>

    <p>
        <label>Shortcut</label>
        <input type="text" name="mcsm_shortcut" required="required" class="widefat" value="<?php echo $shortcut;?>">
    </p>

<?php

}


add_action('save_post','mcsm_save_mcsm_clients_meta',10,2);

function mcsm_save_mcsm_clients_meta($post_id,$post){
     if(!isset($_POST['mcsm_clients_fields_nonce']) || !wp_verify_nonce($_POST['mcsm_clients_fields_nonce'], basename(__FILE__))){
         return $post_id;
     }
     $post_type = get_post_type_object($post->post_type);
    
    if(!current_user_can($post_type->cap->edit_post, $post_id)){
        return $post_id;
    }
    
    $client =   (isset($_POST['mcsm_client'])) ? sanitize_text_field($_POST['mcsm_client']) : '';
    $shortcut =    (isset($_POST['mcsm_shortcut'])) ? sanitize_text_field($_POST['mcsm_shortcut']) : '';
            
    update_post_meta($post_id,'mcsm_client',$client);
    update_post_meta($post_id,'mcsm_shortcut',$shortcut);
    
}

?>