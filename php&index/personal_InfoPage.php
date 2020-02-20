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

    if (isset($_SESSION['Logged']) && $_SESSION['Logged'] === true){    //SE GIà LOGGATO
        $email = $_SESSION['Email'];
    }
    else{
        $email = '';
    }

    require_once "./pathConfig.php";
    require_once DIR_UTIL."ECommerceDbManager.php";

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
        <link rel="stylesheet" href="../css/Form_Layout.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/Personal_Info.css" type="text/css" media="screen" />
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
		<title>Profilo Personale - Hardware E-COMMERCE</title>
    </head>
    <body>
        
        <?php 
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        
        <main>
            <div id="main_content" class="principal-content">
                <h1 class="page-title">I MIEI DATI PERSONALI</h1>
                
                
                <?php   //IN PRESENZA DI ERRORI O MESSAGGI, LI SEGNALO
					require "./util/formErrorHandler.php";
                    require "./util/MessageHandler.php";
				?>
                
                <?php
                    $result = getUserData($email);
                    $row = $result->fetch_assoc();

                    $cognome = $row['Cognome'];
                    $nome = $row['Nome'];
                    $indirizzo = $row['Indirizzo'];
                    $cap = $row['Cod_Postale'];
                    $citta = $row['Citta'];
                    $provincia = $row['Provincia'];
                        
                //MOSTRO I DATI PERSONALI DELL'UTENTE
                    echo        '<section class="box dati">';
                    echo            '<h2 class="sect-title">I MIEI DATI</h2>';
                    echo            '<p>'.$cognome.'</p>';
                    echo            '<p>'.$nome.'</p>';
                    echo            '<p>'.$email.'</p>';
                //DO ALL'UTENTE LA POSSIBILITà DI MODIFICARE LA PROPRIA EMAIL
                    echo    '<a href="./userModPage.php?Change=email&Email='.$email.'" id="mod_dati_E" class="sub_btn">MODIFICA EMAIL ></a>';
                    echo        '</section>';
                
                //MOSTRO I DATI DI CONSEGNA DELL'UTENTE
                    echo        '<section class="box dati">';
                    echo            '<h2 class="sect-title">IL MIO INDIRIZZO DI CONSEGNA</h2>';
                    echo            '<p>'.$indirizzo.'</p>';
                    echo            '<p>'.$cap.' '.$citta.'('.$provincia.')</p>';
                
                //DO ALL'UTENTE LA POSSIBILITà DI MODIFICARE I PROPRI DATI DI CONSEGNA
                    echo    '<form name="userModPage" action="./userModPage.php?Indirizzo='.rawurlencode($indirizzo).'&Cap='.$cap.'&Citta='.rawurlencode($citta).'&Provincia='.rawurlencode($provincia).'&Email='.$email.'" method="post" class="row" novalidate>';
                    echo '<input type="hidden" name="hidden_url" value="../personal_InfoPage.php">';
                    echo    '<button id="mod_dati_I" class="sub_btn">MODIFICA ></a>';

                    echo        '</section>';
                
                ?>
            </div>
        </main>
        
        <?php 
            require DIR_LAYOUT."Principal_Footer.php";
        ?>
        
    </body>
</html>