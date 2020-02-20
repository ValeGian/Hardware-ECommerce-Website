<?php

    function showProductList($ProdCount, $pageType, $tabella, $tipo, $produttore, $like, $sort, $prodPerPagina, $currPage){
        $lastPageProduct = $currPage * $prodPerPagina;
        
        echo    '<ul id="product_list" class="six-col">';
        
        if($sort == 'desc'){
            $sortQ = 'asc';
        }
        else{
            $sortQ = 'desc';
        }
        
        if($pageType == 'user')
            $result = getTableProducts($tabella, $tipo, $produttore, $sortQ);
        else if($pageType == 'admin' || $pageType == 'search')
            $resultA = getAllProducts($sortQ);
        
    //MOSTRO A SCHERMO TUTTI I PRODOTTI SELEZIONATI
        for($i = 1; $i <= $ProdCount; $i++){
            
            if($pageType == 'admin'){
                $row = $resultA->fetch_assoc();
                $id = $row['id_Prodotto'];
                $tabella = findTable($id);
                $result = getProductByID($tabella, $id);
            }
            else if($pageType == 'search'){
                $row = $resultA->fetch_assoc();
                $id = $row['id_Prodotto'];
                $result = getProductByIDLike($id, $like);
                $numRow = mysqli_num_rows($result);
                if($numRow == 0){
                    $i--;
                    continue;
                }
            }
            
            $row = $result->fetch_assoc();
            
            if($row['Acquistabile'] == 0){
                $i--;
                continue;
            }
            else{
                if( ($i >= ($currPage - 1) * $prodPerPagina + 1) && ($i <= $lastPageProduct)){
                
                    $id = $row['id_Prodotto'];
                    $tabella = findTable($id);
                    
                    $immagine = $row['Immagine'];
                    
                    if($immagine == ''){
                        $immagine = 'default_img.png';
                    }

                    $modello = $row['Modello'];
                    $prezzo = number_format($row['Prezzo'], 2);
                    $quantita = $row['Quantita'];

                    echo    '<li class="column-layout">';
                    echo        '<div class="base-product">';
                    echo            '<div class="product-container">';
                    echo                '<div class="container">';
                    echo                    '<div class="product-image-container">';
                    echo                        '<img src="../img/Products/'.$immagine.'" alt="Prodotto" class="immagine-responsive">';

                    if($quantita == 0){
                        echo                    '<sup  class="information">NON DISPONIBILE</sup>';
                    }

                    echo                    '</div>';
                    
                    if($pageType == 'admin' || ($pageType == 'search' && isset($_SESSION['NomeUtente']) && $_SESSION['NomeUtente'] == 'Admin')){
                        echo                '<a href="./admin_DelProdotto.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'" title="Elimina Prodotto" style="padding:0 10px 5px 10px;">';
                        echo                    '<img src="../css/img/trash.png" class="delete-icon" title="Elimina Prodotto" alt="Trash">';
                        echo                '</a>';
                        
                        echo                '<a href="./admin_ModProdotto.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'" title="Modifica Prodotto" style="padding:0 10px 5px 10px;">';
                        echo                    '<img src="../css/img/wrench.png" class="delete-icon" title="Modifica Prodotto" alt="Wrench">';
                        echo                '</a>';
                    }

                    if($pageType == 'user'){ 
                        echo                    '<div class="lista-carrello">';
                        
                        $urlGet = 'Tabella='.$tabella.'&Tipo='.$tipo.'&Produttore='.rawurlencode($produttore).'&Sort='.$sort.'&Page='.$currPage.'&ID='.$id.'&oldPage=PList&Acqu=1';
                        
                        echo                        '<a href="./operative_use/addToCart.php?'.$urlGet.'">';


                        if(isset($_SESSION['Logged']) && $_SESSION['Logged'] === true){
                            $nomeUtente = $_SESSION['NomeUtente'];

                            if(checkIfCart($nomeUtente, $id)){
                                $checked = 'Y';
                            }
                            else{
                                $checked = 'N';
                            }
                        }
                        else{
                            $checked = 'N';
                        }
                        echo                            '<span class="add-to-cart add-'.$checked.'Checked"> Aggiungi al Carrello</span>';
                        
                    echo                        '</a>';
                    echo                    '</div>';
                    }
                    else if($pageType == 'search' && (isset($_SESSION['NomeUtente']) && $_SESSION['NomeUtente'] != 'Admin')){
                        echo                    '<div class="lista-carrello">';
                        
                        $urlGet = 'Searching='.rawurlencode($like).'&Tabella='.$tabella.'&Tipo='.$tipo.'&Produttore='.rawurlencode($produttore).'&Sort='.$sort.'&Page='.$currPage.'&ID='.$id.'&oldPage=PList&Acqu=1';
                        
                        echo                        '<a href="./operative_use/addToCart.php?'.$urlGet.'">';


                        if(isset($_SESSION['Logged']) && $_SESSION['Logged'] === true){
                            $nomeUtente = $_SESSION['NomeUtente'];

                            if(checkIfCart($nomeUtente, $id)){
                                $checked = 'Y';
                            }
                            else{
                                $checked = 'N';
                            }
                        }
                        else{
                            $checked = 'N';
                        }
                        echo                            '<span class="add-to-cart add-'.$checked.'Checked"> Aggiungi al Carrello</span>';
                        
                    echo                        '</a>';
                    echo                    '</div>';
                    }


                    echo                '</div>';

                    echo                '<p class="product-name">'.$modello.'</p>';

                    echo                '<div class="product-bottom">';
                    echo                    '<span class="product-price">&euro;'.$prezzo.'</span>';
                    echo                    '<div class="button-container">';
                    echo                        '<a href="./productPage.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'" class="btn">';
                    echo                            '<span>Mostra di pi&ugrave;</span>';
                    echo                        '</a>';
                    echo                    '</div>';
                    echo                '</div>';
                    echo            '</div>';
                    echo        '</div>';
                    echo    '</li>';

                }
                
            }
            
            
        }

        echo    '</ul>';
    }

//MOSTRA IL CARRELLO DEI PRODOTTI
    function showCartProducts($cartItems, $nomeUtente, $spesa, $errorUrl, $pageType, $prodPerPagina, $currPage){
        
        $errorUrl = '';
        $lastPageProduct = $currPage * $prodPerPagina;
        $numRow = mysqli_num_rows($cartItems);
        
        switch($pageType){
            case 'cartPage':
                
                echo    '<table id="cart_summary" class="table">';
                        
                echo        '<thead>';
                echo            '<tr>';                    
                echo                '<th>Prodotto</th>';
                echo                '<th>Descrizione</th>';
                echo                '<th>Prezzo Unitario</th>';
                echo                '<th>Quant.</th>';
                echo                '<th></th>';
                echo                '<th>Totale</th>';
                echo            '</tr>';
                echo        '</thead>';

                echo        '<tbody>';
            //MOSTRO TUTTI I PRODOTTI NEL CARRELLO
                for($i=1; $i <= $numRow; $i++){ 
                //ESTRAGGO I DATI DEL PRODOTTO
                    $row1 = $cartItems->fetch_assoc();
                    
                    $quantitaC = $row1['C_Quantita'];
                    $quantitaP = $row1['P_Quantita'];
                    
                    $id = $row1['id_prodotto'];
                    $tabella = findTable($id);

                    $result2 = getProductByID($tabella, $id);
                    $row2 = $result2->fetch_assoc();

                    $modello = $row2['Modello'];
                //SE LA QUANTITA DEL PRODOTTO NEL CARRELLO SUPERA LA QUANTITA NEL MAGAZZINO, SALVO L'URL PER SEGNALARE POI L'IMPOSSIBILITà DI PROCEDERE CON L'ACQUISTO
                    if($quantitaC > $quantitaP && $errorUrl == ''){
                        $errorUrl = './cartPage.php?errorKind=cart_error&errorType=not_enough_product&Prodotto='.rawurlencode($modello).'&Quantita='.$quantitaP;

                    }
                    
                    if( ($i >= ($currPage - 1) * $prodPerPagina + 1) && ($i <= $lastPageProduct) ){
                        if($row2['Immagine'] == ''){
                            $immagine = 'default_img.png';
                        }
                        else{
                            $immagine = $row2['Immagine'];
                        }
                        $prezzo = number_format(round($row1['Prezzo'], 2), 2);
                        $prezzoFormattato = number_format(round($row1['Prezzo'], 2), 2, '.', '');
                        $spesaSingoloProdotto = number_format(round($prezzoFormattato * $quantitaC, 2), 2);

                    
                    //MOSTRO IL PRODOTTO
                        echo        '<tr>';

                        echo            '<td class="immagine">';
                        echo                '<a href="./productPage.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'">';
                        echo                    '<img src="../img/Products/'.$immagine.'" alt="Prodotto">';
                        echo                '</a>';
                        echo            '</td>';

                        echo            '<td>';
                        echo                '<a href="./productPage.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'" class="modello">'.$modello.'</a>';
                        echo            '</td>';

                        echo            '<td class="prezzo">';
                        echo                '<p>&euro; '.$prezzo.'</p>';
                        echo            '</td>';

                        echo            '<td class="quantita">';
                        echo                '<p id="product'.$id.'Quantity">'.$quantitaC.'</p>';
                        if($quantitaC != 1){
                        echo                '<span id="-modifier'.$id.'" class="ajaxCartModifiers" title="Togli 1 unit&agrave; di Prodotto" onclick="userCartProductEventHandler.onCartProductQuantityChangeEvent('.$id.', -1, '.$quantitaP.', \''.$modello.'\', '.$prezzoFormattato.', '.$currPage.')">-</span>';
                        }
                        echo                '<span id="+modifier'.$id.'" class="ajaxCartModifiers" title="Aggiungi 1 unit&agrave; di Prodotto" onclick="userCartProductEventHandler.onCartProductQuantityChangeEvent('.$id.', 1, '.$quantitaP.', \''.$modello.'\', '.$prezzoFormattato.', '.$currPage.')">+</span>';
                        echo            '</td>';

                        echo            '<td class="delete">';
                        echo                '<a href="./operative_use/productDelete.php?Submit=productDelete&Utente='.rawurlencode($nomeUtente).'&ID='.$id.'" title="Elimina Prodotto da Carrello">';
                        echo                    '<img src="../css/img/trash.png" class="delete-icon" title="Rimuovi Prodotto dal Carrello" alt="Trash">';
                        echo                '</a>';
                        echo            '</td>';

                        echo            '<td class="prezzo">';
                        echo                '<p id="spesaCartB'.$id.'">&euro; '.$spesaSingoloProdotto.'</p>';
                        echo            '</td>';

                        echo        '</tr>';
                    }
                }
                echo        '</tbody>';
                
                echo        '<tfoot>';
                echo            '<tr>';
                echo                '<td colspan=5>TOTALE</td>';
                echo                '<td colspan=1 id="spesaCartC">&euro; '.$spesa.'</td>';
                echo            '</tr>';
                echo        '</tfoot>';

                echo    '</table>';
                
                break;
            case 'purchasePage':
                
                echo    '<table id="purchase_summary" class="table">';
                        
                echo        '<thead>';
                echo            '<tr>';                    
                echo                '<th>Prodotto</th>';
                echo                '<th>Descrizione</th>';
                echo                '<th>Prezzo Unitario</th>';
                echo                '<th>Quant.</th>';
                echo                    '<th>Totale</th>';
                echo                '</tr>';
                echo            '</thead>';
                
                echo            '<tbody>';
            //MOSTRO TUTTI I PRODOTTI DA ACQUISTARE
                for($i=1; $i <= $numRow; $i++){ 
                //ESTRAGGO I DATI DEL PRODOTTO
                    $row1 = $cartItems->fetch_assoc();
                    
                    if( ($i >= ($currPage - 1) * $prodPerPagina + 1) && ($i <= $lastPageProduct) ){
                        
                        $id = $row1['id_prodotto'];
                        $tabella = findTable($id);
                        $suff = suffix($tabella);

                        $result2 = getProductByID($tabella, $id);
                        $row2 = $result2->fetch_assoc();

                        $modello = $row2['Modello'];
                        if($row2['Immagine'] == ''){
                            $immagine = 'default_img.png';
                        }
                        else{
                            $immagine = $row2['Immagine'];
                        }
                        $quantita = $row1['C_Quantita'];
                        $prezzo = number_format(round($row1['Prezzo'], 2), 2);

                    //MOSTRO IL PRODOTTO
                        echo        '<tr>';

                        echo            '<td class="immagine">';
                        echo                '<a href="./productPage.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'">';
                        echo                    '<img src="../img/Products/'.$immagine.'" alt="Prodotto">';
                        echo                '</a>';
                        echo            '</td>';

                        echo            '<td>';
                        echo                '<a href="./productPage.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'" class="modello">'.$modello.'</a>';
                        echo            '</td>';

                        echo            '<td class="prezzo">';
                        echo                '<p>&euro; '.$prezzo.'</p>';
                        echo            '</td>';

                        echo            '<td class="quantita">';
                        echo                '<p>'.$quantita.'</p>';
                        echo            '</td>';

                        echo            '<td class="prezzo">';
                        echo                '<p>&euro; '.number_format(round($prezzo*$quantita, 2), 2).'</p>';
                        echo            '</td>';

                        echo        '</tr>';
                    }
                }
                echo        '</tbody>';

                echo            '<tfoot>';
                echo                '<tr>';
                echo                    '<td colspan=4>TOTALE</td>';
                echo                    '<td colspan=1>&euro; '.$spesa.'</td>';
                echo                '</tr>';
                echo            '</tfoot>';

                echo    '</table>';
                
                break;
        }
        
        return $errorUrl;
        
    }

//MOSTRA IL CONTENUTO DELLO STORICO ACQUISTI
    function showUserOrdini($ordini, $utente, $pageType, $ordiniPerPagina, $currPage, $sort){
        
        $lastPageProduct = $currPage * $ordiniPerPagina;
        $numRow = mysqli_num_rows($ordini);
        if($pageType == 'userPage') $pageTypeValue = 0;
        else if($pageType == 'adminPage') $pageTypeValue = 1;
        
        for($i = 1; $i <= $numRow; $i++){
                            
            //ESTRAGGO I DATI DELL'ORDINE
                $row1 = $ordini->fetch_assoc();
            
                if( ($i >= ($currPage - 1) * $ordiniPerPagina + 1) && ($i <= $lastPageProduct) ){
                    $ordine = $row1['Codice_ordine'];
                    $data = $row1['Data'];
                    $cancellato = $row1['Cancellato'];
                    $pagato = $row1['Pagato'];
                    
                    if($pageType == 'adminPage'){
                        $utente = $row1['Nome_Utente'];
                        $nomeUtente = $row1['Nome'];
                        $cognomeUtente = $row1['Cognome'];
                        $indirizzoUtente = $row1['Indirizzo'];
                        $CAPUtente = $row1['Cod_Postale'];
                        $cittaUtente = $row1['Citta'];
                        $provinciaUtente = $row1['Provincia'];
                    }

                //CALCOLO LA SPESA DELL'ORDINE
                    $result2 = getSpesaOrdine($utente, $ordine);
                    $row2 = $result2->fetch_assoc();

                    $spesa = number_format(round($row2['Spesa'], 2), 2);

                //MOSTRO I DATI DELL'ORDINE
                    echo    '<div class="box container">';
                    
                    if($pageType == 'userPage')
                        echo    '<div class="ordine-header three-col">';
                    else if($pageType == 'adminPage')
                        echo    '<div class="ordine-header seven-col">';
        

                    echo            '<p id="open'.$ordine.'" class="open" onclick="showOrdine('.$ordine.')">+</p>';
                    
                    if($pageType == 'adminPage')
                        echo         '<p class="column-layout">CODICE ORDINE:<br>'.$ordine.'</p>';
                    
                    echo            '<p class="column-layout">ORDINE EFFETTUATO IN DATA:            <br>'.$data.'</p>';
                    
                    if($pageType == 'adminPage'){
                        echo        '<p class="column-layout">UTENTE (NOME COGNOME):            <br>'.$nomeUtente.' ('.$nomeUtente.' '.$cognomeUtente.')</p>';
                        echo        '<p class="column-layout">INDIRIZZO CONSEGNA (CAP):            <br>'.$indirizzoUtente.' ('.$CAPUtente.')</p>';
                        echo        '<p class="column-layout">CITTA (PROVINCIA):            <br>'.$cittaUtente.' ('.$provinciaUtente.')</p>';
                    }
                    
                    echo            '<p class="column-layout">TOTALE: <br> &euro; '.$spesa.'</p>';

                    if($cancellato == 1){
                        echo        '<div class="sold_flag">';
                        echo            '<img src="../css/img/cancellato.gif" alt="" title="Ordine Cancellato" class="immagine-responsive" style="padding-right: 10%;" alt="Ordine Cancellato">';
                        echo        '</div>';
                    }
                    else if($pagato == 0){
                        echo        '<div class="sold_flag">';
                        echo        '<img src="../css/img/da_pagare.gif" alt="" title="Ordine Da Pagare" class="immagine-responsive" style="padding-right: 20%;" alt="Ordine da Pagare">';

                        echo                '<a href="./operative_use/ordineDelete.php?Submit=ordineDelete&Utente='.rawurlencode($utente).'&Ordine='.$ordine.'&Sort='.$sort.'&Page='.$currPage.'&returnURL='.$pageTypeValue.'" style="padding-right: 8%;">';
                        echo                    '<img src="../css/img/trash.png" class="delete-icon" title="Cancella Ordine" class="immagine-responsive" alt="Trash">';
                        echo                '</a>';
                        
                        if($pageType == 'adminPage'){
                            echo            '<a href="./operative_use/ordineSetSold.php?Submit=ordineSetSold&Ordine='.$ordine.'&Sort='.$sort.'&Page='.$currPage.'">';
                            echo                '<img src="../css/img/dollar_bag.png" class="delete-icon" title="Setta Ordine Pagato" class="immagine-responsive" alt="Dollaro">';
                            echo             '</a>';
                        }
                    
                        echo        '</div>';
                    }
                    else{
                        echo        '<div class="sold_flag">';
                        echo            '<img src="../css/img/pagato.gif" alt="" title="Ordine Pagato" class="immagine-responsive" style="padding-right: 10%;" alt="Pagato">';
                        echo        '</div>';
                    }

                    echo            '<div class="clear"></div>';

                    echo        '</div>';


                    echo        '<div id="ordine'.$ordine.'" class="ordine-body">';
                //ESTRAGGO TUTTI I PRODOTTI DELL'ORDINE 
                    $result3 = getOrdineProducts($utente, $ordine);
                    $numRow3 = mysqli_num_rows($result3);

                    for($j = 1; $j <= $numRow3; $j++){
                        $row3 = $result3->fetch_assoc();
                        $id = $row3['id_prodotto'];
                        $tabella = findTable($id);

                    //ESTRAGGO I DATI DEL PRODOTTO
                        $prezzo = $row3['Prezzo'];
                        $quantita = $row3['Quantita'];

                        $result4 = getProductByID($tabella, $id);
                        $row4 = $result4->fetch_assoc();

                        $modello = $row4['Modello'];
                        if($row4['Immagine'] == ''){
                            $immagine = 'default_img.png';
                        }
                        else{
                            $immagine = $row4['Immagine'];
                        }

                        echo    '<div class="prodotto three-col">';

                        echo        '<a href="./productPage.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'" class="column-layout">';
                        echo            '<img src="../img/Products/'.$immagine.'" alt="Prodotto">';
                        echo        '</a>';

                        echo        '<div class="column-layout">';
                        echo            '<a href="./productPage.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'" class="modello">'.$modello.'</a>';
                        echo        '</div>';

                        echo        '<div class="column-layout">';
                        echo            '<p class="prezzo">Prezzo: &euro; '.$prezzo.'</p>';
                        echo            '<p>Quantita: '.$quantita.'</p>';
                        echo        '</div>';

                        echo        '<div class="clear"></div>';

                        echo    '</div>';
                    }

                    echo        '</div>';


                    echo    '</div>';
                }
            }
    }

//MOSTRA A SCHERMO LA BARRA DI PAGINAZIONE, CON LA GRAFICA ADATTA IN BASE A QUAL'è LA PAGINA CORRENTE
    function showBarPages($MaxPage, $currPage, $returnFlagUrl){     
        
        echo    '<ul class="pagination_bar">';
        
        if($currPage != 1){
            echo    '<li>';
            echo        '<a href="'.$returnFlagUrl.'">';
            echo            '<span>1</span>';
            echo        '</a>';
            echo    '</li>';
        }
        
        
        $puntiniPre = FALSE;
        $puntiniPost = FALSE;
        for($i = 1; $i <= $MaxPage; $i++){
            
            if($i == $currPage){  //SE L'INDICE EQUIVALE ALLA PAGINA CORRENTE
                echo    '<li id="current-Page">';
                echo        '<span>'.$currPage.'</span>';
                echo    '</li>';
            }
            
            if($i != 1 && $i == $currPage - 1){   //SE L'INDICE NON è 1 ED EQUIVALE ALLA PAGINA PRECEDENTE ALLA CORRENTE
                echo    '<li>';
                echo        '<a href="'.$returnFlagUrl.'&Page='.$i.'">';
                echo            '<span>'.$i.'</span>';
                echo        '</a>';
                echo    '</li>';
            }
            
            if($i != $MaxPage && $i == $currPage + 1){   //SE L'INDICE EQUIVALE ALLA PAGINA SUCCESSIVA ALLA CORRENTE (SE NON è L'ULTIMA)
                echo    '<li>';
                echo        '<a href="'.$returnFlagUrl.'&Page='.$i.'">';
                echo            '<span>'.$i.'</span>';
                echo        '</a>';
                echo    '</li>';
            }
            
            if($i < $currPage - 1 && $currPage != 3 && !$puntiniPre){  //INSERISCO UNO STACCO IN CASO SERVISSE
                $puntiniPre = TRUE;
                echo    '<li>';
                echo        '<span>...</span>';
                echo    '</li>';
            }
            
            if($i > $currPage + 1 && $MaxPage != $currPage + 2 && !$puntiniPost){  //INSERISCO UNO STACCO IN CASO SERVISSE
                $puntiniPost = TRUE;
                echo    '<li>';
                echo        '<span>...</span>';
                echo    '</li>';
            }
            
            
        }
        
        
        if($MaxPage != 1 && $currPage != $MaxPage){
            echo    '<li>';
            echo        '<a href="'.$returnFlagUrl.'&Page='.$MaxPage.'">';
            echo            '<span>'.$MaxPage.'</span>';
            echo        '</a>';
            echo    '</li>';
        }
        
        echo    '</ul>';
    }

//SETTO IL SUFFISSO ADATTO IN BASE AL TIPO DI PRODOTTO INSERITO
    function suffix($tabella){  
        
        $suff = '';
        
        switch($tabella){  
            case 'computer':
                $suff = '_C';
                break;
            case 'memoria':
                $suff = '_M';
                break;
            case 'tablet':
                $suff = '_T';
                break;
            case 'periferica':
                $suff = '_P';
                break;
            case '-':
                $suff = '';
                break;
        }
        
        return $suff;
    }


//COMPONE IL where DELLA QUERY
    function queryWhere($tabella, $tipo, $produttore, $suff){     
        $queryText = '';
        
        if($tipo != '' || $produttore != ''){
            $queryText.= ' where ';
            
            if($tipo != ''){
                $queryText.= 'Tipo'.$suff.' = "'.$tipo.'"';
                
                if($produttore != ''){
                    if($produttore != 'Altro'){
                        $queryText.= ' and Produttore = "'.$produttore.'"';
                    }
                    else{
                        $altro = produttoreAltro($tipo);
                        $queryText.= ' and '.$altro;
                    }
                }
            }
            else if($produttore != ''){
                if($produttore != 'Altro'){
                        $queryText.= ' Produttore = "'.$produttore.'"';
                    }
                    else{
                        $altro = produttoreAltro($tipo);
                        $queryText.= ' '.$altro;
                    }
            }
        }
        
        return $queryText;
    }

//DA USARE QUANDO IL PRODUTTORE è SETTATO SU 'ALTRO', RITORNA UNA STRINGA UTILI PER EFFETTUARE QUERY SU TUTTI I PRODUTTORI ALTERNATIVI AI PRINCIPALI
    function produttoreAltro($tipo){    
        $ret = '';
        
        switch($tipo){
            case 'notebook':
            case 'pc_desktop':
                $ret = ' Produttore <> "Acer" and Produttore <> "Apple" and Produttore <> "Asus" and Produttore <> "lenovo"';
                break;
            case 'workstation':
                $ret = 'Produttore <> "Dell" and Produttore <> "Fujitsu" and Produttore <> "Lenovo"';
                break;
            case '':
                $ret = 'Produttore <> "Apple" and Produttore <> "Huawei" and Produttore <> "Samsung"';
        }
        
        return $ret;
    }

?>