<?php
    if(isset($_GET['Submit']) && $_GET['Submit'] == 'ordineDelete'){
        require_once "../pathConfig.php";
        require_once DIR_UTIL."ECommerceDbManager.php"; //INCLUDO LE FUNZIONI DI UTILITà PER ACCEDERE AL DATABASE

    //SETTO LE VARIABILI CHE MI SERVONO
        $nomeUtente = $_GET['Utente'];
        $ordine = $_GET['Ordine'];
        $returnURL = $_GET['returnURL']; //0 -> storicoAcquistiPage - 1->admin_VisOrdini
        
        if(!isset($_GET['Page']))
            $page = 1;
        else
            $page = $_GET['Page'];
        
        if(!isset($_GET['Sort']) || $_GET['Sort'] === '')
            $sortFlag = '';
        else
            $sortFlag = '&Sort='.$_GET['Sort'];

    //ELIMINO DAL CARRELLO SPECIFICO IL PRODOTTO SELEZIONATO
        $result = deleteOrdine($nomeUtente, $ordine);

        if(!$result){
            if($returnURL == 0){
                header('Location: ../storicoAcquistiPage.php?errorKind=ordineDel_error&Page='.$page);
                exit;
            }
            else if($returnURL == 1){
                header('Location: ../admin_VisOrdini.php?errorKind=ordineDel2_error&Page='.$page.$sortFlag);
                exit;
            }
        }

        $result = getOrdine($ordine);
        $row = $result->fetch_assoc();
        $data = $row['Data'];
        if($returnURL == 0){
            header('Location: ../storicoAcquistiPage.php?Message=ordine_succ_elimina&Data_Ordine='.$data.'&Page='.$page);
            exit;
        }
        else if($returnURL == 1){
            header('Location: ../admin_VisOrdini.php?Message=ordine_succ_elimina2&Data_Ordine='.$data.'&Page='.$page.$sortFlag);
            exit;
        }
    }

?>