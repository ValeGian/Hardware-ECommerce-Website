function ProductUtility(){}

ProductUtility.updateProductFormInfo =
    function(data){
        var suff = suffix(data.tabella);
        var descrizione = document.getElementById("Descrizione" + suff);
        var prezzo = document.getElementById("Prezzo" + suff);
    
		if (descrizione === null || prezzo === null || data === null || data.length <= 0)
			return;
        
        descrizione.value = data.descrizione;
        prezzo.setAttribute("value", data.prezzo);
    }