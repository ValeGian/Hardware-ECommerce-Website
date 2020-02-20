<?php
	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

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
        <link rel="stylesheet" href="../css/Index.css" type="text/css" media="screen" />
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
		<title>Hardware E-COMMERCE - Compra Hardware Online</title>
    </head>
    <body>
        <?php 
            require_once "./pathConfig.php";
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        <main>
            <div id="main_content" class="principal-content">
                <div class="padded-container">
                    <h1 style="padding-bottom: 10px;">Manuale Utente</h1>
                    <p>Benvenuti su Hardware E-Commerce; l'obbiettivo di questo sito web &egrave; di simulare (senza effettivo passaggio di denaro) l'esperienza navigativa di accedere ad un e-commerce e fare tutto ci&ograve; che si pu&ograve; normalmente fare su un medesimo tipo di sito web.<br>
                    Questo breve manuale utente ha il fine di illustrare i servizi, sia verso <b>user clienti</b> che verso <b>user admin</b>, messi a disposizione da questo sito web.</p>
                    <p>Questo sito &egrave; completamente <i>responsive</i>.</p>

                    <div class="padded-container">
                        <h2>User Client</h2>
                        <p>Uno user che entra in questo sito come cliente ha a disposizione una serie di servizi, alcuni accessibili senza necessit&agrave; di loggarsi (<b>no logging required</b>) mentre altri necessitano che lo user sia loggato (<b>logging required</b>) per poterne usufruire.</p>
                        <div class="padded-container">
                            <h3>No Logging Required</h3>
                            <p>accedendo al sito come clienti non loggati, &egrave; possibile ricercare e visualizzare tutti i prodotti acquistabili, visualizzandone informazioni di vario tipo.</p>
                            
                            <h3>Logging Required</h3>
                            <p>accedendo al sito come clienti loggati, si avranno a disposizione funzionalità ulteriori:</p>
                            <ul class="padded-container">
                                <li>Aggiungere prodotti al proprio carrello, gestendo la quantit&agrave; di ogni singolo prodotto da acquistare</li>
                                <li>Procedere all'acquisto dei prodotti nel carrello</li>
                                <li>Visualizzare i propri ordini effettuati ed eventualmente cancellarne alcuni tra quelli non ancora consegnati/pagati</li>
                                <li>Accedere al proprio profilo personale con possibilit&agrave; di modificare i propri dati (tranne nome, cognome e nome utente)</li>
                            </ul>
                        </div>

                        <h2>User Admin</h2>
                        <p>uno user che entra in questo sito accedendo come Admin ha a disposizione una serie di funzionalit&agrave; finalizzate al fornirgli strumenti di gestione sufficienti al poter amministrare il sito nella sua completezza. Tale Admin pu&ograve;:<br></p>
                        <ul class="padded-container">
                            <li>Visualizzare tutti i prodotti inseriti sul sito</li>
                            <li>Inserire/Modificare/Eliminare prodotti dal sito internet</li>
                            <li>Visualizzare e gestire gli ordini effettuati dai clienti, potendo segnare come "pagati" o cancellare degli ordini ancora in pendenza</li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
    </body>
</html>