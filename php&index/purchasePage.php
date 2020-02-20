<?php
	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

    if (isset($_SESSION['Logged']) && $_SESSION['Logged'] === true){    //SE GIà LOGGATO
        $email = $_SESSION['Email'];
        $nomeUtente = $_SESSION['NomeUtente'];
    }
    else{
        $email = '';
        $nomeUtente = '';
    }

    require_once "./pathConfig.php";
    require_once DIR_UTIL."ECommerceDbManager.php";
    $NUMERO_PRODOTTI_PER_PAGINA = 3;
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
        <link rel="stylesheet" href="../css/Cart_Purchase.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/Pagination_Bar.css" type="text/css" media="screen" />
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
		<title>Acquisto - Hardware E-COMMERCE</title>
    </head>
    <body>
        
        <?php 
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        
        <main id="main_content" class="container">
            <div class="principal-content">
                <h1 class="page-title">RIEPILOGO ORDINE</h1>
                
                <?php   //IN PRESENZA DI ERRORI O MESSAGGI, LI SEGNALO
					require "./util/formErrorHandler.php";
                    require "./util/formErrorHandler.php";
				?>
                
                <?php
                    if(!isset($_GET['Page']))
                        $currPage = 1;
                    else
                        $currPage = $_GET['Page'];
                
                    $result1 = getAllCartItems($nomeUtente);
                    $ProdCount = mysqli_num_rows($result1);

                //CALCOLO QUANTE PAGINE SERVIRANNO (contando $NUMERO_PRODOTTI_PER_PAGINA prodotti per pagina!!)
                    $MaxPage = ceil($ProdCount/$NUMERO_PRODOTTI_PER_PAGINA);
                
                    if($MaxPage == 0)   //SE NON CI SONO PRODOTTI, SERVE COMUNQUE ALMENO 1 PAGINA
                        $MaxPage = 1;
                
                
                    if($ProdCount == 0){   //SE NON CI SONO PRODOTTI NEL CARRELLO
                        echo    '<p class="alert">Il carrello &egrave; vuoto.</p>';
                    }
                    else{
                        
                        showCartProducts($result1, $nomeUtente, $spesa, '', 'purchasePage', $NUMERO_PRODOTTI_PER_PAGINA, $currPage); //$spesa la ricavo dal Principal_Header
                        
                        echo    '<div class="container">';
                        echo        '<div class="pagination_sort_bar_container">';
                        
                    //MOSTRO A SCHERMO LA BARRA DI PAGINAZIONE
                        $returnURLFlag = './purchasePage.php?';
                            
                        showBarPages($MaxPage, $currPage, $returnURLFlag);  
                        
                        echo        '</div>';
                        echo    '</div>';
                        
                    //MOSTRO I DATI DI CONSEGNA DELL'UTENTE
                        echo        '<section class="box dati">';
                        echo            '<h2 class="sect-title">IL MIO INDIRIZZO DI CONSEGNA</h2>';
                        
                        $result = getUserData($email);
                        $row = $result->fetch_assoc();
                        
                        $cognome = $row['Cognome'];
                        $nome = $row['Nome'];
                        $indirizzo = $row['Indirizzo'];
                        $cap = $row['Cod_Postale'];
                        $citta = $row['Citta'];
                        $provincia = $row['Provincia'];
                        
                        echo            '<p>'.$cognome.' '.$nome.'</p>';
                        echo            '<p>'.$indirizzo.'</p>';
                        echo            '<p>'.$cap.' '.$citta.'('.$provincia.')</p>';
                        
                        echo    '<form name="userModPage" action="./userModPage.php?Submit=userModPage&Indirizzo='.rawurlencode($indirizzo).'&Cap='.$cap.'&Citta='.rawurlencode($citta).'&Provincia='.rawurlencode($provincia).'&Email='.$email.'" method="post" class="row" novalidate>';
                        echo '<input type="hidden" name="hidden_url" value="../purchasePage.php">';
                        echo    '<button id="mod_dati" class="sub_btn">MODIFICA ></a>';
                        
                        echo        '</section>';
                        
                        echo    '<a href="./operative_use/purchase.php?Submit=purchase&Utente='.rawurlencode($nomeUtente).'" id="acquista" class="sub_btn">ACQUISTA ></a>';
                        echo    '<div class="clear"></div>';
                    }
                
                ?>
            </div>
            
            <!-- MESSAGGIO PER UTENTI DA CELLULARE -->
            <p id="phone-message">Ruotare il telefono in orizziontale per poter visualizzare correttamente la pagina</p>
            <!--                                   -->
            
        </main>
        
        <?php 
            require DIR_LAYOUT."Principal_Footer.php";
        ?>
        
    </body>
</html>