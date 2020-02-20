function adminProductEventHandler(){}
adminProductEventHandler.DEFAUL_METHOD = "GET";
adminProductEventHandler.URL_REQUEST = "./ajax/adminProductInteraction.php";
adminProductEventHandler.ASYNC_TYPE = true;
adminProductEventHandler.SUCCESS_RESPONSE = "0";

adminProductEventHandler.onChangeModProductEvent =
    function(table, selectedProduct){
        var productModel = selectedProduct.value;
        var queryString = "?Tabella=" + table + "&Modello=" + productModel;
		var url = adminProductEventHandler.URL_REQUEST + queryString;
		var responseFunction = adminProductEventHandler.onAjaxResponse;
	
		AjaxManager.performAjaxRequest(adminProductEventHandler.DEFAUL_METHOD, 
										url, adminProductEventHandler.ASYNC_TYPE, 
										null, responseFunction)
    }

adminProductEventHandler.onLoadModProductEvent =
    function(table, selectedProduct){
        var queryString = "?Tabella=" + table + "&Modello=" + selectedProduct;
		var url = adminProductEventHandler.URL_REQUEST + queryString;
		var responseFunction = adminProductEventHandler.onAjaxResponse;
	
		AjaxManager.performAjaxRequest(adminProductEventHandler.DEFAUL_METHOD, 
										url, adminProductEventHandler.ASYNC_TYPE, 
										null, responseFunction)
    }

adminProductEventHandler.onAjaxResponse = 
	function(response){
		if (response.responseCode === adminProductEventHandler.SUCCESS_RESPONSE)
			ProductUtility.updateProductFormInfo(response.data);
		
	}