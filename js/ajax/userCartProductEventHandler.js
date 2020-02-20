function userCartProductEventHandler(){}

userCartProductEventHandler.DEFAUL_METHOD = "GET";
userCartProductEventHandler.URL_REQUEST = "./ajax/userCartProductInteraction.php";
userCartProductEventHandler.ASYNC_TYPE = true;
userCartProductEventHandler.SUCCESS_RESPONSE = "0";

userCartProductEventHandler.onCartProductQuantityChangeEvent =
    function(productId, addQuantity, maxQuantity, productModel, prezzo, returnPage){
        var queryString = "?ID=" + productId + "&Add=" + addQuantity + "&MaxQuantita=" + maxQuantity + "&Prodotto=" + productModel + "&Prezzo=" + prezzo + "&returnPage=" + returnPage;
		var url = userCartProductEventHandler.URL_REQUEST + queryString;
		var responseFunction = userCartProductEventHandler.onAjaxResponse;
	
		AjaxManager.performAjaxRequest(userCartProductEventHandler.DEFAUL_METHOD, 
										url, userCartProductEventHandler.ASYNC_TYPE, 
										null, responseFunction)
}

userCartProductEventHandler.onAjaxResponse = 
	function(response){
        CartProduct.updateCartProduct(response.data, response.responseCode);
	}