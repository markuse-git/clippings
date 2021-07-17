jQuery(document).ready(function($){
    
    $("#mcsm_sm_available").click(function(){
        $(".sma-overlay").addClass('sma-overlay--active'); //um Suchfeld zu öffnen 
        $("body").addClass("body-no-scroll"); //damit bei offener Suche nicht gescrollt werden kann
        $("#sma-term").val(''); //um den vorherigen Suchbegriff zu löschen
        setTimeout(function(){
            $("#sma-term").focus(); //um den Cursor im Feld zu aktivieren    
        },301);
    });
    
    $("#sma-close").click(function(){
        $(".sma-overlay").removeClass('sma-overlay--active'); //Suchfeld schließen
        $("body").removeClass("body-no-scroll"); //scrollen wieder ermöglichen
    });

    $(document).keyup(function(e){
        if(e.keyCode == 65 && !$("input, textarea").is(':focus')){ //wenn 'a'(65) gedrückt wird und man sich nicht in einem input Feld befindet 
            $(".sma-overlay").addClass('sma-overlay--active'); 
            $("body").addClass("body-no-scroll");
            $("#sma-term").val('');
            setTimeout(function(){
                $("#sma-term").focus();     
            },301);
        }
        if(e.keyCode == 27){ //wenn esc(27) gedrückt wird
            $(".sma-overlay").removeClass('sma-overlay--active');
            $("body").removeClass("body-no-scroll");
        }
    });
    
    var typingTimer;
    var isSpinnerVisible = false;
    var previousValue;
    
    $("#sma-term").keyup(function(){
        if($("#sma-term").val() != previousValue){ //damit der Spinner nicht mit jedem Tastendruck ausgelöst wird
            clearTimeout(typingTimer); //damit der Timer immer wieder von neu beginnt
            
            if($("#sma-term").val()){
                if(!isSpinnerVisible){ //damit der Spinner nicht immer wieder neu gestartet wird
                    $("#sma-overlay__results").html('<div class="spinner-loader"></div>'); 
                    isSpinnerVisible = true;
                }
            typingTimer = setTimeout(getResults,750); //damit nicht nach jedem einzelnen Buchstaben gesucht wird
            } else{
                $("#sma-overlay__results").html('');
                isSpinnerVisible = false;
            }
                  
        }
        previousValue = $("#sma-term").val();
    });
    
    //REST API
    function getResults(){
        
        //(x)=>{} alt für function(x){}
        //``Template Literals. Innerhalb kann html inkl. Umbrüchen geschrieben weden
        //${} um JS Code innerhalb des template Literals auszuführen
        //Innhalb von Template Literals kann keine if Abfrage ausgeführt werden. Daher Ternary Operator
        
        $.getJSON(searchSma.root_url + '/wp-json/sma/v1/search?term=' + $("#sma-term").val(),(results) =>{
            $("#sma-overlay__results").html(`
                
                <div class="row">

                    <h2 class="sma-overlay__section-title">Submitted Material Available</h2>
                    ${results.length ? '<ul class="link-list min-list">' : '<p>No Submitted Material available matching that search</p>' } 

                    ${results.map(item => `
                        <li>${item.client}: "${item.title}". Published in:
                        ${(function(){
                
                            var entries = [];
                            for(i in item){
                                (item[i] && (i != 'client') && (i != 'title')) ? entries.push(' ' + i[0].toUpperCase() + i.slice(1)) : '';                    
                            }
                            if(entries.length){
                                return entries;    
                            }else{
                                return 'NOWHERE';
                            }
                
                        }())}
                    </li>`).join('')}
                    
                    ${results.length ? '</ul>' : ''}

                </div>

            `);
            isSpinnerVisible = false;
        });
           
    }
    
});