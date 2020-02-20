<?php
    if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

    require_once "../pathConfig.php";
    require_once DIR_UTIL."ECommerceDbManager.php"; //INCLUDO LE FUNZIONI DI UTILITà PER ACCEDERE AL DATABASE

    $errorType = null;

//SETTO LE VARIABILI CHE MI SERVIRANNO

    $tabella = $_GET['Tabella'];

    if($_GET['oldPage'] == 'PList'){    //SE ARRIVO DALLA LISTA PRODOTTI
        $currPage = $_GET['Page'];
                
        if(isset($_GET['Sort'])){
            $sort = $_GET['Sort'];
        }
        else{
            $sort = 'desc';
        }

        if(isset($_GET['Tipo'])){
            $tipo = $_GET['Tipo'];
        }
        else {
            $tipo = '';
        }

        if(isset($_GET['Produttore'])){
            $produttore = $_GET['Produttore'];
        }
        else{
            $produttore = '';
        }
        
        
        if(isset($_GET['Searching']))
            $url = '../productListPage.php?Searching='.rawurlencode($_GET['Searching']).'&Sort='.$sort.'&Page='.$currPage;
        else
            $url = '../productListPage.php?Tabella='.$tabella.'&Tipo='.$tipo.'&Produttore='.rawurlencode($produttore).'&Sort='.$sort.'&Page='.$currPage;
        
        $errorKind = 'add_to_cart';
        $message = 'cart_succ_ins_LPage';
    }
    elseif($_GET['oldPage'] == 'PPage'){
        $modello = $_GET['Modello'];
        $url = '../productPage.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello);
        
        $errorKind = 'add_to_cart_2';
        $message = 'cart_succ_ins_PPage';
    }

    $id = $_GET['ID'];

//CONTROLLO SE LOGGATO
    if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] === false){   //SE NON LOGGATO, SEGNALA ERRORE
            $errorType = 'cart_not_logged';
            $url.= '&errorKind='.$errorKind.'&errorType='.$errorType;    

            header('Location: '.$url);//IN CASO DI ERRORE, REINDIRIZZO ALLA PAGINA DI LOGIN E LO SEGNALO
            exit;
        }

    $nomeUtente = $_SESSION["NomeUtente"];

//CONTROLLO SE IL PRODOTTO è ACQUISTABILE
    if(!isset($_GET['Acqu']) || $_GET['Acqu'] == 0){ 
        $errorType = 'prod_not_acquirable';
        $url.= '&errorKind='.$errorKind.'&errorType='.$errorType;    

        header('Location: '.$url);//IN CASO DI ERRORE, REINDIRIZZO ALLA PAGINA DI LOGIN E LO SEGNALO
        exit;
    }

//CONTROLLO SE IL PRODOTTO SI TROVA GIà NEL CARRELLO E IN CASO LO SEGNALO
    $result = getCartItem($nomeUtente, $id);
    $numRow = mysqli_num_rows($result);
        
    if($numRow == 1){   
        $errorType = 'already_in_cart';
        $url.= '&errorKind='.$errorKind.'&errorType='.$errorType;
        
        header('Location: '.$url);//IN CASO DI ERRORE, REINDIRIZZO ALLA PAGINA DI LOGIN E LO SEGNALO
        exit;
    }

//INSERISCO NEL CARRELLO
    $result = insertCartItem($nomeUtente, $id);
        
    if(!$result){
        $errorType = 'add_cart_error';
        $url.= '&errorKind='.$errorKind.'&errorType='.$errorType;
    }
    else{
        $url .= '&Message='.$message;
    }

    header('Location: '.$url);//IN CASO DI ERRORE, REINDIRIZZO ALLA PAGINA DI LOGIN E LO SEGNALO
    exit;
?>







































