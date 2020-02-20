<?php
    if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

    require_once "../pathConfig.php";
    require_once DIR_UTIL."ECommerceDbManager.php";
    require_once DIR_AJAX."AjaxResponse.php";

    $response = new AjaxResponse();

    $productModel = null;
    $table = null;
	if (!isset($_GET['Tabella']) || !isset($_GET['Modello'])){
		echo json_encode($response);
		return;
	}	
    $productModel = $_GET['Modello'];
    $table = $_GET['Tabella'];

//ESTRAGGO I DATI DEL PRODOTTO
    $result = getProduct($table, $productModel);
    $numRow = mysqli_num_rows($result);
    if($numRow == 1){
     
    //CREO UN OGGETTO PRODOTTO CON I DATI ESTRATTI
        $row = $result->fetch_assoc();
        $prodotto = new Prodotto($row['Modello'], $row['Descrizione'], $row['Immagine']);
        $prodotto->createProdotto($table, $row);
        
    //RITORNO IL PRODOTTO 
        $response = new AjaxResponse("0", "OK");
        $response->data =$prodotto;
    }

    echo json_encode($response);
    return;

?>