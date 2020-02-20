<?php
    if(isset($_POST['Submit_Prodotto'])){
        require_once "../pathConfig.php";
        require_once DIR_UTIL."ECommerceDbManager.php";//includo la classe per la gestione del database

        $errorType = null;
        $errorKind = 'productModification_error';

        $tipo = $_POST['tipo_prodotto'];

        $suff = suffix($tipo);  //SETTO IL SUFFISSO ADATTO IN BASE AL TIPO DI PRODOTTO MODIFICATO

    //SETTO LE VARIABILI DAI POST
        $modello = $_POST['Modello'.$suff];
        $descrizione = $_POST['Descrizione'.$suff];
        $quantita = $_POST['Quantita'.$suff];
        $prezzo = $_POST['Prezzo'.$suff];
        
    //SETTO I PARAMETRI PER IL SALVATAGGIO DELL'IMMAGINE
        $immagine = $_FILES['Immagine'.$suff];
        
        if($immagine == '')
            $immagineUniqueName = '';
        else{
            $immagineName = $immagine['name'];
            $immagineTmpName = $immagine['tmp_name'];
            $immagineSize = $immagine['size'];
            $immagineError = $immagine['error'];

            $immagineExt = explode('.', $immagineName);
            $immagineActualExt = strtolower(end($immagineExt));

            $allowed = array('jpg', 'jpeg', 'png');

        //CONTROLLO SE L'IMMAGINE è VALIDA
            if(!in_array($immagineActualExt, $allowed) && $immagineName != ''){
                $errorType = 'tipo_img_error';
                header('Location: ../admin_ModProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType ); //IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

            if($immagineError !== 0 && $immagineName != ''){
                $errorType = '';
                header('Location: ../admin_ModProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType ); //IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

            if($immagineSize >= 1000000){   //SE L'IMMAGINE PESA PIù DI 1Mb
                $errorType = 'img_size_error';
                header('Location: ../admin_ModProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType ); //IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

        //SPOSTO L'IMMAGINE NELLA CARTELLA ./img/Products
            if($immagineName != ''){
                $immagineUniqueName = uniqid('', true).'.'.$immagineActualExt;
                $immagineDest = DIR_PRODUCTS_IMG.$immagineUniqueName;
                move_uploaded_file($immagineTmpName, $immagineDest);
            }
            else{
                $immagineUniqueName = '';
            }
        }
        
    //SEGNALO EVENTUALI ERRORI
        if($prezzo <= 0 && $prezzo !== ''){
            $errorType = 'prezzo_neg_error';
            header('Location: ../admin_ModProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType ); //IN CASO DI ERRORE, LO SEGNALO
            exit;
        }

        if($tipo === '-' || $modello === ''){    //SE IL PRODOTTO NON è SELEZIONATO, NON LO FACCIO MODIFICARE
            $errorType = 'product_does_not_exist_error';
            header('Location: ../admin_ModProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );
            exit;
        }

        //ESTRAGGO  I VECCHI DATI DEL PRODOTTO RELATIVO ALL'ELEMENTO DA MODIFICARE 
        $result = getProduct($tipo, $modello);
        $row = $result->fetch_assoc();

        $id = $row['id'.$suff];
        $Old_immagine = $row['Immagine'];
        $Old_descrizione = $row['Descrizione'];
        $Old_prezzo = $row['Prezzo'];
        $Old_quantita = $row['Quantita'];

        //CONTROLLO I VECCHI VALORI 
        if($immagineName == ''){
            $immagine = $Old_immagine;
        }

        if($descrizione == ''){
            $descrizione = $Old_descrizione;
        }

        if($prezzo == ''){
            $prezzo = $Old_prezzo;
        }

        $Delta_quantita = $Old_quantita + $quantita;
        if($Delta_quantita < 0){
            $Delta_quantita = 0;
        }

        //ESEGUO LA MODIFICA DEL PRODOTTO
        modProduct($tipo, $id, $prezzo, $Delta_quantita, $immagineUniqueName, $descrizione, $errorKind);

        header('Location: ../admin_ModProdotto.php?Message=p_succ_mod');
        exit;
    }

?>