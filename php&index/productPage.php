<?php

    require_once "./pathConfig.php";
    require_once DIR_UTIL."ECommerceDbManager.php";

	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

    if(!isset($_GET['Tabella']) || !isset($_GET['Modello'])){   //SE SI ACCEDE NON DAI CANALI PRINCIPALI, E DUNQUE NON è SETTATA UNA RICERCA
        header('Location: ./index.php');    //REINDIRIZZA ALLA PAGINA INIZIALE
        exit;
    }
    
    if(isset($_SESSION['NomeUtente']) && $_SESSION['NomeUtente'] == 'Admin')
        $ADMIN_IS_HERE = true;

?>

<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="utf-8"> 
    	<meta name = "author" content = "Valerio Giannini">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta name = "keywords" content = "NOTEBOOK,PC,HARDWARE,PERIFERICHE,E-COMMERCE">	
        <meta name="description" content="Acquista online Notebook e Personal Computer" />
        
        <link rel="shortcut icon" type="image/x-icon" href="./../css/img/Logo_icon.ico" />
        <link rel="stylesheet" href="../css/General_Layout.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/Principal_Header.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/Principal_Footer.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/Product_Page_Layout.css" type="text/css" media="screen" />
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
		<title>Prodotto - Hardware E-COMMERCE</title>
    </head>
    <body>
        <?php 
            require DIR_LAYOUT."Principal_Header.php";
        
            $tabella = $_GET['Tabella'];
            $modello = $_GET['Modello'];

        //ESTRAGGO I DATI SUL PRODOTTO DAL DATABASE
            $result = getProduct($tabella, $modello);
            if(!$result){
                header('Location: ./index.php');
                exit;
            }
        
        
            $row = $result->fetch_assoc();
            $acquistabile = $row['Acquistabile'];
        
        //SETTO LE VARIABILI A COMUNE TRA TUTTI I TIPI DI PRODOTTO
            $descrizione = $row['Descrizione'];
            $immagine = $row['Immagine'];
            if($immagine == ''){
                $immagine = 'default_img.png';
            }
            $prezzo = number_format($row['Prezzo'], 2);
            if($row['Quantita'] > 0){
                $disp = TRUE;
            }
            else{
                $disp = FALSE;
            }
            $id = $row['id_Prodotto'];
        
        //SETTO LE VARIABILI SPECIFICHE SECONDO IL TIPO DI PRODOTTO
            switch($tabella){
                case 'computer':
                    $tipo = $row['Tipo_C'];
                    $produttore = $row['Produttore'];
                    $mem_SSD = $row['Mem_SSD'];
                    $mem_HDD = $row['Mem_HDD'];
                    $u_Mis_HDD = $row['u_Misura_HDD'];
                    $mem_RAM = $row['Mem_RAM'];
                    $scheda_Video = $row['Scheda_Video'];
                    break;
                case 'memoria':
                    $tipo = $row['Tipo_M'];
                    $q_Mem = $row['Q_Memoria'];
                    $u_Mis_Mem = $row['u_Misura_Memoria'];
                    $velocita = $row['Velocita'];
                    break;
                case 'tablet':
                    $produttore = $row['Produttore'];
                    $risoluzione = $row['Risoluzione'];
                    $dim_Schermo = $row['Dim_Schermo'];
                    $cap_Mem = $row['Capacita_Mem'];
                    break;
                default:
                    break;
            }

        ?>
        
        <main>
            <div class="principal-content">
                
            <?php   //IN PRESENZA DI ERRORI, LI SEGNALO
                require_once "./util/formErrorHandler.php";
                require "./util/MessageHandler.php";
            ?>
                
            <?php
            
            echo'<section class="short-data-block three-col data-container">';
            echo    '<div class="column-layout">';
            echo        '<img src="../img/Products/'.$immagine.'" id="image_block" alt="Prodotto">';
            echo    '</div>';
                    
            echo    '<div class="column-layout">';
            echo        '<h1>'.$modello.'</h1>';
                    
            if($disp){
                echo        '<p id="Prod_disp" class="disponibilita">Prodotto Disponibile</p>';
            }
            else{
                echo        '<p id="Prod_Ndisp" class="disponibilita">Prodotto Non Disponibile</p>';
            }
            echo    '</div>';
            
            if(!$ADMIN_IS_HERE){
                echo'<div class="column-layout">';
                echo'<div class="addToCart-container">';
                echo    '<a href="./operative_use/addToCart.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'&ID='.$id.'&oldPage=PPage&Acqu='.$acquistabile.'" title="Aggiungi al mio carrello" class="btn">';
                echo    '</a>';
                echo'</div>';
                echo'<p id="Prezzo">&euro;'.$prezzo.'</p>';
                echo'</div>';
            }
            else{
                echo'<div class="column-layout">';
                echo'<div class="adminTrash-container">';
                echo    '<a href="./admin_DelProdotto.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'" title="Elimina Prodotto" class="btn">';
                echo    '</a>';
                echo'</div>';
                
                echo'<div class="adminWrench-container">';
                echo    '<a href="./admin_ModProdotto.php?Tabella='.$tabella.'&Modello='.rawurlencode($modello).'" title="Modifica Prodotto" class="btn">';
                echo    '</a>';
                echo'</div>';
                echo'<p id="Prezzo">&euro;'.$prezzo.'</p>';
                echo'</div>';
            }
            
            echo '<div class="clear"></div>';  
            echo'</section>'; 
                    
            if($tabella != 'periferica'){
                echo'<section id="scheda_tecnica" class="data-container principal-content">';
                
                echo    '<h1>Scheda Tecnica</h1>';
                
            //MOSTRO LA SCHEDA TECNICA RELATIVA AL PRODOTTO SPECIFICO
                switch($tabella){
                        case 'computer':
                        
                            echo    '<div class="three-col">';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Tipo di Computer: </span><span class="dato-tecnico">'.$tipo.'</span>';
                            echo            '</div>';
                            echo        '</div>';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Produttore: </span><span class="dato-tecnico">'.$produttore.'</span>';
                            echo            '</div>';
                            echo        '</div>';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Memoria SSD: </span><span class="dato-tecnico">'.$mem_SSD.' GB</span>';
                            echo            '</div>';
                            echo        '</div>';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Memoria HDD: </span><span class="dato-tecnico">'.$mem_HDD.' '.$u_Mis_HDD.'</span>';
                            echo            '</div>';
                            echo        '</div>';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Memoria RAM: </span><span class="dato-tecnico">'.$mem_RAM.' GB</span>';
                            echo            '</div>';
                            echo        '</div>';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Scheda Video: </span><span class="dato-tecnico">'.$scheda_Video.'</span>';
                            echo            '</div>';
                            echo        '</div>';
                            echo    '</div>';
                            break;
                        case 'memoria':
                            
                            echo    '<div class="three-col">';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Tipo di Memoria: </span><span class="dato-tecnico">'.$tipo.'</span>';
                            echo            '</div>';
                            echo        '</div>';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Dimensioni Memoria: </span><span class="dato-tecnico">'.$q_Mem.' '.$u_Mis_Mem.'</span>';
                            echo            '</div>';
                            echo        '</div>';
                            
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            if($tipo == 'RAM'){
                                echo                '<span class="dato-tecnico">Velocit&agrave; Memoria: </span><span class="dato-tecnico">'.$velocita.' MHz</span>';
                            }
                            else{
                                echo                '<span class="dato-tecnico">Velocit&agrave; Trasferimento Dati: </span><span class="dato-tecnico">'.$velocita.' Gbit/s</span>';
                            }
                            echo            '</div>';
                            echo        '</div>';
                            echo    '</div>';
                            break;
                        case 'tablet':
                        
                            echo    '<div class="three-col">';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Produttore: </span><span class="dato-tecnico">'.$produttore.'</span>';
                            echo            '</div>';
                            echo        '</div>';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Risoluzione Schermo: </span><span class="dato-tecnico">'.$risoluzione.' Pixels</span>';
                            echo            '</div>';
                            echo        '</div>';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Dimensioni Schermo Diagonale (pollici): </span><span class="dato-tecnico">'.$dim_Schermo.'\'\'</span>';
                            echo            '</div>';
                            echo        '</div>';
                        
                            echo        '<div class="column-layout">';
                            echo            '<div class="principal-content">';
                            echo                '<span class="dato-tecnico">Memoria: </span><span class="dato-tecnico">'.$cap_Mem.' GB</span>';
                            echo            '</div>';
                            echo        '</div>';
                            echo    '</div>';
                            break;
                }
                
                echo    '<div class="clear"></div>';
                echo'</section>';
            }
            
                    
            echo'<section id="dettagli" class="data-container principal-content">';
            echo    '<h1>Dettagli</h1>'; 
            echo        '<p>'.$descrizione.'</p>';
            echo'</section>';
            ?>
                
            </div>
        </main>
        
        <?php 
            require DIR_LAYOUT."Principal_Footer.php"; 
        ?>
    </body>
</html>