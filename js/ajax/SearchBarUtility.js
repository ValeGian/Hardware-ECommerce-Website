function SearchBarUtility(){}

SearchBarUtility.updateSearchBarProductBox = 
    function(data, message, DIM_PRODOTTO){
        var SBPBElem = document.getElementById("search_bar_products_box");
        var SBPLCElem = document.getElementById("search_bar_products_list_container");
    
        if(message == 'search_vuota')
            SBPBElem.style.display = "none";
        else if(message !== 'scrolling')
            SBPBElem.style.display = "block";
    
        if(message !== 'scrolling'){
            SearchBarUtility.setEmptySBResultContainer(message);
        }
        
    //SE è STATA FATTA UNA NUOVA RICERCA
        if(message == 'new_load'){
            SearchBarUtility.setProductsCount(data.productsCount);
        //RIMUOVO LA VECCHIA RICERCA, SE ESISTENTE
            SearchBarUtility.removeContent();
        //CREO UNA NUOVA LISTA DI PRODOTTI
            var newSBPLElem = document.createElement("ul");
            newSBPLElem.setAttribute("id", "search_bar_products_list");
            newSBPLElem.setAttribute("class", "five-col");
            
        //RIEMPIO LA LISTA CON UN CHUNCK DI PRODOTTI
            for(var i = 1; i <= data.newProductsDisplayed; i++){
                var newSBPElem = SearchBarUtility.createSearchBarElement(data, i);
                newSBPLElem.appendChild(newSBPElem);
            }
            
            SBPLCElem.appendChild(newSBPLElem);
            SearchBarUtility.checkAndSetPlaceholder(data.newProductsDisplayed);
        }
    
    //SE L'UTENTE STA SCROLLANDO I PRODOTTI E NON è AVVENUTO UN CAMBIO DI RICERCA
        if(message == 'scrolling'){
            SearchBarUtility.checkAndSetPlaceholder(data.lastProduct);
            
            //LEGGO IL NUMERO DI PRODOTTI GIà CARICATI
            var SBPlaceholderElem = document.getElementById("search_bar_placeholder");
            if(SBPlaceholderElem)
                productsDisplayed = SBPlaceholderElem.value;
            else
                var productsDisplayed = 0;
            
            //SE LO SCROLL é A METà DELL'ULTIMA RIGA DI PRODOTTI CARICATI, ALLORA CARICO UN NUOVO CHUNCK DI PRODOTTI
            
            var SBPLElem = document.getElementById("search_bar_products_list");
            for(var i = 1; i <= data.newProductsDisplayed; i++){
                var newSBPElem = SearchBarUtility.createSearchBarElement(data, i);
                SBPLElem.appendChild(newSBPElem);
            }
        }
    
        //SEGNALO IL TERMINE DELLA AJAX REQUEST
        window.performing_ajax_request = false;
    }


SearchBarUtility.removeContent =
    function(){
        var SBPLCElem = document.getElementById("search_bar_products_list_container");
        if(SBPLCElem === null)
            return;
    
        var SBPLElem = SBPLCElem.firstElementChild;
        if (SBPLElem !== null)
			SBPLCElem.removeChild(SBPLElem);
        
    }

SearchBarUtility.setEmptySBResultContainer =
    function(message){
        SearchBarUtility.removeContent();
        var noresultPElem = document.getElementById("noresult");
        if(message == 'nessun_prodotto_trovato' && noresultPElem === null){
            
            SearchBarUtility.setProductsCount(0);
            
            var SBPLCElem = document.getElementById("search_bar_products_list_container");
            var noresultPElem = document.createElement("p");
            noresultPElem.setAttribute("id", "noresult");
            noresultPElem.textContent = "Siamo spiacenti, non é stato trovato nessun risultato.";
            
            SBPLCElem.appendChild(noresultPElem);
        }
    }

SearchBarUtility.createSearchBarElement =
    function(data, index){
        var newSBPC = document.createElement("li");
        newSBPC.setAttribute("class", "search_bar_product_container column-layout");
    
        var newSBP = document.createElement("div");
        newSBP.setAttribute("class", "search_bar_product");
    
        var productURL = "./productPage.php?Tabella=" + data.products[index].tabella + "&Modello=" + encodeURIComponent(data.products[index].product_model);
        var newSBPD = document.createElement("a");
        newSBPD.setAttribute("class", "search_bar_product_detail");
        newSBPD.setAttribute("href", productURL);
    
        var img = data.products[index].immagine;
        if(img === "")
            img = "default_img.png";
        var newImgElem = document.createElement("img");
        newImgElem.setAttribute("class", "immagine-responsive");
        newImgElem.setAttribute("src", "./../img/Products/" + img);
        newImgElem.setAttribute("alt", "Prodotto");
    
        var newP1Elem = document.createElement("p");
        newP1Elem.setAttribute("class", "search_bar_product_modello");
        newP1Elem.textContent = data.products[index].product_model;
    
        var prezzo = parseFloat(data.products[index].prezzo);
        prezzo = prezzo.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');    //per avere il prezzo nel formato 12.34
        var newP2Elem = document.createElement("p");
        newP2Elem.setAttribute("class", "search_bar_product_prezzo");
        newP2Elem.textContent = "\u20AC" + prezzo;
    
    
        newSBPD.appendChild(newImgElem);
        newSBPD.appendChild(newP1Elem);
        newSBPD.appendChild(newP2Elem);
    
        newSBP.appendChild(newSBPD);
        newSBPC.appendChild(newSBP);
        
        return newSBPC;
    }

SearchBarUtility.setProductsCount =
    function(count){
        var SBCElem= document.getElementById("search_result_count");
        var firstChild = SBCElem.firstElementChild;
        if (firstChild !== null)
            SBCElem.removeChild(firstChild);
        var SBCSpanElem = document.createElement("span");
        var SBCBElem = document.createElement("b");
        SBCBElem.textContent = count;
        var SBCTextNode = document.createTextNode(" Risultati Trovati");
        SBCSpanElem.appendChild(SBCBElem);
        SBCSpanElem.appendChild(SBCTextNode);
        SBCElem.appendChild(SBCSpanElem);
    }

//SETTA UN PLACEHOLDER CONTENENTE IL NUMERO DI PRODOTTI ATTUALMENTE CARICATI NELLA SEARCH BOX
SearchBarUtility.checkAndSetPlaceholder = 
    function(LastProduct){
        var SBPLCElem = document.getElementById("search_bar_products_list_container");
        if(SBPLCElem === null)
            return;
    
    
        var SBPlaceholderElem = document.getElementById("search_bar_placeholder");

        if(SBPlaceholderElem !== null)
            SBPlaceholderElem.parentNode.removeChild(SBPlaceholderElem);
        
        var newPlaceholder = document.createElement("input");
        newPlaceholder.setAttribute("id", "search_bar_placeholder");
        newPlaceholder.setAttribute("type", "text");
        newPlaceholder.setAttribute("value", LastProduct);
        newPlaceholder.style.display = "none";
    
        SBPLCElem.appendChild(newPlaceholder);
    }