<?php

function mcsm_menu_info_page(){
    $output = '
        <div class="wrap">
            
            <h2>Clippings</h2>
            
            <h4>The ok Clippings Organizing plugin for WordPress.</h4>
            
            <p>
                <ol>
                    <li>
                        First, go to the plugins options page and provide at least one email address to 
                        send reports to. Please also define the countries you want to monitor. Finally, evaluate
                        the different kinds of clippings with points from 1 to 5. This will be relevant when
                        the result of a generated report is evaluated by a total score.
                    </li>
                    <li>
                        Next, create Clients and Publications and, if available, Submitted Material and Press Releases.
                        You can also define the publication as a tier publication for one or more of your clients
                        by attaching the according category to the publication post. This will again be relevant
                        for calculating a overall score in a generated report. 
                    </li>
                    <li>
                        Put the shortcode [add_clippings] on the page via which you want to add clippings to the database.
                    </li>
                </ol>
            </p>
        
        </div>
    ';
    
    echo $output;
}

?>