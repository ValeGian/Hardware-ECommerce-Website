<?php //IN PRESENZA DI MESSAGGI LI SEGNALO

    if(isset($_GET['Message'])){
        
        echo '<div class="alert-message" id="alert-container">';
        
        switch($_GET['Message']){ //SEGNALO IL TIPO GENERICO DI ERRORE
            case 'cart_succ_ins_LPage':
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
                    $urlGet = 'Searching='.rawurlencode($like).'&Sort='.$sort.'&Page='.$currPage;
                else
                    $urlGet = 'Tabella='.$tabella.'&Tipo='.$tipo.'&Produttore='.rawurlencode($produttore).'&Sort='.$sort.'&Page='.$currPage;
                
                echo  '<a href ="./productListPage.php?'.$urlGet.'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>PRODOTTO INSERITO CON SUCCESSO NEL CARRELLO</strong>';
                break;
            case 'cart_succ_ins_PPage':
                $tabella = $_GET['Tabella'];
                $modello = $_GET['Modello'];
                $urlGet = 'Tabella='.$tabella.'&Modello='.rawurlencode($modello);
                echo  '<a href ="./productPage.php?'.$urlGet.'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<p><strong>PRODOTTO INSERITO CON SUCCESSO NEL CARRELLO</strong>';
                break;
            case 'email_succ_changed':
                echo  '<a href ="./personal_InfoPage.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>EMAIL MODIFICATA CON SUCCESSO</strong>';
                break;
            case 'address_succ_changed':
                echo  '<a href ="./personal_InfoPage.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>INDIRIZZO DI CONSEGNA MODIFICATA CON SUCCESSO</strong>';
                break;   
            case 'p_succ_ins':
                echo  '<a href ="./admin_InsProdotto.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>PRODOTTO INSERITO CON SUCCESSO</strong>';
                break;
            case 'p_succ_mod':
                echo  '<a href ="./admin_ModProdotto.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>PRODOTTO MODIFICATO CON SUCCESSO</strong>';
                break;
            case 'p_succ_del':
                echo  '<a href ="./admin_DelProdotto.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>PRODOTTO ELIMINATO CON SUCCESSO</strong>';
                break;
            case 'ordine_succ_sent':
                echo  '<a href ="./storicoAcquistiPage.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>ORDINE EFFETTUATO CON SUCCESSO</strong>';
                break;
            case 'ordine_succ_elimina':
                if(!isset($_GET['Page']))
                    $page = 1;
                else
                    $page = $_GET['Page'];
                
                echo  '<a href ="./storicoAcquistiPage.php?Page='.$_GET['Page'].'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>ORDINE DEL '.$_GET['Data_Ordine'].' CANCELLATO CON SUCCESSO</strong>';
                break;
            case 'ordine_succ_elimina2':
                if(!isset($_GET['Page']))
                    $page = 1;
                else
                    $page = $_GET['Page'];
                
                if(!isset($_GET['Sort']))
                    $sortFlag = '';
                else
                    $sortFlag = '&Sort='.$_GET['Sort'];
                
                echo  '<a href ="./admin_VisOrdini.php?Page='.$_GET['Page'].$sortFlag.'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>ORDINE DEL '.$_GET['Data_Ordine'].' CANCELLATO CON SUCCESSO</strong>';
                break;
            case 'ordine_succ_elimina3':
                echo  '<a href ="./admin_GestOrdini.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>ORDINE ('.$_GET['Ordine'].') CANCELLATO CON SUCCESSO</strong>';
                break;
            case 'ordine_succ_pagato':
                if(!isset($_GET['Page']))
                    $page = 1;
                else
                    $page = $_GET['Page'];
                
                if(!isset($_GET['Sort']))
                    $sortFlag = '';
                else
                    $sortFlag = '&Sort='.$_GET['Sort'];
                
                echo  '<a href ="./admin_VisOrdini.php?Page='.$_GET['Page'].$sortFlag.'"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>ORDINE DEL '.$_GET['Data_Ordine'].' SEGNATO PAGATO CON SUCCESSO</strong>';
                break;
            case 'ordine_succ_pagato3':
                echo  '<a href ="./admin_GestOrdini.php"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>ORDINE ('.$_GET['Ordine'].') SEGNATO PAGATO CON SUCCESSO</strong>';
                break;
            default:
                echo  '<a href ="#"><img src="../css/img/Error-icon.png" alt=""></a>';
                echo  '<strong>MESSAGGIO DI OPERAZIONE AVVENUTA CON SUCCESSO</strong>';
                break;
        }
        
        echo      '</p>';
        echo '</div>';
    }

?>