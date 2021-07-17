<?php

add_action('init','get_tier_publications',99);

function get_tier_publications(){  

    require __DIR__ . '/../fpdf/fpdf.php';

    // Titel
    class MyPDF extends FPDF{    
        function Header(){ 
            $this->SetFont("Helvetica","B",16);
            $this->Cell(0,20,"Clippings Report","B",1,"C"); 
            $this->Ln(); 
        }
    }

    //$path_option = get_option('mwta_path_option');
    $path_option = __DIR__ . '/../reports/';
    $email_option = get_option('mcsm_email_option');

    $pdf = new MyPDF();

    $pdf->AliasNbPages();
    $pdf->AddPage(); 
    $pdf->SetFont("Helvetica","",11);

    //Header
    $client = sanitize_text_field($_POST['report_client']);
    $from = sanitize_text_field($_POST['report_from']);
    $to = sanitize_text_field($_POST['report_to']);

    $pdf->Cell(50,5,"Client:",0,0,"L");
    $pdf->Cell(30,5,$client,0,0,"R"); 
    $pdf->Ln();
    $pdf->Cell(50,5,"From:",0,0,"L");
    $pdf->Cell(30,5,$from,0,0,"R");
    $pdf->Ln();
    $pdf->Cell(50,5,"To:",0,0,"L");
    $pdf->Cell(30,5,$to,0,0,"R");
    $pdf->Ln();

    //Clippings List SQL
    global $wpdb;

    $clippings_query = 'SELECT * FROM ' . $wpdb->prefix . 'entries
    WHERE client = "' . $client . '"
    AND date BETWEEN "' . date('Y-m-d', strtotime($from)) . '" AND "' . date('Y-m-d', strtotime($to)) . '"
    ORDER BY kind';

    $clippings_results = $wpdb->get_results($clippings_query);

    //Clippings List Titel und Head
    $pdf->SetFont("Helvetica","B",12);    

    $pdf->Ln();
    $pdf->Cell(50,15,"Clippings List",0,0,"L");     
    $pdf->Ln();    

    $pdf->Cell(40,5,"Publication",0,0,"L");
    $pdf->Cell(120,5,"Title",0,0,"L");
    $pdf->Cell(20,5,"Kind",0,0,"L");
    $pdf->Ln();

    //Clippings Data
    $pdf->SetFont("Helvetica","",11);

    //Matrix Data
    $article_1 = 0;
    $article_2 = 0;
    $article_3 = 0;
    $article_o = 0;

    $caseStudy_1 = 0;
    $caseStudy_2 = 0;
    $caseStudy_3 = 0;
    $caseStudy_o = 0;

    $comment_1 = 0;
    $comment_2 = 0;
    $comment_3 = 0;
    $comment_o = 0;

    $nameCheck_1 = 0;
    $nameCheck_2 = 0;
    $nameCheck_3 = 0;
    $nameCheck_o = 0;

    $news_1 = 0;
    $news_2 = 0;
    $news_3 = 0;
    $news_o = 0;
    
    $quote_1 = 0;
    $quote_2 = 0;
    $quote_3 = 0;
    $quote_o = 0;

    $ranking_1 = 0;
    $ranking_2 = 0;
    $ranking_3 = 0;
    $ranking_o = 0;

    $test_1 = 0;
    $test_2 = 0;
    $test_3 = 0;
    $test_o = 0;

    $other_1 = 0;
    $other_2 = 0;
    $other_3 = 0;
    $other_o = 0;

    //get Clients Shortcut
    $client_shortcut = new WP_Query(array(
        'post_type' => 'mcsm_clients',
        'posts_per_page' => -1,
        'meta_query' => array(array(
            'key' => 'mcsm_client',
            'value' => sanitize_text_field($_POST['report_client']),
            'compare' => '='
        ))
    ));

    $shortcut = '';

    while($client_shortcut->have_posts()){
        $client_shortcut->the_post();
        $shortcut = get_post_meta(get_the_ID(),'mcsm_shortcut',true);
    }

    //get Tier 1 Publications
    $t1_pubs = new WP_Query(array(
        'post_type' => 'mcsm_publications',
        'posts_per_page' => -1,
        'tax_query' => array(array(
            'taxonomy' => 'tiers',
            'terms' => strtolower($shortcut) . '-tier-1',
            'field' => 'slug',
            'operator' => 'IN',
            'include_children' => false
        ))
    ));

    $tier1_publications = [];

    while($t1_pubs->have_posts()){
        $t1_pubs->the_post();
        $title = get_post_meta(get_the_ID(),'mcsm_publication',true);
        array_push($tier1_publications,$title);
    }

    //get Tier 2 Publications
    $t2_pubs = new WP_Query(array(
        'post_type' => 'mcsm_publications',
        'posts_per_page' => -1,
        'tax_query' => array(array(
            'taxonomy' => 'tiers',
            'terms' => strtolower($shortcut) . '-tier-2',
            'field' => 'slug',
            'operator' => 'IN',
            'include_children' => false
        ))
    ));

    $tier2_publications = [];

    while($t2_pubs->have_posts()){
        $t2_pubs->the_post();
        $title = get_post_meta(get_the_ID(),'mcsm_publication',true);
        array_push($tier2_publications,$title);
    }

    //get Tier 3 Publications
    $t3_pubs = new WP_Query(array(
        'post_type' => 'mcsm_publications',
        'posts_per_page' => -1,
        'tax_query' => array(array(
            'taxonomy' => 'tiers',
            'terms' => strtolower($shortcut) . '-tier-3',
            'field' => 'slug',
            'operator' => 'IN',
            'include_children' => false
        ))
    ));

    $tier3_publications = [];

    while($t3_pubs->have_posts()){
        $t3_pubs->the_post();
        $title = get_post_meta(get_the_ID(),'mcsm_publication',true);
        array_push($tier3_publications,$title);
    }

    foreach($clippings_results as $result){
        $publication = $result->publication;
        $title = $result->title;
        $kind = $result->kind;

        $pdf->Cell(40,5,$publication,0,0,"L");
        $pdf->Cell(120,5,$title,0,0,"L");
        $pdf->Cell(20,5,$kind,0,0,"L");
        $pdf->Ln();

        switch($kind){
            case 'Article':
                if(in_array($publication,$tier1_publications)){
                    $article_1 += 1;
                }elseif(in_array($publication,$tier2_publications)){
                    $article_2 += 1;
                }elseif(in_array($publication,$tier3_publications)){
                    $article_3 += 1;
                }else{
                    $article_o += 1;
                }
                break;
            case 'Case Study':
                if(in_array($publication,$tier1_publications)){
                    $caseStudy_1 += 1;
                }elseif(in_array($publication,$tier2_publications)){
                    $caseStudy_2 += 1;
                }elseif(in_array($publication,$tier3_publications)){
                    $caseStudy_3 += 1;
                }else{
                    $caseStudy_o += 1;
                }
                break;
            case 'Comment':
                if(in_array($publication,$tier1_publications)){
                    $comment_1 += 1;
                }elseif(in_array($publication,$tier2_publications)){
                    $comment_2 += 1;
                }elseif(in_array($publication,$tier3_publications)){
                    $comment_3 += 1;
                }else{
                    $comment_o += 1;
                }
                break;
            case 'Name Check':
                if(in_array($publication,$tier1_publications)){
                    $nameCheck_1 += 1;
                }elseif(in_array($publication,$tier2_publications)){
                    $nameCheck_2 += 1;
                }elseif(in_array($publication,$tier3_publications)){
                    $nameCheck_3 += 1;
                }else{
                    $nameCheck_o += 1;
                }
                break;
            case 'News':
                if(in_array($publication,$tier1_publications)){
                    $news_1 += 1;
                }elseif(in_array($publication,$tier2_publications)){
                    $news_2 += 1;
                }elseif(in_array($publication,$tier3_publications)){
                    $news_3 += 1;
                }else{
                    $news_o += 1;
                }
                break;
            case 'Ranking':
                if(in_array($publication,$tier1_publications)){
                    $ranking_1 += 1;
                }elseif(in_array($publication,$tier2_publications)){
                    $ranking_2 += 1;
                }elseif(in_array($publication,$tier3_publications)){
                    $ranking_3 += 1;
                }else{
                    $ranking_o += 1;
                }
                break;
            case 'Test':
                if(in_array($publication,$tier1_publications)){
                    $test_1 += 1;
                }elseif(in_array($publication,$tier2_publications)){
                    $test_2 += 1;
                }elseif(in_array($publication,$tier3_publications)){
                    $test_3 += 1;
                }else{
                    $test_o += 1;
                }
                break;
            case 'Quote':
                if(in_array($publication,$tier1_publications)){
                    $quote_1 += 1;
                }elseif(in_array($publication,$tier2_publications)){
                    $quote_2 += 1;
                }elseif(in_array($publication,$tier3_publications)){
                    $quote_3 += 1;
                }else{
                    $test_o += 1;
                }
                break;
            case 'Other':
                if(in_array($publication,$tier1_publications)){
                    $other_1 += 1;
                }elseif(in_array($publication,$tier2_publications)){
                    $other_2 += 1;
                }elseif(in_array($publication,$tier3_publications)){
                    $other_3 += 1;
                }else{
                    $other_o += 1;
                }
                break;
        }

    }
    
    $article_option = get_option('mcsm_article_option');
    $caseStudy_option = get_option('mcsm_caseStudy_option');
    $comment_option = get_option('mcsm_comment_option');
    $nameCheck_option = get_option('mcsm_nameCheck_option');
    $news_option = get_option('mcsm_news_option');
    $ranking_option = get_option('mcsm_ranking_option');
    $quote_option = get_option('mcsm_quote_option');
    $test_option = get_option('mcsm_test_option');
    
    //score
    $score =    $article_option * (0.4 * $article_1 + 0.3 * $article_2 + 0.2 * $article_3 + 0.1 * $article_o) +
                $caseStudy_option * (0.4 * $caseStudy_1 + 0.3 * $caseStudy_2 + 0.2 * $caseStudy_3 + 0.1 * $caseStudy_o) +
                $comment_option * (0.4 * $comment_1 + 0.3 * $comment_2 + 0.2 * $comment_3 + 0.1 * $comment_o) +
                $nameCheck_option * (0.4 * $nameCheck_1 + 0.3 * $nameCheck_2 + 0.2 * $nameCheck_3 + 0.1 * $nameCheck_o) +
                $news_option * (0.4 * $news_1 + 0.3 * $news_2 + 0.2 * $news_3 + 0.1 * $news_o) +
                $ranking_option * (0.4 * $ranking_1 + 0.3 * $ranking_2 + 0.2 * $ranking_3 + 0.1 * $ranking_o) +
                $quote_option * (0.4 * $quote_1 + 0.3 * $quote_2 + 0.2 * $quote_3 + 0.1 * $quote_o) +
                $test_option * (0.4 * $test_1 + 0.3 * $test_2 + 0.2 * $test_3 + 0.1 * $test_o) +
                1 * (0.4 * $other_1 + 0.3 * $other_2 + 0.2 * $other_3 + 0.1 * $other_o);

    //Clippings Matrix
    $pdf->SetFont("Helvetica","B",12);    

    $pdf->Ln();
    $pdf->Cell(50,15,"Clippings Matrix",0,0,"L");     
    $pdf->Ln();

    $pdf->Cell(30,5,"",0,0,"L");
    $pdf->Cell(20,5,"",0,0,"L");
    $pdf->Cell(30,5,"Tier 1",0,0,"L");
    $pdf->Cell(30,5,"Tier 2",0,0,"L");
    $pdf->Cell(30,5,"Tier 3",0,0,"L");
    $pdf->Cell(30,5,"Other",0,0,"L");
    $pdf->Ln();

    $pdf->Cell(30,5,"",0,0,"L");
    $pdf->Cell(20,5,"",0,0,"L");
    $pdf->Cell(30,5,"0.4",0,0,"L");
    $pdf->Cell(30,5,"0.3",0,0,"L");
    $pdf->Cell(30,5,"0.2",0,0,"L");
    $pdf->Cell(30,5,"0.1",0,0,"L");
    $pdf->Ln();

    $pdf->SetFont("Helvetica","",11);

    $pdf->Cell(30,5,"Article",0,0,"R");
    $pdf->Cell(20,5,$article_option,0,0,"L");
    $pdf->Cell(30,5,$article_1,0,0,"L");
    $pdf->Cell(30,5,$article_2,0,0,"L");
    $pdf->Cell(30,5,$article_3,0,0,"L");
    $pdf->Cell(30,5,$article_o,0,0,"L");
    $pdf->Ln();

    $pdf->Cell(30,5,"Case Study",0,0,"R");
    $pdf->Cell(20,5,$caseStudy_option,0,0,"L");
    $pdf->Cell(30,5,$caseStudy_1,0,0,"L");
    $pdf->Cell(30,5,$caseStudy_2,0,0,"L");
    $pdf->Cell(30,5,$caseStudy_3,0,0,"L");
    $pdf->Cell(30,5,$caseStudy_o,0,0,"L");
    $pdf->Ln();

    $pdf->Cell(30,5,"Comment",0,0,"R");
    $pdf->Cell(20,5,$comment_option,0,0,"L");
    $pdf->Cell(30,5,$comment_1,0,0,"L");
    $pdf->Cell(30,5,$comment_2,0,0,"L");
    $pdf->Cell(30,5,$comment_3,0,0,"L");
    $pdf->Cell(30,5,$comment_o,0,0,"L");
    $pdf->Ln();

    $pdf->Cell(30,5,"Name Check",0,0,"R");
    $pdf->Cell(20,5,$nameCheck_option,0,0,"L");
    $pdf->Cell(30,5,$nameCheck_1,0,0,"L");
    $pdf->Cell(30,5,$nameCheck_2,0,0,"L");
    $pdf->Cell(30,5,$nameCheck_3,0,0,"L");
    $pdf->Cell(30,5,$nameCheck_o,0,0,"L");
    $pdf->Ln();

    $pdf->Cell(30,5,"News",0,0,"R");
    $pdf->Cell(20,5,$news_option,0,0,"L");
    $pdf->Cell(30,5,$news_1,0,0,"L");
    $pdf->Cell(30,5,$news_2,0,0,"L");
    $pdf->Cell(30,5,$news_3,0,0,"L");
    $pdf->Cell(30,5,$news_o,0,0,"L");
    $pdf->Ln();
    
    $pdf->Cell(30,5,"Quote",0,0,"R");
    $pdf->Cell(20,5,$quote_option,0,0,"L");
    $pdf->Cell(30,5,$quote_1,0,0,"L");
    $pdf->Cell(30,5,$quote_2,0,0,"L");
    $pdf->Cell(30,5,$quote_3,0,0,"L");
    $pdf->Cell(30,5,$quote_o,0,0,"L");
    $pdf->Ln();

    $pdf->Cell(30,5,"Ranking",0,0,"R");
    $pdf->Cell(20,5,$ranking_option,0,0,"L");
    $pdf->Cell(30,5,$ranking_1,0,0,"L");
    $pdf->Cell(30,5,$ranking_2,0,0,"L");
    $pdf->Cell(30,5,$ranking_3,0,0,"L");
    $pdf->Cell(30,5,$ranking_o,0,0,"L");
    $pdf->Ln();

    $pdf->Cell(30,5,"Test",0,0,"R");
    $pdf->Cell(20,5,$test_option,0,0,"L");
    $pdf->Cell(30,5,$test_1,0,0,"L");
    $pdf->Cell(30,5,$test_2,0,0,"L");
    $pdf->Cell(30,5,$test_3,0,0,"L");
    $pdf->Cell(30,5,$test_o,0,0,"L");
    $pdf->Ln();

    $pdf->Cell(30,5,"Other",0,0,"R");
    $pdf->Cell(20,5,"1",0,0,"L");
    $pdf->Cell(30,5,$other_1,0,0,"L");
    $pdf->Cell(30,5,$other_2,0,0,"L");
    $pdf->Cell(30,5,$other_3,0,0,"L");
    $pdf->Cell(30,5,$other_o,0,0,"L");
    $pdf->Ln();

    $pdf->SetFont("Helvetica","B",11);

    $pdf->Ln();
    $pdf->SetLineWidth(0.4);    // Linie über 'Score'

    $pdf->Cell(20,7,"Score:","T",0,"L");
    $pdf->Cell(10,7,$score,"T",0,"R");
    $pdf->Ln();  

    $pdf->Output($path_option . $shortcut . '_' . date('Ymd') . '_report.pdf','F');   

    wp_mail(
        $email_option, 
        "New Report " . $shortcut . '_' .date('Ymd') . "_report.pdf", 
        "The report " . $shortcut . '_' . date('Ymd') . "_report.pdf was generated.",
        "",
        __DIR__ . "/../reports/" . $shortcut . '_' . date('Ymd') . '_report.pdf'
    );
    
}//End get_tierpublications

?>