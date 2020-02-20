<?php
    if(isset($_GET['Submit']) && $_GET['Submit'] == 'ordineSetSold'){
        require_once "../pathConfig.php";
        require_once DIR_UTIL."ECommerceDbManager.php"; //INCLUDO LE FUNZIONI DI UTILITà PER ACCEDERE AL DATABASE

    //SETTO LE VARIABILI CHE MI SERVONO
        $ordine = $_GET['Ordine'];
        
        if(!isset($_GET['Page']))
            $page = 1;
        else
            $page = $_GET['Page'];
        
        if(!isset($_GET['Sort']) || $_GET['Sort'] === '')
            $sortFlag = '';
        else
            $sortFlag = '&Sort='.$_GET['Sort'];
        
    //ELIMINO DAL CARRELLO SPECIFICO IL PRODOTTO SELEZIONATO
        $result = setOrdinePagato($ordine);

        if(!$result){
            header('Location: ../admin_VisOrdini.php?errorKind=ordineSetSold_error&Page='.$page.$sortFlag);
            exit;
        }

        $result = getOrdine($ordine);
        $row = $result->fetch_assoc();
        $data = $row['Data'];
        
        header('Location: ../admin_VisOrdini.php?Message=ordine_succ_pagato&Data_Ordine='.$data.'&Page='.$page.$sortFlag);
        exit;
    }

?>