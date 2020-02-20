<?php
	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

    /*if(!isset($_GET['Tabella']) && !isset($_POST['Submit']) && !isset($_POST['Submit_Search']) && !isset($_GET['Searching'])){   //SE SI ACCEDE NON DAI CANALI PRINCIPALI, E DUNQUE NON è SETTATA UNA RICERCA
        header('Location: ./index.php');    //REINDIRIZZA ALLA PAGINA INIZIALE
        exit;
    }*/

    require_once "./pathConfig.php";
    require_once DIR_UTIL."ECommerceDbManager.php";

    $NUMERO_PRODOTTI_PER_PAGINA = 12;
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
        <link rel="stylesheet" href="../css/Product_List_Layout.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/Pagination_Bar.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/Form_Layout.css" type="text/css" media="screen" />
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
		
		<title>Lista Prodotti - Hardware E-COMMERCE</title>
    </head>
    <body>
        <?php
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        <main>
            <div id="main_content" class="principal-content">
                
                <?php
                //ESTRAGGO I VALORI DALLA GET E DALLA POST SE SETTATI
                    if(!isset($_GET['Page']))
                        $currPage = 1;
                    else
                        $currPage = $_GET['Page'];
                
                    $tabella = '';
                    $tipo = '';
                    $produttore = '';
                    $like = ''; $likeSetted = false;
                    $sort = 'desc';
                
                    if(isset($_POST['Submit'])){
                        $tabella = $_POST['Tabella'];
                        $tipo = $_POST['Tipo'];
                        $produttore = $_POST['Produttore'];
                        if(isset($_POST['Search']) && $_POST['Search'] !== ''){
                            $like = $_POST['Search'];
                            $likeSetted = true;
                        }
                        $sort = $_POST['Sort'];
                    }
                    else if(isset($_POST['Submit_Search'])){
                        $like = $_POST['search_query'];
                        $likeSetted = true;
                    }
                    else{
                        
                        if(isset($_GET['Tabella']))
                            $tabella = $_GET['Tabella'];
                        
                        if(isset($_GET['Tipo']))
                            $tipo = $_GET['Tipo'];
                        
                        if(isset($_GET['Produttore']))
                            $produttore = $_GET['Produttore'];
                        
                        if(isset($_GET['Searching'])){
                            $like = $_GET['Searching'];
                            $likeSetted = true;
                        }
                        
                        if(isset($_GET['Sort']))
                            $sort = $_GET['Sort'];
                        
                    }
                
                //SETTO IL CONTENUTO DELL'h1.page-heading
                    if($likeSetted)
                        $ricerca = 'CERCA "'.$like.'"';
                    else{
                        $ricerca = $tabella;
                        if($tipo != '')
                            $ricerca.= ' - '.$tipo;

                        if($produttore != '' && $produttore != 'Altro')
                            $ricerca.= ' - '.$produttore;
                    }
                        
                    $ricerca = strtoupper($ricerca);
                
                //SETTO IL CONTENUTO DELLO span.page-counter
                    $ProdCount = 0;
                    if($likeSetted)
                        $ProdCount = countProductsAcquirableLike($like);
                    else
                        $ProdCount = countProducts($tabella, $tipo, $produttore) - countProdottiEliminati($tabella, $tipo, $produttore);
                
                    echo    '<h1 class="page-heading">';
                    echo        '<span>'.$ricerca.'</span>';
                    if(($likeSetted && $like !== '') || !$likeSetted)
                        echo    '<span class="product-counter">Ci sono '.$ProdCount.' prodotti.</span>';
                    echo    '</h1>';
                
                //CALCOLO QUANTE PAGINE SERVIRANNO (contando $NUMERO_PRODOTTI_PER_PAGINA prodotti per pagina!!)
                    $MaxPage = ceil($ProdCount/$NUMERO_PRODOTTI_PER_PAGINA);
                
                    if($MaxPage == 0)   //SE NON CI SONO PRODOTTI, SERVE COMUNQUE ALMENO 1 PAGINA
                        $MaxPage = 1;
                
            
                //IN PRESENZA DI ERRORI O MESSAGGI, LI SEGNALO
                    require "./util/formErrorHandler.php";
                    require "./util/MessageHandler.php";
                
                    if(!(($likeSetted && $like === '') || $ProdCount === 0)){
                        
                        echo'<form name="product_sort_form" id="product_sort_form" class="sorting_bar" method="post" action="./productListPage.php">
                                <label for="Sort">Ordina</label>
                                <select name="Sort" id="Sort" class="form-control">';
                        
                            if($sort == 'desc'){
                                echo    '<option value="desc">Prezzo: dal meno caro</option>';
                                echo    '<option value="asc">Prezzo: dal pi&ugrave; caro</option>';
                            }
                            else{
                                echo    '<option value="asc">Prezzo: dal pi&ugrave; caro</option>';
                                echo    '<option value="desc">Prezzo: dal meno caro</option>';
                            }

                            echo        '<input type="hidden" value="'.$tabella.'" name="Tabella">';
                            echo        '<input type="hidden" value="'.$tipo.'" name="Tipo">';
                            echo        '<input type="hidden" value="'.$produttore.'" name="Produttore">';
                            echo        '<input type="hidden" value="'.$like.'" name="Search">';
                        
                        echo'   </select>
                    
                                <input type="submit" name="Submit" class="btn" value="INVIA">
                            </form>';
                    }
                            
                ?>
                
                <div id="product_list_container">
                    
                    <?php   //IN PRESENZA DI ERRORI DI INSERIMENTO, LI SEGNALO
                        
                        if($likeSetted && $like === ''){   //SE NON è STATA INSERITA UNA PAROLA DI RICERCA VALIDA
                            echo    '<p class="alert">Si prega di digitare una parola chiave di ricerca.</p>';
                        }
                        else if($ProdCount == 0){   //SE NON CI SONO ORDINI FATTI DALL'UTENTE
                            echo    '<p class="alert">Siamo spiacenti, non é stato trovato nessun risultato.</p>';
                        }
                        else{
                        //MOSTRO LA LISTA DI PRODOTTI SELEZIONATI
                            
                            $pageType = 'user';
                            if($likeSetted)
                                $pageType = 'search';
                            
                            
                            showProductList($ProdCount, $pageType, $tabella, $tipo, $produttore, $like, $sort, $NUMERO_PRODOTTI_PER_PAGINA, $currPage); 
                        }
				    ?>
                    
                </div>
                
                <?php
                    if(!(($likeSetted && $like === '') || $ProdCount === 0)){
                        echo    '<div class="container">';
                        echo        '<div class="pagination_sort_bar_container">';

                        if($likeSetted)
                            $returnURLFlag = './productListPage.php?Searching='.$like.'&Sort='.$sort;
                        else
                            $returnURLFlag = './productListPage.php?Tabella='.$tabella.'&Tipo='.$tipo.'&Produttore='.$produttore.'&Sort='.$sort;

                    //MOSTRO A SCHERMO LA BARRA DI PAGINAZIONE
                        showBarPages($MaxPage, $currPage, $returnURLFlag);  


                    //CALCOLO E MOSTRO A VIDEO QUALI PRODOTTI SONO VISUALIZZATI NELLA PAGINA CORRENTE NELL'ORDINE DI SORT SCELTO
                        if($ProdCount == 0){
                            $numBasso = 0;
                        }
                        else{
                            $numBasso = ($currPage - 1) * $NUMERO_PRODOTTI_PER_PAGINA + 1;
                        }

                        if($ProdCount == 0 || $currPage == $MaxPage){  //SE SONO ALL'ULTIMA PAGINA 
                            $numAlto = $ProdCount;
                        }
                        else{
                            $numAlto = $currPage * $NUMERO_PRODOTTI_PER_PAGINA;
                        }

                        echo            '<div class="page_product_count">';
                        echo                'Mostrando '.$numBasso.' - '.$numAlto.' di '.$ProdCount.' articoli';
                        echo            '</div>';
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