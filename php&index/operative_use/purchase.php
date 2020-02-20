<?php
    if(isset($_GET['Submit']) && $_GET['Submit'] == 'purchase'){
        require_once "../pathConfig.php";
        require_once DIR_UTIL."ECommerceDbManager.php";//la includo per la funzione 'findTable'

        $nomeUtente = $_GET['Utente'];

    //CONTROLLO LA DISPONIBILITà IN MAGAZZINO DEI PRODOTTI
        $result1 = getAllCartItems($nomeUtente);
        $numRow = mysqli_num_rows($result1);

        for($i=1; $i <= $numRow; $i++){ //PER OGNI PRODOTTO NEL CARRELLO
            $row1 = $result1->fetch_assoc();
            $id = $row1['id_prodotto'];
            $tabella = findTable($id);
            $result2 = getProductByID($tabella, $id);
            $row2 = $result2->fetch_assoc();

            $modello = $row2['Modello'];
            $quantitaC = $row1['C_Quantita'];
            $quantitaP = $row1['P_Quantita'];

            //SE LA QUANTITA DEL PRODOTTO NEL CARRELLO SUPERA LA QUANTITA NEL MAGAZZINO, SEGNALO L'IMPOSSIBILITà DI PROCEDERE CON L'ACQUISTO
            if($quantitaC > $quantitaP){

                header('Location: ../cartPage.php?errorKind=cart_error&errorType=not_enough_product&Prodotto='.$modello.'&Quantita='.$quantitaP);
                exit;

            }
        }

    //INSERISCO IL NUOVO ORDINE
        $result = insertOrdine($nomeUtente);

    //INSERISCO TUTTI I PRODOTTI NELLO STORICO ACQUISTI
        $result1 = getAllCartItems($nomeUtente);
        $numRow = mysqli_num_rows($result1);

        for($i = 1; $i <= $numRow; $i++){
            $row1 = $result1->fetch_assoc();
            $id_prodotto = $row1['id_prodotto'];
            $prezzo = $row1['Prezzo'];
            $quantita = $row1['C_Quantita'];

        //INSERISCO IL PRODOTTO NELLO STORICO ACQUISTI
            $result2 = insertProductIntoStorico($id_prodotto, $prezzo, $quantita);

        //RIDUCO LA QUANTITA DEL PRODOTTO IN MAGAZZINO
            $newQuantita = $row1['P_Quantita'] - $quantita;
            $result3 = updateProductQuantity($id_prodotto, $newQuantita);
        }

    //SVUOTO IL CARRELLO
        $result = emptyCart($nomeUtente);

        header('Location: ../storicoAcquistiPage.php?Message=ordine_succ_sent');
        exit;
    }

?>