<?php   //IN PRESENZA DI ERRORI, LI SEGNALO
    if (isset($_GET['errorType'])){
        echo '<div class="alert-error" id="alert-container">';
        
        switch($_GET['errorKind']){ //SEGNALO IL TIPO GENERICO DI ERRORE
            case 'login_error':
                echo  '<a href ="./loginPage.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELL\'AUTENTICAZIONE:</strong>';
                break;
            case 'ac_creation_error':
                echo  '<a href ="./loginPage.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELLA CREAZIONE DELL\'ACCOUNT:</strong>';
                break;
            case 'ac_reg_error':
                echo  '<a href ="./registrationPage.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELLA REGISTRAZIONE DELL\'ACCOUNT:</strong>';
                break;
            case 'productInsertion_error':
                echo  '<a href ="./admin_InsProdotto.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELL\' INSERIMENTO DEL PRODOTTO:</strong>';
                break;
            case 'productModification_error':
                echo  '<a href ="./admin_ModProdotto.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELLA MODIFICA DEL PRODOTTO:</strong>';
                break;
            case 'productDelete_error':
                echo  '<a href ="./admin_DelProdotto.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELLA ELIMINAZIONE DEL PRODOTTO:</strong>';
                break;
            case 'add_to_cart':
                $currPage = $_GET['Page'];
                
                if(isset($_GET['Sort']))
                    $sort = $_GET['Sort'];
                else
                    $sort = 'desc';
            
                if(isset($_GET['Tabella']))
                    $tabella = $_GET['Tabella'];

                if(isset($_GET['Tipo']))
                    $tipo = $_GET['Tipo'];
                else 
                    $tipo = '';

                if(isset($_GET['Produttore']))
                    $produttore = $_GET['Produttore'];
                else
                    $produttore = '';
                
                if(isset($_GET['Searching']))
                    $urlGet = 'Searching='.$like.'&Sort='.$sort.'&Page='.$currPage;
                else
                    $urlGet = 'Tabella='.$tabella.'&Tipo='.$tipo.'&Produttore='.rawurlencode($produttore).'&Sort='.$sort.'&Page='.$currPage;
                
                echo  '<a href ="./productListPage.php?'.$urlGet.'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELL\'INSERIMENTO NEL CARRELLO:</strong>';
                break;
            case 'add_to_cart_2':
                $tabella = $_GET['Tabella'];
                $modello = $_GET['Modello'];
                $urlGet = 'Tabella='.$tabella.'&Modello='.rawurlencode($modello);
                echo  '<a href ="./productPage.php?'.$urlGet.'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELL\'INSERIMENTO NEL CARRELLO:</strong>';
                break;
            case 'cart_error':
                echo  '<a href ="./cartPage.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELL\'INSERIMENTO NEL CARRELLO:</strong>';
                break;
            case 'mod_dati_error':
                $indirizzo = $_GET['Indirizzo'];
                $cap = $_GET['Cap'];
                $citta = $_GET['Citta'];
                $provincia = $_GET['Provincia'];
                $email = $_GET['Email'];
                $url = $_GET['Url'].'&Indirizzo='.rawurlencode($indirizzo).'&Cap='.$cap.'&Citta='.rawurlencode($citta).'&Provincia='.rawurlencode($provincia).'&Email='.$email;
                echo  '<a href ="./userModPage.php?Url='.$url.'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELLA MODIFICA DEI DATI:</strong>';
                break;
            case 'mod_ind_error':
                $email = $_GET['Email'];
                echo  '<a href ="./userModPage.php?Change=email&Email='.$email.'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELLA MODIFICA DELLA EMAIL:</strong>';
                break;
            case 'ordineGest_error':
                echo  '<a href ="./admin_GestOrdini.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELLA GESTIONE DELL\'ORDINE:</strong>';
                break;
            case 'ordineDel_error':
                if(!isset($_GET['Page']))
                    $page = 1;
                else
                    $page = $_GET['Page'];
                
                echo  '<a href ="./storicoAcquistiPage.php?Page='.$_GET['Page'].'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELLA ELIMINAZIONE DI UN ORDINE:</strong>';
                break;
            case 'ordineDel2_error':
                if(!isset($_GET['Page']))
                    $page = 1;
                else
                    $page = $_GET['Page'];
                
                if(!isset($_GET['Sort']))
                    $sortFlag = '';
                else
                    $sortFlag = '&Sort='.$_GET['Sort'];
                
                echo  '<a href ="./admin_VisOrdini.php?Page='.$_GET['Page'].$sortFlag.'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NELLA ELIMINAZIONE DI UN ORDINE:</strong>';
                break;
            case 'ordineSetSold_error':
                if(!isset($_GET['Page']))
                    $page = 1;
                else
                    $page = $_GET['Page'];
                
                if(!isset($_GET['Sort']))
                    $sortFlag = '';
                else
                    $sortFlag = '&Sort='.$_GET['Sort'];
                
                echo  '<a href ="./admin_VisOrdini.php?Page='.$_GET['Page'].$sortFlag.'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>ERRORE NEL SETTARE L\'ORDINE COME VENDUTO:</strong>';
                break;
            default:
                echo  '<a href ="#"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>ERRORE:</strong>';
                break;
        }
        
        
        switch($_GET['errorType']){ //SEGNALO IL TIPO SPECIFICO DI ERRORE
            case 'query_error':
                echo  '<br> Errore nella Query.';
                break;
            case 'form_compile_error':
                echo  '<br> Errore nella compilazione del form. Riempire TUTTI i campi contrassegnati obbligatori.';
                break;
            case 'reg_expr_error':
                echo  '<br> Errore nella compilazione del form. Riempire i campi con valori validi.';
                break;
            case 'privacy_check_error':
                echo  '<br>Devi accettare i termini e condizioni relativi all\'informativa sulla privacy.';
                break;
            case 'email_crea_error':
                echo  '<br>Esiste gi&agrave; un account con questo indirizzo email.';
                break;
            case 'utente_already_exists_error':
                echo  '<br>Esiste gi&agrave un account con questo nome utente.';
                break;
            case 'utente_dnot_exists_error':
                echo  '<br>L\'utente non &egrave; registrato nel database.';
                break;
            case 'password_error':
                echo  '<br>La password inserita &egrave; errata.';
                break;
            case 'password_conf':
                echo  '<br>La password di conferma e la password inserita non corrispondono.';
                break;
            case 'provincia_error':
                echo  '<br>Non &egrave; stata selezionata una provincia.';
                break;
            case 'reg_failure':
                echo  '<br>&Egrave; stato riscontrato un errore durante la registrazione dell\'account, preghiamo di ripetere l\'iscrizione.';
                break;
            case 'prezzo_neg_error':
                echo  '<br>Non pu&ograve; venir inserito un prezzo negativo.';
                break;
            case 'quantita_neg_error':
                echo  '<br>Non pu&ograve; venir inserita una quantit&agrave; negativa.';
                break;
            case 'product_already_exists_error':
                echo  '<br>Il prodotto esiste gi&agrave; nel database. Per modificarne i dati/inserine altre unit&agrave; in magazzino, usare la sezione "MODIFICA PRODOTTI".';
                break;
            case 'product_does_not_exist_error':
                echo  '<br>Il prodotto NON esiste nel database.';
                break;
            case 'add_product_error':
                echo  '<br>&Egrave; stato impossibile inserire il prodotto nel database.';
                break;
            case 'mod_product_error':
                echo  '<br>&Egrave; stato impossibile modificare il prodotto nel database.';
                break;
            case 'cart_not_logged':
                echo  '<br>Bisogna essere loggati per poter inserire prodotti nel carrello.';
                break;
            case 'add_cart_error':
                echo  '<br>&Egrave; stato impossibile aggiungere il prodotto nel carrello.';
                break;
            case 'already_in_cart':
                echo  '<br>il Prodotto &egrave; gi&agrave; nel carrello.';
                break;
            case 'not_enough_product':
                if($_GET['Quantita'] == 0) $postfix = 'eliminare tale prodotto.';
                else $postfix = 'ridurre tale quantit&agrave;.';
                    
                echo  '<br>La quantit&agrave; del prodotto '.$_GET['Prodotto'].' supera quella disponibile in magazzino('.$_GET['Quantita'].'). Per poter proseguire con l\'acquisto occorrer&agrave; '.$postfix;
                break;
            case 'prod_not_acquirable':
                echo  '<br>il Prodotto NON &egrave; acquistabile.';
                break;
            case 'tipo_img_error':
                echo  '<br>il Tipo dell\'immagine caricata non &egrave; supportato.';
                break;
            case 'img_size_error':
                echo  '<br>l\'immagine caricata &egrave; troppo grande.';
                break;
            default:
                echo '<br>errore nell\'inserimento della immagine.';
                break;
            
        }
        
        echo      '</p>';
        echo '</div>';
    }
?>