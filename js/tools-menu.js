jQuery(document).ready(function($){
    
    function mcsm_add_tool(){
        
        var kinds_1 = ['Article','Case Study','Comment'];
        var kinds_2 = ['Name Check','News','Ranking','Test','Other'];
        
        var tools_1 = ['Submitted Material'];
        var tools_2 = ['Interview','Press Release','Press Conference','Other'];

        var selected_kind = $("#kind :selected").val();
        
        if(kinds_1.includes(selected_kind)){
            for(var item in tools_1){
                var optionElement = document.createElement('option');
                optionElement.setAttribute('class','tool_option');
                var optionText = document.createTextNode(tools_1[item]);
                optionElement.append(optionText);
                $("#tool").append(optionElement);
                $(".submitted-material").addClass('submitted-material--active');
            }
        } else{
            for(var item in tools_2){
                var optionElement = document.createElement('option');
                optionElement.setAttribute('class','tool_option');
                var optionText = document.createTextNode(tools_2[item]);
                optionElement.append(optionText);
                $("#tool").append(optionElement);
            }
        }
        
    }
    
    mcsm_add_tool();
    
    $("#kind").change(function(){
        $(".tool_option").remove();
        $(".submitted-material").removeClass('submitted-material--active');
        mcsm_add_tool();
    });
    
});