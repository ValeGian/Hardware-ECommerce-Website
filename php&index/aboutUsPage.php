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
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
		<title>Chi siamo - Hardware E-COMMERCE</title>
    </head>
    <body>
        <?php 
            require_once "./pathConfig.php";
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        <main>
            <div id="main_content" class="principal-content">
                <div style="padding: 50px 20% 150px 5%;">
                    <p><strong>Hardware E-COMMERCE</strong> &egrave; un e-commerce sviluppato da Valerio    Giannini come progetto universitario.<br><br>
                    Questo sito ha il fine di dare una esperienza completa di ricerca ed acquisto di prodotti hardware online e nel farlo propone una serie di Servizi atti a migliorare l'esperienza generale dell'utente, fornendo aiuto nelle ricerche e nel proporre prodotti nuovi e tra i pi&ugrave; acquistati online.<br><br>
                    Dato il fine didattico per il quale questo sito &egrave; stato fatto, sono state omesse alcune funzionalit&agrave;, come ad esempio l'acquisto con carta e la conferma della registrazione di un nuovo account tramite email.<br><br>
                    Auguro a chiunque provi questo sito una buona esperienza di navigazione e per eventuali problemi riscontrati, si prega di contattarci all'indirizzo email <a href="mailto:46gianninivalerio@gmail.com">46gianninivalerio@gmail.com</a>
                    </p>
                </div>
            </div>
        </main>
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
    </body>
</html>


					