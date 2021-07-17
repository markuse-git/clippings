jQuery(document).ready(function($){
    
    //----------DATEPICKER----------------
    $("#publication_date, #mcsm_date, #mcsm_pr_date, #report_from, #report_to, #mcsm_pr_date").datepicker({
        dateFormat: "yy-mm-dd"
    });
    
    var $datepicker = $('#ui-datepicker-div');
    $datepicker.css({
        backgroundColor: 'white',
        //marginTop: '10%',
        marginLeft: '20%'
    });
    
    // prevent user from typing in manually
    $("#publication_date, #mcsm_date, #mcsm_pr_date, #report_from, #report_to, #mcsm_pr_date").keydown(function(e){
        e.preventDefault();
        return false;
    });
    
    //------------Check Title Input--------------------
    
    $("#submit").click(function(e){
        if($("#title").val() == ''){
            alert('Please provide a title');
            e.preventDefault();
        }
    });
    
    //------------Open/Close Create Report Form---------------------
    
    $("#createReport").click(function(){
        $("#report_form").toggle();
    })
    
    //-----------------Success Messages--------------------------
    
    if(typeof add_clipping !== 'undefined' && add_clipping > 0){
                
        $("#clipping-success-message").addClass('success-message--active');
        setTimeout(function(){$(".success-message").removeClass('success-message--active');},3000);
    }
    
    if(typeof add_report !== 'undefined' && add_report == 'ok'){
                
        $("#report-success-message").addClass('success-message--active');
        setTimeout(function(){$(".success-message").removeClass('success-message--active');},3000);
    }
    
});