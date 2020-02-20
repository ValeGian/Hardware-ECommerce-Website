<?php
	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

    if (isset($_SESSION['Logged']) && $_SESSION['Logged'] === true){    //SE GIà LOGGATO
        header('Location: ./personalProfile.php');    //REINDIRIZZA AL PROFILO PERSONALE
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
        <link rel="stylesheet" href="../css/Login.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/Form_Layout.css" type="text/css" media="screen" />
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
		<title>Login - Hardware E-COMMERCE</title>
    </head>
    <body>
        
        <?php 
            require_once "./pathConfig.php";
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        
        <main>
            <div id="login-container" class="principal-content">
                <h1 class="page-title">AUTENTICAZIONE</h1>
                
                <?php   //IN PRESENZA DI ERRORI, LI SEGNALO
					require "./util/formErrorHandler.php";
				?>
                
                <div class="two-col">

                    <div class="column-layout">
                        <form name="creation" action="./operative_use/registrationFilter.php" method="post" id="login_account_form" class="box">
                            
                            <span><sup>*</sup>  Campo richiesto</span>
                            
                            <h2 class="sect-title">CREA UN ACCOUNT</h2>
                            <p>Inserisci il tuo indirizzo email per creare un account.</p>

                            <div class="form-group">
                                <label for="email-crea">Indirizzo Email <sup>*</sup></label>
                                <input type="email" id="email-crea" name="email_crea" class="form-control" pattern="^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                            </div>

                            <div class="legal-privacy">
                                <input type="checkbox" name="privacy_check">
                                 Dichiaro di aver letto, compreso e accettato l' <a href="./privacyPage.php">informativa sulla privacy</a>
                            </div>

                            <button type="submit" id="Submit_Crea" name="Submit_Crea" class="sub_btn">
                                <span id="create_element" class="button_icon">CREA UN ACCOUNT</span>
                            </button>
                        </form>
                    </div>

                    <div class="column-layout">
                        <form name="login" action="./operative_use/login.php" method="post" id="login_form" class="box">
                            
                            <span><sup>*</sup>  Campo richiesto</span>
                            
                            <h2 class="sect-title">SEI GI&Agrave; REGISTRATO?</h2>
                            <div class="form-group">
                                <label for="login-id">Indirizzo Email o Nome Utente <sup>*</sup></label>
                                <input type="text" id="login-id" name="login-id" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="passwd">Password <sup>*</sup></label>
                                <input type="password" id="passwd" name="passwd" class="form-control" autocomplete="off">
                            </div>

                            <button type="submit" id="Submit_Login" name="Submit_Login" class="sub_btn">
                                <span id="login_element" class="button_icon">ACCEDI</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
        
    </body>
</html>