<?php

session_start();

add_shortcode('add_clippings','mcsm_add_clippings');

function mcsm_add_clippings(){ 

    $clients = new WP_Query(array(
        'post_type' => 'mcsm_clients',
        'posts_per_page' => -1
    ));
    
    $submitted_material = new WP_Query(array(
        'post_type' => 'mcsm_sm',
        'posts_per_page' => -1
    ));
    
    $sm_repository = [];
    
    while($submitted_material->have_posts()){
        $submitted_material->the_post();
        $client = get_post_meta(get_the_ID(),'mcsm_client',true);
        $sm_title = get_post_meta(get_the_ID(),'mcsm_title',true);
        $sm_repository[] = array($client => $sm_title); 
    }
    
    $publications = new WP_Query(array(
        'post_type' => 'mcsm_publications',
        'posts_per_page' => -1
    ));
    
?>

        <script>
            var sm_json = <?php echo json_encode($sm_repository);?>
        </script>

        <p class="success-message" id="clipping-success-message">
            The Clipping has successfully been added
        </p>

        <p class="success-message" id="report-success-message">
            A report has successfully been generated
        </p>

        <p>
            <button class="tooltip btn" id="mcsm_search_clippings">Clippings
                <span class="tooltiptext">click or press 's' to search for clippings</span>
            </button>
                    
            <button class="tooltip btn btn--orange" id="mcsm_sm_available">Submitted Material
                <span class="tooltiptext">click or press 'a' to search for available submitted material</span>
            </button>
        </p>

        <form method="post">
            
            <!--keep from refresh-->
            <?php
            $rand = rand();
            $_SESSION['rand'] = $rand;
            ?>
            
            <input type="hidden" value="<?php echo $rand;?>" name="randcheck">
            <!--Ende keep from refresh-->            
            
            <p>
                <label for="client">Client</label>
                <select name="client" id="client">
                    
                    <?php
                        while($clients->have_posts()){ 
                            $clients->the_post(); ?>
                            <option><?php echo get_post_meta(get_the_ID(),'mcsm_client',true);?></option>
                        <?php }
                    ?>
                    
                </select>
            </p>
            
            <p>
                <label for="publication">Publication</label>
                <select name="publication" id="publication">
                    
                    <?php
                        while($publications->have_posts()){
                            $publications->the_post(); ?>
                            <option><?php echo get_post_meta(get_the_ID(),'mcsm_publication',true);?></option>
                        <?php }
                    ?>
                    
                </select>
            </p>
            
            <p>
                <label for="title">Title*</label>
                <input name="title" id="title">
            </p>
            
            <p>
                <label for="kind">Kind</label>
                <select name="kind" id="kind">
                    <option>Article</option>
                    <option>Case Study</option>
                    <option>Comment</option>
                    <option>Name Check</option>
                    <option>News</option>
                    <option>Quote</option>
                    <option>Ranking</option>
                    <option>Test</option>
                    <option>Other</option>
                </select>
            </p>
            
            <p>
                <Label for="publication_date">Publication Date</label>
                <input name="publication_date" id="publication_date" value="<?php echo date("Y-m-d",time());?>">
            </p>
            
            <p>
                <label for="tool">Tool</label>
                <select name="tool" id="tool"></select>
            </p>
            
            <p class="submitted-material">
                <label for="submitted_material">Submitted Material</label>
                <select name="submitted_material" id="submitted_material">
                    <option>Please Choose</option>
                </select>
            </p>
                        
            <p><input type="submit" id="submit" name="submit" value="Add Clipping"></p>
            
        </form>

        <!--API SEARCH CLIPPINGS-->

        <div class="search-overlay">
            <div class="search-overlay__top">
                <div class="container">
                    <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                    <input type="text" class="search-term" placeholder="what are you looking for?" id="search-term">
                    <i id="close" class="fa fa-window-close search-overlay__close" aria-hidden="true">close</i>
                </div>
            </div>

            <div class="container">
                <div id="search-overlay__results">
                </div>
            </div>
        </div>

        <!--API SEARCH SMA-->

        <div class="sma-overlay">
            <div class="sma-overlay__top">
                <div class="container">
                    <i class="fa fa-search sma-overlay__icon" aria-hidden="true"></i>
                    <input type="text" class="sma-term" placeholder="Client or Country?" id="sma-term">
                    <i id="sma-close" class="fa fa-window-close sma-overlay__close" aria-hidden="true">close</i>
                </div>
            </div>

            <div class="container">
                <div id="sma-overlay__results">
                </div>
            </div>
        </div>

        <!--Create Report-->
        
        <p><button class="btn btn--small btn--orange" id="createReport">Create Report</button></p>

        <div id="report_form">
            <form method="post">
                
                <?php
                    $r_rand = rand();
                    $_SESSION['r_rand'] = $r_rand;
                ?>
                
                <input type="hidden" value="<?php echo $r_rand;?>" name="r_randcheck">

                <p><label for="report_client">Client</label>
                <select id="report_client" name="report_client">

                    <?php
                        while($clients->have_posts()){ 
                            $clients->the_post(); ?>
                            <option><?php echo get_post_meta(get_the_ID(),'mcsm_client',true);?></option>
                        <?php }
                    ?>

                </select></p>

                <p><label for="report_from">From</label>
                    <input name="report_from" id="report_from" value="<?php echo date("Y-m-d",time());?>"></p>

                <p><label for="report_to">To</label>
                    <input name="report_to" id="report_to" value="<?php echo date("Y-m-d",time());?>"></p>

                <p><input type="submit" name="report_submit" id="report_submit" value="Generate Report"></p>

            </form>
        </div>

<?php
    
    //-------------TESTBEREICH--------------------
    
    
    //------------ENDE Testbereich-----------------

}

//---------------Create Clippings Table-------------------

global $wpdb;

$mcsm_tablename = $wpdb->prefix . 'entries';

$mcsm_sql = "CREATE TABLE IF NOT EXISTS $mcsm_tablename(
    clipping_id INT(11) NOT NULL AUTO_INCREMENT,
    client VARCHAR(100) NOT NULL,
    publication VARCHAR(100) NOT NULL,
    title VARCHAR(200) NOT NULL,
    kind VARCHAR(50) NOT NULL,
    date DATETIME NOT NULL,
    tool VARCHAR (50) NOT NULL,
    submitted_material VARCHAR(200),
    country VARCHAR(120) NOT NULL,
    PRIMARY KEY(clipping_id)
);";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

dbDelta($mcsm_sql);

//---------------------Insert Clipping--------------------------

if(isset($_POST['submit']) && $_POST['randcheck'] == $_SESSION['rand']){
    
    $country_query = 'SELECT post_id 
    FROM ' . $wpdb->prefix . 'postmeta 
    WHERE meta_value = "'  . sanitize_text_field($_POST['publication']) . '" ';

    $country_results = $wpdb->get_results($country_query);
    $country_post_id = $country_results[0]->post_id;
    
    $country = get_post_meta($country_post_id,'mcsm_country',true);

    $mcsm_newdata = array(
        'client' => sanitize_text_field($_POST['client']),
        'publication' => sanitize_text_field($_POST['publication']),
        'title' => sanitize_text_field($_POST['title']),
        'kind' => sanitize_text_field($_POST['kind']),
        'date' => date('Y-m-d', strtotime(sanitize_text_field($_POST['publication_date']))),
        'tool' => sanitize_text_field($_POST['tool']),
        'submitted_material' => sanitize_text_field($_POST['submitted_material']),
        'country' => $country
    );
    
    $wpdb->insert(
        $mcsm_tablename,
        $mcsm_newdata
    );
    
    $rows_affected = $wpdb->rows_affected; 
    
    ?>    
    <script>
        var add_clipping = <?php echo json_encode($rows_affected);?>
    </script>
    <?php
    
    //Update von clipping/publication/country -> DB & sm Backend
    
    $post_id_sql = 'SELECT post_id FROM ' . $wpdb->prefix .  'postmeta 
        WHERE meta_key = "mcsm_title" 
        AND meta_value = "' . sanitize_text_field($_POST['submitted_material']) . '" ';

    $post_id_res = $wpdb->get_results($post_id_sql);
    if(!empty($post_id_res)){
        
        $current_posts_id = $post_id_res[0]->post_id;

        $wpdb->update(
            $wpdb->prefix . 'postmeta',
            array(
                'meta_value' => 'true'
            ),
            array(
                'meta_key' => 'mcsm_' . strtolower($country),
                'post_id' => $current_posts_id
            )
        );
        
    }
    
}

//--------------------Generate Report---------------------------

if(isset($_POST['report_submit']) && $_POST['r_randcheck'] == $_SESSION['r_rand']){
    include('report.php'); ?>

    <script>
        var add_report = <?php echo json_encode('ok');?>
    </script>

<?php }

?>