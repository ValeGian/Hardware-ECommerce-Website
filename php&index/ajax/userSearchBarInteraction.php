<?php
    if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

    require_once "../pathConfig.php";
    require_once DIR_UTIL."ECommerceDbManager.php";
    require_once DIR_AJAX."AjaxResponse.php";

    $response = new AjaxResponse();

    $searchedValue = null;
    if(!isset($_GET['Search'])){
        echo json_encode($response);
		return;
    }

    $searchedValue = $_GET['Search'];
    if($searchedValue === ''){
        $response = new AjaxResponse("0", 'search_vuota');
        echo json_encode($response);
        return;
    }

//SETTO QUANTI PRODOTTI CARICARE NEL CHUNCK
    if(isset($_GET['ProductPerChunck']))
        $productPerChunck = $_GET['ProductPerChunck'];
    else
        $productPerChunck = 15;


//SE SI ARRIVA DALLA onKeyUp E NON DALLA onScroll
    if(!isset($_GET['ProductsDisplayed'])){ 
        $message = "new_load";
        $productsDisplayed = 0;
    }
    else{
        $message = "scrolling";
        $productsDisplayed = $_GET['ProductsDisplayed'];
     }


//CONTO QUANTI NUOVI PRODOTTI VANNO EFFETTIVAMENTE CARICATI 
    $ProdCount = countProductsAcquirableLike($searchedValue);
    if($ProdCount === 0){
        $response = new AjaxResponse("0", 'nessun_prodotto_trovato');
        echo json_encode($response);
        return;
    }
    else if(($ProdCount - $productsDisplayed) < $productPerChunck)
        $newProductsDisplayed = $ProdCount - $productsDisplayed;
    else
        $newProductsDisplayed = $productPerChunck;


//SETTO L'INSIEME DELLA MIA RICERCA
    $firstProduct = $productsDisplayed + 1;
    $lastProduct = $firstProduct + $newProductsDisplayed - 1;


//PER OGNI PRODOTTO ACQUISTABILE, CONTROLLO SE RISPETTA LA RICERCA CHE STO EFFETTUANDO
    $prodotti = null;
    $result1 = getAllAcquirableProducts('asc');
    $numRow1 = mysqli_num_rows($result1);
    $count = 1;
    $countDiscarded = 0;

    for($i = 1; $i <= $numRow1; $i++){
        $row = $result1->fetch_assoc();
        $id = $row['id_Prodotto'];
        $result = getProductByIDLike($id, $searchedValue);
        $numRow = mysqli_num_rows($result);
        
    //SE IL PRODOTTO NON RISPETTA LA RICERCA, VIENE SCARTATO
        if($numRow == 0){
            $countDiscarded++;
            continue;
        }
        
    //SE IL PRODOTTO è GIà STATO CARICATO IN UN CHUNCK PRECEDENTE, CONTINUO
        if(($i-$countDiscarded) < $firstProduct)
            continue;
        
    //SE IL PRODOTTO APPARTIENE AD UN CHUNCK SUCCESSIVO AL CHUNCK ATTUALE, ESCO DAL CICLO
        if(($i-$countDiscarded) > $lastProduct)
            break;
        
    //INSERISCO IL PRODOTTO NELL'INSIEME DEI PRODOTTI DA CARICARE
        $row = $result->fetch_assoc();
        $tabella = findTable($id);
        
        $prodotto = new Prodotto();
        $prodotto->createProdotto($tabella, $row);
        $prodotti[$count] = $prodotto;
        $count++;
    }

//COSTRUISCO UN OGGETTO CONTENENTE LE INFO NECESSARIE A CARICARE I GIUSTI PRODOTTI E LO INVIO IN RISPOSTA
    $searchedProducts = new SearchedProducts($prodotti, $ProdCount, $newProductsDisplayed, $lastProduct);
    $response = new AjaxResponse("0", $message);
    $response->data = $searchedProducts;
    echo json_encode($response);
    return;

?>