function userSearchBarEventHandler(){}
userSearchBarEventHandler.DEFAUL_METHOD = "GET";
userSearchBarEventHandler.URL_REQUEST = "./ajax/userSearchBarInteraction.php";
userSearchBarEventHandler.ASYNC_TYPE = true;
userSearchBarEventHandler.SUCCESS_RESPONSE = "0";
userSearchBarEventHandler.CHUNCK_SIZE = "15";   //NUMERO MASSIMO DI PRODOTTI CARICATI PER OGNI CHUNCK DI RICERCA
userSearchBarEventHandler.DIM_PRODOTTO = "217"; //DIMENSIONE IN PIXEL DEL RIQUADRO DEL PRODOTTO

userSearchBarEventHandler.onKeyUpSearchBarEvent =
    function(searchedValue){
        var searching = searchedValue.value;
        var queryString = "?Search=" + searching + "&ProductPerChunck=" + userSearchBarEventHandler.CHUNCK_SIZE;
		var url = userSearchBarEventHandler.URL_REQUEST + queryString;
		var responseFunction = userSearchBarEventHandler.onAjaxResponse;
	
		AjaxManager.performAjaxRequest(userSearchBarEventHandler.DEFAUL_METHOD, 
										url, userSearchBarEventHandler.ASYNC_TYPE, 
										null, responseFunction)
    }

userSearchBarEventHandler.onScrollSearchBarEvent =
    function(){
    
    //SE VI é UN'ALTRA AJAX REQUEST CHE STA LAVORANDO, NON FACCIO NIENTE
    if(window.performing_ajax_request === true)
        return;
        
    //LEGGO IL NUMERO DI PRODOTTI GIà CARICATI
        var SBPlaceholderElem = document.getElementById("search_bar_placeholder");
        if(SBPlaceholderElem)
            productsDisplayed = SBPlaceholderElem.value;
        else
            var productsDisplayed = 0;
    
    //DATI UTILI PER CALCOLARE L'OFFSET DI SCROLL
        var prodPerLine = 5;
        var windowWidth = screen.width;
        if(windowWidth <= 1180 && windowWidth > 1000)
            prodPerLine = 4;
        else if(windowWidth <= 1000 && windowWidth > 820)
            prodPerLine = 3;
        else if(windowWidth <= 820 && windowWidth > 660)
            prodPerLine = 2;
    
        var temp = productsDisplayed/prodPerLine;
        var ShowingLines = Math.ceil(temp);
    
    
    //SE NECESSITO DI CARICARE NUOVI PRODOTTI, LANCIO UNA AJAX REQUEST
        var SBPLCElem = document.getElementById("search_bar_products_list_container");
        if(SBPLCElem === null)
            return;
    
        var yOffset = SBPLCElem.scrollTop;
        var DIM_PRODOTTO = userSearchBarEventHandler.DIM_PRODOTTO;
    
        if(yOffset >= ((ShowingLines - 3)*DIM_PRODOTTO + DIM_PRODOTTO/2)){
    
        //PRENDO LA STRINGA DA RICERCARE
            var searching = document.getElementById("search_bar_input").value;  


            var queryString = "?Search=" + searching + "&ProductPerChunck=" + userSearchBarEventHandler.CHUNCK_SIZE + "&ProductsDisplayed=" + productsDisplayed;
            var url = userSearchBarEventHandler.URL_REQUEST + queryString;
            var responseFunction = userSearchBarEventHandler.onAjaxResponse;
            
            //MANDO L'AJAX REQUEST
            window.performing_ajax_request = true;
            AjaxManager.performAjaxRequest(userSearchBarEventHandler.DEFAUL_METHOD, 
                                        url, userSearchBarEventHandler.ASYNC_TYPE, 
                                        null, responseFunction)
        }
    }

userSearchBarEventHandler.onAjaxResponse = 
	function(response){
		if (response.responseCode === userSearchBarEventHandler.SUCCESS_RESPONSE)
			SearchBarUtility.updateSearchBarProductBox(response.data, response.message, userSearchBarEventHandler.DIM_PRODOTTO);
		
	}
