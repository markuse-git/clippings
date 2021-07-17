<?php

function mcsm_options_page(){ ?>

    <div class="wrap">
        <h2>Options</h2>
        <?php settings_errors();?>
        <form action="options.php" method="post">
            
            <?php settings_fields('mcsm_general_group'); ?>
            <?php do_settings_sections('mcsm_options_admin_page'); ?>
            
            <?php submit_button();?>
        </form>
    </div>

<?php }

// Register and define the settings
add_action('admin_init', 'mcsm_settings_init');

function mcsm_settings_init(){
    register_setting(
        'mcsm_general_group',
        'mcsm_email_option'
    );
    register_setting(
        'mcsm_general_group',
        'mcsm_countries_option'
    );
    register_setting(
        'mcsm_general_group', 
        'mcsm_article_option'
    );
    register_setting(
        'mcsm_general_group', 
        'mcsm_caseStudy_option'
    );
    register_setting(
        'mcsm_general_group', 
        'mcsm_comment_option'
    );
    register_setting(
        'mcsm_general_group', 
        'mcsm_news_option'
    );
    register_setting(
        'mcsm_general_group', 
        'mcsm_quote_option'
    );
    register_setting(
        'mcsm_general_group', 
        'mcsm_nameCheck_option'
    );
    register_setting(
        'mcsm_general_group', 
        'mcsm_ranking_option'
    );
    register_setting(
        'mcsm_general_group', 
        'mcsm_test_option'
    );
    
    //Sections
    
    add_settings_section(
        'mcsm_settings_general',
        'General Settings',
        'mcsm_general_section_text',
        'mcsm_options_admin_page'
    );
    add_settings_section(
        'mcsm_settings_evaluation',
        'Clippings Kind Evaluation',
        'mcsm_evaluation_section_text',
        'mcsm_options_admin_page'
    );
    
    //Fields
        
    add_settings_field(
        'mcsm_email_option',
        'Email Adresses',
        'mcsm_email_input',
        'mcsm_options_admin_page',
        'mcsm_settings_general'
    );
    add_settings_field(
        'mcsm_countries_option',
        'Countries to monitor',
        'mcsm_countries_input',
        'mcsm_options_admin_page',
        'mcsm_settings_general'
    );
    add_settings_field(
        'mcsm_article_option',
        'Article',
        'mcsm_article_input',
        'mcsm_options_admin_page',
        'mcsm_settings_evaluation'
    );
    add_settings_field(
        'mcsm_caseStudy_option',
        'Case Study',
        'mcsm_caseStudy_input',
        'mcsm_options_admin_page',
        'mcsm_settings_evaluation'
    );
    add_settings_field(
        'mcsm_comment_option',
        'Comment',
        'mcsm_comment_input',
        'mcsm_options_admin_page',
        'mcsm_settings_evaluation'
    );
    add_settings_field(
        'mcsm_news_option',
        'News',
        'mcsm_news_input',
        'mcsm_options_admin_page',
        'mcsm_settings_evaluation'
    );
    add_settings_field(
        'mcsm_quote_option',
        'Quote',
        'mcsm_quote_input',
        'mcsm_options_admin_page',
        'mcsm_settings_evaluation'
    );
    add_settings_field(
        'mcsm_nameCheck_option',
        'Name Check',
        'mcsm_nameCheck_input',
        'mcsm_options_admin_page',
        'mcsm_settings_evaluation'
    );
    add_settings_field(
        'mcsm_ranking_option',
        'Ranking',
        'mcsm_ranking_input',
        'mcsm_options_admin_page',
        'mcsm_settings_evaluation'
    );
    add_settings_field(
        'mcsm_test_option',
        'Test',
        'mcsm_test_input',
        'mcsm_options_admin_page',
        'mcsm_settings_evaluation'
    );
        
}

// Section Texts
function mcsm_evaluation_section_text() {
    echo '<p>Rate types of clippings with points from 1 to 5</p>';
}

function mcsm_general_section_text() {
    echo '<p>You can enter multile values. Please separate with ",".</p>';
}


//Fields
function mcsm_email_input(){
    $email = get_option( 'mcsm_email_option' );
    echo "<input id='email' name='mcsm_email_option' size='50' type='email' value='$email' multiple/>";
}

function mcsm_countries_input(){
    $countries = get_option( 'mcsm_countries_option' );
    echo "<input id='countries' name='mcsm_countries_option' size='50' type='text' value='$countries' multiple/>";
}

function mcsm_article_input(){ 
    $options = get_option('mcsm_article_option'); 
    ?>

    1 <input type="radio" name="mcsm_article_option" value="1" <?php echo ($options == '1') ? 'checked' : 'unchecked';?>> 
    2 <input type="radio" name="mcsm_article_option" value="2" <?php echo ($options == '2') ? 'checked' : 'unchecked';?>> 
    3 <input type="radio" name="mcsm_article_option" value="3" <?php echo ($options == '3') ? 'checked' : 'unchecked';?>> 
    4 <input type="radio" name="mcsm_article_option" value="4" <?php echo ($options == '4') ? 'checked' : 'unchecked';?>> 
    5 <input type="radio" name="mcsm_article_option" value="5" <?php echo ($options == '5') ? 'checked' : 'unchecked';?>> 
    
<?php }

function mcsm_caseStudy_input(){ 
    $options = get_option('mcsm_caseStudy_option'); 
    ?>

    1 <input type="radio" name="mcsm_caseStudy_option" value="1" <?php echo ($options == '1') ? 'checked' : 'unchecked';?>> 
    2 <input type="radio" name="mcsm_caseStudy_option" value="2" <?php echo ($options == '2') ? 'checked' : 'unchecked';?>> 
    3 <input type="radio" name="mcsm_caseStudy_option" value="3" <?php echo ($options == '3') ? 'checked' : 'unchecked';?>> 
    4 <input type="radio" name="mcsm_caseStudy_option" value="4" <?php echo ($options == '4') ? 'checked' : 'unchecked';?>> 
    5 <input type="radio" name="mcsm_caseStudy_option" value="5" <?php echo ($options == '5') ? 'checked' : 'unchecked';?>> 
    
<?php }

function mcsm_comment_input(){ 
    $options = get_option('mcsm_comment_option'); 
    ?>

    1 <input type="radio" name="mcsm_comment_option" value="1" <?php echo ($options == '1') ? 'checked' : 'unchecked';?>> 
    2 <input type="radio" name="mcsm_comment_option" value="2" <?php echo ($options == '2') ? 'checked' : 'unchecked';?>> 
    3 <input type="radio" name="mcsm_comment_option" value="3" <?php echo ($options == '3') ? 'checked' : 'unchecked';?>> 
    4 <input type="radio" name="mcsm_comment_option" value="4" <?php echo ($options == '4') ? 'checked' : 'unchecked';?>> 
    5 <input type="radio" name="mcsm_comment_option" value="5" <?php echo ($options == '5') ? 'checked' : 'unchecked';?>> 
    
<?php }

function mcsm_news_input(){ 
    $options = get_option('mcsm_news_option'); 
    ?>

    1 <input type="radio" name="mcsm_news_option" value="1" <?php echo ($options == '1') ? 'checked' : 'unchecked';?>> 
    2 <input type="radio" name="mcsm_news_option" value="2" <?php echo ($options == '2') ? 'checked' : 'unchecked';?>> 
    3 <input type="radio" name="mcsm_news_option" value="3" <?php echo ($options == '3') ? 'checked' : 'unchecked';?>> 
    4 <input type="radio" name="mcsm_news_option" value="4" <?php echo ($options == '4') ? 'checked' : 'unchecked';?>> 
    5 <input type="radio" name="mcsm_news_option" value="5" <?php echo ($options == '5') ? 'checked' : 'unchecked';?>> 
    
<?php }

function mcsm_quote_input(){ 
    $options = get_option('mcsm_quote_option'); 
    ?>

    1 <input type="radio" name="mcsm_quote_option" value="1" <?php echo ($options == '1') ? 'checked' : 'unchecked';?>> 
    2 <input type="radio" name="mcsm_quote_option" value="2" <?php echo ($options == '2') ? 'checked' : 'unchecked';?>> 
    3 <input type="radio" name="mcsm_quote_option" value="3" <?php echo ($options == '3') ? 'checked' : 'unchecked';?>> 
    4 <input type="radio" name="mcsm_quote_option" value="4" <?php echo ($options == '4') ? 'checked' : 'unchecked';?>> 
    5 <input type="radio" name="mcsm_quote_option" value="5" <?php echo ($options == '5') ? 'checked' : 'unchecked';?>> 
    
<?php }

function mcsm_nameCheck_input(){ 
    $options = get_option('mcsm_nameCheck_option'); 
    ?>

    1 <input type="radio" name="mcsm_nameCheck_option" value="1" <?php echo ($options == '1') ? 'checked' : 'unchecked';?>> 
    2 <input type="radio" name="mcsm_nameCheck_option" value="2" <?php echo ($options == '2') ? 'checked' : 'unchecked';?>> 
    3 <input type="radio" name="mcsm_nameCheck_option" value="3" <?php echo ($options == '3') ? 'checked' : 'unchecked';?>> 
    4 <input type="radio" name="mcsm_nameCheck_option" value="4" <?php echo ($options == '4') ? 'checked' : 'unchecked';?>> 
    5 <input type="radio" name="mcsm_nameCheck_option" value="5" <?php echo ($options == '5') ? 'checked' : 'unchecked';?>> 
    
<?php }

function mcsm_ranking_input(){ 
    $options = get_option('mcsm_ranking_option'); 
    ?>

    1 <input type="radio" name="mcsm_ranking_option" value="1" <?php echo ($options == '1') ? 'checked' : 'unchecked';?>> 
    2 <input type="radio" name="mcsm_ranking_option" value="2" <?php echo ($options == '2') ? 'checked' : 'unchecked';?>> 
    3 <input type="radio" name="mcsm_ranking_option" value="3" <?php echo ($options == '3') ? 'checked' : 'unchecked';?>> 
    4 <input type="radio" name="mcsm_ranking_option" value="4" <?php echo ($options == '4') ? 'checked' : 'unchecked';?>> 
    5 <input type="radio" name="mcsm_ranking_option" value="5" <?php echo ($options == '5') ? 'checked' : 'unchecked';?>> 
    
<?php }

function mcsm_test_input(){ 
    $options = get_option('mcsm_test_option'); 
    ?>

    1 <input type="radio" name="mcsm_test_option" value="1" <?php echo ($options == '1') ? 'checked' : 'unchecked';?>> 
    2 <input type="radio" name="mcsm_test_option" value="2" <?php echo ($options == '2') ? 'checked' : 'unchecked';?>> 
    3 <input type="radio" name="mcsm_test_option" value="3" <?php echo ($options == '3') ? 'checked' : 'unchecked';?>> 
    4 <input type="radio" name="mcsm_test_option" value="4" <?php echo ($options == '4') ? 'checked' : 'unchecked';?>> 
    5 <input type="radio" name="mcsm_test_option" value="5" <?php echo ($options == '5') ? 'checked' : 'unchecked';?>> 
    
<?php }

?>