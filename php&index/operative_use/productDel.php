<?php
    if(isset($_POST['Submit_Prodotto'])){
        require_once "../pathConfig.php";
        require_once DIR_UTIL."ECommerceDbManager.php"; //INCLUDO LE FUNZIONI DI UTILITà PER ACCEDERE AL DATABASE
        require_once DIR_UTIL."utilFunctions.php";

        $errorType = null;
        $errorKind = 'productDelete_error';

        $tipo = $_POST['tipo_prodotto'];

        $suff = suffix($tipo);  //SETTO IL SUFFISSO ADATTO IN BASE AL TIPO DI PRODOTTO MODIFICATO

        $modello = $_POST['Modello'.$suff];

        if($tipo === '-' || $modello === ''){    //SE IL PRODOTTO NON è STATO SELEZIONATO, NON LO FACCIO ELIMINARE
            $errorType = 'product_does_not_exist_error';
            header('Location: ../admin_DelProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );
            exit;
        }

        //ESEGUO L'ELIMINAZIONE DEL PRODOTTO
        $result = deleteProduct($tipo, $modello);

        header('Location: ../admin_DelProdotto.php?Message=p_succ_del');
        exit;
    }

?>