<?php
    if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

    if(!isset($_SESSION['NomeUtente'])){
        echo json_encode($response);
		return;
    }

    require_once "../pathConfig.php";
    require_once DIR_UTIL."ECommerceDbManager.php";
    require_once DIR_AJAX."AjaxResponse.php";

    $response = new AjaxResponse();

    $productId = null;
    $newQuantita = null;
    $maxQuantita = null;
	if (!isset($_GET['ID']) || !isset($_GET['Add']) || !isset($_GET['MaxQuantita'])){
		echo json_encode($response);
		return;
	}	
    $nomeUtente = $_SESSION['NomeUtente'];
    $productId = $_GET['ID'];
    $newQuantita = getProductCartQuantity($productId, $nomeUtente) + $_GET['Add'];
    $maxQuantita = $_GET['MaxQuantita'];
    $spesa = number_format(getSpesaCart($nomeUtente), 2, '.', '');
    
//LA NUOVA QUANTITA NON PUò ESSERE MINORE DI 1 O MAGGIORE DELLA QUANTITA DI TALE PRODOTTO PRESENTE IN MAGAZZINO
    if($newQuantita <= 0) $newQuantita = 1;

    $cartModification = new CartSingleProductMod($productId, $_GET['Prodotto'], $newQuantita, $maxQuantita, $_GET['Prezzo'], $_GET['Add'], $spesa, $_GET['returnPage']);

    if($maxQuantita == 0){
        $response = new AjaxResponse("-1", "not_enough_product");
        $response->data = $cartModification;
    }
    else if($newQuantita > $maxQuantita){
        $newQuantita = $maxQuantita;
        $result = updateQuantityCartItem($nomeUtente, $productId, $newQuantita);
        $response = new AjaxResponse("-1", "not_enough_product");
        $response->data = $cartModification;
    }
    else{
    //SETTO LA NUOVA QUANTITà DEL PRODOTTO NEL CARRELLO
        $result = updateQuantityCartItem($nomeUtente, $productId, $newQuantita);
        if($result){
            $response = new AjaxResponse("0", "OK");
            $response->data = $cartModification;
        }
    }

    echo json_encode($response);
    return;

?>