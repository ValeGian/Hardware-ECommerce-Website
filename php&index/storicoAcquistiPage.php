<?php
	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

    if (isset($_SESSION['Logged']) && $_SESSION['Logged'] === true){    //SE GIà LOGGATO
        $nomeUtente = $_SESSION['NomeUtente'];
    }
    else{
        $nomeUtente = '';
    }

    require_once "./pathConfig.php";
    require_once DIR_UTIL."ECommerceDbManager.php";
    $NUMERO_ORDINI_PER_PAGINA = 6;
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
        <link rel="stylesheet" href="../css/Storico_Acquisti.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/Pagination_Bar.css" type="text/css" media="screen" />
        
        <script src="../js/utility.js"></script>	
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
        <title>Storico Acquisti - Hardware E-COMMERCE</title>
    </head>
    <body>
        
        <?php 
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        
        <main>
            <div id="main_content" class="principal-content">
                <h1 class="page-title">STORICO ORDINI ACQUISTI</h1>
                
                
                <?php   //IN PRESENZA DI ERRORI, LI SEGNALO
				    require "./util/formErrorHandler.php";
                    require "./util/MessageHandler.php";
                
                    if(!isset($_GET['Page']))
                        $currPage = 1;
                    else
                        $currPage = $_GET['Page'];
                
                    $result = getUserOrdini($nomeUtente);
                    $ProdCount = mysqli_num_rows($result);

                //CALCOLO QUANTE PAGINE SERVIRANNO (contando $NUMERO_ORDINI_PER_PAGINA prodotti per pagina!!)
                    $MaxPage = ceil($ProdCount/$NUMERO_ORDINI_PER_PAGINA);
                
                    if($MaxPage == 0)   //SE NON CI SONO PRODOTTI, SERVE COMUNQUE ALMENO 1 PAGINA
                        $MaxPage = 1;
                
                    if($ProdCount == 0){   //SE NON CI SONO ORDINI FATTI DALL'UTENTE
                        echo    '<p class="alert">Non hai inviato alcun ordine.</p>';
                    }
                    else{
                        
                    //MOSTRO TUTTI GLI ORDINI DELL'UTENTE 
                        showUserOrdini($result, $nomeUtente, 'userPage', $NUMERO_ORDINI_PER_PAGINA, $currPage, '');
                        
                        echo    '<div class="container">';
                        echo        '<div class="pagination_sort_bar_container">';
                        
                    //MOSTRO A SCHERMO LA BARRA DI PAGINAZIONE
                        $returnURLFlag = './storicoAcquistiPage.php?';
                            
                        showBarPages($MaxPage, $currPage, $returnURLFlag);  
                        
                        echo        '</div>';
                        echo    '</div>';
                            
                    }
                
                ?>
                
            </div>
        </main>
        
        <?php
            require DIR_LAYOUT."Principal_Footer.php";
        ?>
        
    </body>
</html>