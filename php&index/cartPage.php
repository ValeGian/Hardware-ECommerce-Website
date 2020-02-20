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
    $NUMERO_PRODOTTI_PER_PAGINA = 4;
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
        
        <script src="../js/utility.js"></script>	
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userCartProductEventHandler.js"></script>
        <script src="../js/ajax/CartProduct.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
        <title>Il Mio Carrello - Hardware E-COMMERCE</title>
    </head>
    <body>
        
        <?php 
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        
        <main class="container">
            <div id="main_content" class="principal-content">
                <h1 class="page-title">IL MIO CARRELLO</h1>
                
                <?php   //IN PRESENZA DI ERRORI, LI SEGNALO
                echo'<div id="messageContainer">';
					require "./util/formErrorHandler.php";
                echo'</div>';
                
                    if(!isset($_GET['Page']))
                        $currPage = 1;
                    else
                        $currPage = $_GET['Page'];
                
                    $errorUrl = '';
				?>
                
                <?php
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
                        
                        $errorUrl = showCartProducts($result1, $nomeUtente, $spesa, $errorUrl, 'cartPage', $NUMERO_PRODOTTI_PER_PAGINA, $currPage);  
                        
                        echo    '<div class="container">';
                        echo        '<div class="pagination_sort_bar_container">';
                        
                    //MOSTRO A SCHERMO LA BARRA DI PAGINAZIONE
                        $returnURLFlag = './cartPage.php?';
                            
                        showBarPages($MaxPage, $currPage, $returnURLFlag);  
                        
                        echo        '</div>';
                        echo    '</div>';
                        
                        if($errorUrl == ''){
                            echo'<a href="./purchasePage.php" id="acquista" class="sub_btn">PROCEDI CON l\'ACQUISTO ></a>';
                        }
                        else {
                            echo'<a href="'.$errorUrl.'" id="acquista" class="sub_btn">PROCEDI CON l\'ACQUISTO ></a>';
                        }
                        
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