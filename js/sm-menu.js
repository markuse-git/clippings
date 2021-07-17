jQuery(document).ready(function($){
       
    var client_sm = [];
    
    function mcsm_add_sm(){
        
        client_sm = [];
        var selected_client = $("#client :selected").val();
        
        for(var i in sm_json){
            var entry = sm_json[i];
            for(var key in entry){
                if(key == selected_client){
                    client_sm.push(entry[key])
                }
            }
        }
        
        if(client_sm.length > 0){
            for(let item of client_sm){
                var optionElement = document.createElement('option');
                optionElement.setAttribute('class','sm_option');
                var optionText = document.createTextNode(item);
                optionElement.append(optionText);
                $("#submitted_material").append(optionElement);
            }
            
        } else{
            var optionElement = document.createElement('option');
            optionElement.setAttribute('class','sm_option');
            optionElement.setAttribute('selected','selected');
            var optionText = document.createTextNode('No Submitted Material available');
            optionElement.append(optionText);
            $("#submitted_material").append(optionElement);
        }
        
    }
    
    mcsm_add_sm();
    
    $("#client").change(function(){
        $(".sm_option").remove();
        mcsm_add_sm();
    });
    
});