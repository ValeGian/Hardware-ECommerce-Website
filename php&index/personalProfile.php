<?php
	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

    if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] === false){    //SE NON LOGGATO
        header('Location: ./loginPage.php');    //REINDIRIZZA ALLA PAGINA DI LOGIN
        exit;
    }

    if($_SESSION['Email'] === 'admin@admin.it'){    //QUANDO ACCEDE L'ADMIN
        header('Location: ./index.php');
        exit;
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
        <link rel="stylesheet" href="../css/Personal_Profile_Layout.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/Form_Layout.css" type="text/css" media="screen" />
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
		<title>My Account - Hardware E-COMMERCE</title>
    </head>
    <body>
        <?php 
            require_once "./pathConfig.php";
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        <main>
            <div id="main_content" class="principal-content">
                
                <h1 class="page-title">IL MIO ACCOUNT</h1>
                <p>Benvenuto nel tuo account. Qui potrai gestire gli ordini e tutte le tue informazioni personali.</p>
                
                <ul id="my_account_link_list">
                    <li>
                        <a href="personal_InfoPage.php">
                            <div id="user_list_element"><span>I Miei Dati Personali</span></div>
                        </a>
                    </li>
                        
                    <li>
                        <a href="cartPage.php">
                            <div id="cart_list_element"><span>Il Mio Carrello</span></div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="storicoAcquistiPage.php">
                            <div id="list_list_element"><span>Il Mio Storico Acquisti</span></div>
                        </a>
                    </li>
                </ul>
                
                <hr>
                
                <a href="./operative_use/logout.php?Submit=logout" id="logout_link">
                    <div id="logout_element"><span>LOGOUT</span></div>
                </a>
                
                <div class="clear"></div>
                
            </div>
            
        </main>
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
    </body>
</html>