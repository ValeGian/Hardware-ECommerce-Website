function CartProduct(){}

CartProduct.updateCartProduct =
    function(data, responseCode){
    
        var messageDivElem = document.getElementById("alert-container");
        if(messageDivElem !== null){
             messageDivElem.parentNode.removeChild(messageDivElem);
        }
    
        if(responseCode == -1){   //IN PRESENZA DI ERRORI, LI SEGNALO
            
            var errorContainer = document.getElementById("messageContainer");
            if(errorContainer === null)
                return;
            
            if(data.productMaxQuantity == 0)
                var postfix = "eliminare tale prodotto.";
            else
                var postfix = "ridurre tale quantit\u00E0.";
            
            var returnUrl = "./cartPage.php?Page=" + data.page;
            var errorKindMessage = "ERRORE NELL\'INSERIMENTO NEL CARRELLO:";
            var errorTypeMessage = "La quantit\u00E0 del prodotto " + data.productModel + " supera quella disponibile in magazzino(" + data.productMaxQuantity + "). Per poter proseguire con l\'acquisto occorrer\u00E0 " + postfix;
            
            showErrorMessage(returnUrl, errorKindMessage, errorTypeMessage);
            
            
        }
        else{
            if(data.productQuantity == 1){
                var minusModifier = document.getElementById("-modifier" + data.productId);
                if(minusModifier !== null)
                    minusModifier.style.display = "none";
                
                var productQuantity = document.getElementById("product" + data.productId + "Quantity");
                productQuantity.textContent = data.productQuantity;
            }
            else{
                var minusModifier = document.getElementById("-modifier" + data.productId);
                if(minusModifier === null){
                    minusModifier = document.createElement("span");
                    minusModifier.setAttribute("id", "-modifier" + data.productId);
                    minusModifier.setAttribute("class", "ajaxCartModifiers");
                    minusModifier.setAttribute("title", "Togli 1 unit\u00E0 di Prodotto");
                    minusModifier.setAttribute("onclick", "userCartProductEventHandler.onCartProductQuantityChangeEvent(" + data.productId + ", -1, " + data.productMaxQuantity + ", \'" + data.productModel + "\', " + data.productCosto + ")");
                    minusModifier.textContent = "-";
                    
                    var plusModifier = document.getElementById("+modifier" + data.productId);
                    plusModifier.parentNode.insertBefore(minusModifier, plusModifier);
                }
                else if(minusModifier.style.display === "none")
                    minusModifier.style.display = "inline";
            }
            
                var productQuantity = document.getElementById("product" + data.productId + "Quantity");
                var spesaCartH = document.getElementById("spesaCartH");
                var spesaCartB = document.getElementById("spesaCartB" + data.productId);
                var spesaCartC = document.getElementById("spesaCartC");

            //MODIFICO I VALORI RELATIVI AI NUOVI TOTALI SPESA
                productQuantity.textContent = data.productQuantity;
                
                var spesaB = data.productQuantity * data.productCosto;
                spesaB = spesaB.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');    //per avere la spesa nel formato es. 12.34
                spesaCartB.textContent = "\u20AC " + spesaB;

                var spesaH = (parseFloat(data.spesa) + data.operazione * data.productCosto);
                spesaH = spesaH.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                spesaCartH.textContent = "\u20AC" + spesaH;
                spesaCartC.textContent = "\u20AC " + spesaH;     
        }
    
    }