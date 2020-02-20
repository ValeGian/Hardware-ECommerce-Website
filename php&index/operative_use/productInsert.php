<?php
    if(isset($_POST['Submit_Prodotto'])){
        
        require_once "../pathConfig.php";
        require_once DIR_UTIL."ECommerceDbManager.php"; //INCLUDO LE FUNZIONI DI UTILITà PER ACCEDERE AL DATABASE

        $errorType = null;
        $errorKind = 'productInsertion_error';

        $tipo = $_POST['tipo_prodotto'];

        $suff = suffix($tipo);  //SETTO IL SUFFISSO ADATTO IN BASE AL TIPO DI PRODOTTO MODIFICATO
        
    //SETTO LE VARIABILI DAI POST
        $modello = strtolower($_POST['Modello'.$suff]);
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
                header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType ); //IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

            if($immagineError !== 0 && $immagineName != ''){
                $errorType = '';
                header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType ); //IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

            if($immagineSize >= 1000000){   //SE L'IMMAGINE PESA PIù DI 1Mb
                $errorType = 'img_size_error';
                header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType ); //IN CASO DI ERRORE, LO SEGNALO
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
        
    //CREO IL PRODOTTO
        $prodotto = new Prodotto($modello, $descrizione, $immagineUniqueName);

    //SEGNALO EVENTUALI ERRORI
        if($modello === ''){
            $errorType = 'form_compile_error';
            header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType ); //IN CASO DI ERRORE, LO SEGNALO
            exit;
        }
        
        if($prezzo < 0){
            $errorType = 'prezzo_neg_error';
            header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType ); //IN CASO DI ERRORE, LO SEGNALO
            exit;
        }

        if($quantita < 0){
            $errorType = 'quantita_neg_error';
            header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );
            exit;
        }

        if($tipo != '-' && existsProduct($tipo, $modello)){    //SE IL PRODOTTO ESISTE GIà NEL DATABASE, NON LO FACCIO INSERIRE
            $errorType = 'product_already_exists_error';
            header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );
            exit;
        }

        if($tipo === 'computer'){   //SE SI VUOLE INSERIRE UN NUOVO COMPUTER
            $prodotto->tipo = $_POST['Tipo_C'];
            $prodotto->produttore = strtolower($_POST['Produttore_C']);
            $prodotto->mem_SSD = $_POST['Mem_SSD_C'];
            $prodotto->mem_HDD = $_POST['Mem_HDD_C'];
            $prodotto->u_Misura_HDD = $_POST['u_misura_mem_C'];
            $prodotto->mem_RAM = $_POST['Mem_RAM_C'];
            $prodotto->scheda_Video = $_POST['Scheda_Video_C'];


            if($prodotto->tipo === '-' || $prodotto->produttore === '' || $prodotto->mem_RAM === 0){
                $errorType = 'form_compile_error';
                header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

                if(preg_match('/[,][.][-]/', $prodotto->mem_SSD) || preg_match('/^[0]/', $prodotto->mem_SSD) || preg_match('/[,][.][-]/', $prodotto->mem_SSD) || preg_match('/^[0]/', $prodotto->mem_SSD) || preg_match('/[,][.][-]/', $prodotto->mem_RAM) || preg_match('/^[0]/', $prodotto->mem_RAM) || $prodotto->mem_RAM < 0){
                $errorType = 'reg_expr_error';
                header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

        }
        else if($tipo === 'memoria'){   //SE SI VUOLE INSERIRE UNA NUOVA MEMORIA
            $prodotto->tipo = $_POST['Tipo_M'];
            $prodotto->q_Mem = $_POST['Q_Memoria_M'];
            $prodotto->u_Misura_Mem = $_POST['u_misura_mem_M'];
            $prodotto->velocita = $_POST['Velocita_M'];


            if($prodotto->tipo === '-' || $prodotto->q_Mem === 0 || $prodotto->velocita === 0){
                $errorType = 'form_compile_error';
                header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

            if(preg_match('/[,][.]/', $prodotto->q_Mem) || preg_match('/^[0]/', $prodotto->q_Mem) || preg_match('/[,][.]/', $prodotto->velocita) || preg_match('/^[0]/', $prodotto->velocita) || $prodotto->q_Mem < 0 || $prodotto->velocita < 0){

                $errorType = 'reg_expr_error';
                header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

        }
        else if($tipo === 'tablet'){    //SE SI VUOLE INSERIRE UN NUOVO TABLET
            $prodotto->produttore = strtolower($_POST['Produttore_T']);
            $prodotto->risoluzione = $_POST['Risoluzione_T'];
            $prodotto->dim_Schermo = $_POST['Dim_Schermo_T'];
            $prodotto->capacita_Mem = $_POST['Capacita_Mem_T'];


            if($prodotto->produttore === '' || $prodotto->risoluzione === '' || $prodotto->dim_Schermo === 0 || $prodotto->capacita_Mem === 0){
                $errorType = 'form_compile_error';
                header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

            if(preg_match('/[,][.][-]/', $prodotto->dim_Schermo) || preg_match('/^[0]/', $prodotto->dim_Schermo) || preg_match('/[,][.][-]/', $prodotto->capacita_Mem) || preg_match('/^[0]/', $prodotto->capacita_Mem) || $prodotto->dim_Schermo < 0 || $prodotto->capacita_Mem < 0){
                $errorType = 'reg_expr_error';
                header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

            if(!preg_match('/[1-9][0-9]+[x][1-9][0-9]+/', $prodotto->risoluzione) || preg_match('/^[0]/', $prodotto->risoluzione)){
                $errorType = 'reg_expr_error';
                header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, LO SEGNALO
                exit;
            }

        }
        else if($tipo === 'periferica'){    //SE SI VUOLE INSERIRE UNA NUOVA PERIFERICA
            $prodotto->tipo = $_POST['Tipo_P'];
            if($prodotto->tipo === '-'){
                $errorType = 'form_compile_error';
                header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, LO SEGNALO
                exit;
            }
        }


    //INSERISCO IL PRODOTTO
        $result = insertProduct($prezzo, $quantita, $tipo, $prodotto);
        if(!$result){
            $errorType = 'add_product_error';
            header('Location: ../admin_InsProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType);//IN CASO DI ERRORE, LO SEGNALO
            exit;
        }

        header('Location: ../admin_InsProdotto.php?Message=p_succ_ins&'.$modello.$prodotto->product_model);
        exit;
        
        }

?>