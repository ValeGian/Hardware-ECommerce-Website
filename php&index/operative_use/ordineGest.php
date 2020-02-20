<?php
    if(isset($_POST['Submit_Prodotto'])){
        require_once "../pathConfig.php";
        require_once DIR_UTIL."ECommerceDbManager.php"; //INCLUDO LE FUNZIONI DI UTILITà PER ACCEDERE AL DATABASE

        $errorType = null;
        $errorKind = 'ordineGest_error';

        $gestione = $_POST['Gestione'];
        $ordine = $_POST['Ordine'];

        if($gestione === '' || $ordine === ''){    //SE NON è SELEZIONATO COME GESTIRE L'ORDINE O NON è SELEZIONATO L'ORDINE DA GESTIRE, SEGNALO ERRORE
            $errorType = 'form_compile_error';

            header('Location: ../admin_GestOrdini.php?errorKind='.$errorKind.'&errorType=' . $errorType );
            exit;
        }

        if($gestione == 'elimina'){
            $result = setOrdineCancellato($ordine);
        }
        else if($gestione == 'pagato'){
            $result = setOrdinePagato($ordine);
        }

        header('Location: ../admin_GestOrdini.php?Message=ordine_succ_'.$gestione.'3&Ordine='.$ordine);
        exit;
    }

?>