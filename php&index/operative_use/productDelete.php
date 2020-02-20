<?php
    if(isset($_GET['Submit']) && $_GET['Submit'] == 'productDelete'){
        require_once "../pathConfig.php";
        require_once DIR_UTIL."ECommerceDbManager.php"; //INCLUDO LE FUNZIONI DI UTILITà PER ACCEDERE AL DATABASE


    //SETTO LE VARIABILI CHE MI SERVONO
        $nomeUtente = $_GET['Utente'];
        $id = $_GET['ID'];

    //ELIMINO DAL CARRELLO SPECIFICO IL PRODOTTO SELEZIONATO
        $result = deleteCartItem($nomeUtente, $id);

        header('Location: ../cartPage.php');
        exit;
    }

?>