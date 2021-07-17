jQuery(document).ready(function($){
    
    $("#mcsm_search_clippings").click(function(){
        $(".search-overlay").addClass('search-overlay--active'); //um Suchfeld zu öffnen 
        $("body").addClass("body-no-scroll"); //damit bei offener Suche nicht gescrollt werden kann
        $("#search-term").val(''); //um den vorherigen Suchbegriff zu löschen
        setTimeout(function(){
            $("#search-term").focus(); //um den Cursor im Feld zu aktivieren    
        },301);
    });
    
    $("#close").click(function(){
        $(".search-overlay").removeClass('search-overlay--active'); //Suchfeld schließen
        $("body").removeClass("body-no-scroll"); //scrollen wieder ermöglichen
    });

    $(document).keyup(function(e){
        if(e.keyCode == 83 && !$("input, textarea").is(':focus')){ //wenn 's'(83) gedrückt wird und man sich nicht in einem input Feld befindet 
            $(".search-overlay").addClass('search-overlay--active'); 
            $("body").addClass("body-no-scroll");
            $("#search-term").val('');
            setTimeout(function(){
                $("#search-term").focus();     
            },301);
        }
        if(e.keyCode == 27){ //wenn esc(27) gedrückt wird
            $(".search-overlay").removeClass('search-overlay--active');
            $("body").removeClass("body-no-scroll");
        }
    });
    
    var typingTimer;
    var isSpinnerVisible = false;
    var previousValue;
    
    $("#search-term").keyup(function(){
        if($("#search-term").val() != previousValue){ //damit der Spinner nicht mit jedem Tastendruck ausgelöst wird
            clearTimeout(typingTimer); //damit der Timer immer wieder von neu beginnt
            
            if($("#search-term").val()){
                if(!isSpinnerVisible){ //damit der Spinner nicht immer wieder neu gestartet wird
                    $("#search-overlay__results").html('<div class="spinner-loader"></div>'); 
                    isSpinnerVisible = true;
                }
            typingTimer = setTimeout(getResults,750); //damit nicht nach jedem einzelnen Buchstaben gesucht wird
            } else{
                $("#search-overlay__results").html('');
                isSpinnerVisible = false;
            }
                  
        }
        previousValue = $("#search-term").val();
    });
    
    //REST API
    function getResults(){
        
        //(x)=>{} alt für function(x){}
        //``Template Literals. Innerhalb kann html inkl. Umbrüchen geschrieben weden
        //${} um JS Code innerhalb des template Literals auszuführen
        //Innhalb von Template Literals kann keine if Abfrage ausgeführt werden. Daher Ternary Operator
        
        $.getJSON(searchClippings.root_url + '/wp-json/clippings/v1/search?term=' + $("#search-term").val(),(results) =>{
            $("#search-overlay__results").html(`
                
                <div class="row">

                    <h2 class="search-overlay__section-title">Clippings</h2>
                    ${results.length ? '<ul class="link-list min-list">' : '<p>No clipping matches that search</p>' }

                        ${results.map(item => `<li>${item.client}: "${item.title}" in ${item.publication} on ${item.date}</li>`).join('')}

                    ${results.length ? '</ul>' : ''}

                </div>

            `);
            isSpinnerVisible = false;
        });
           
    }  
    
});