<?php
	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }
    
    if (!isset($_SESSION['Logged']) || !isset($_SESSION['Email']) || $_SESSION['Logged'] === false || $_SESSION['Email'] !== 'admin@admin.it'){    //SE NON LOGGATO O LOGGATO MA NON COME ADMIN
        header('Location: ./index.php');    //REINDIRIZZA ALLA PAGINA INIZIALE
        exit;
    }

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
        
        <script src="../js/utility.js"></script>
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
        <title>Hardware E-COMMERCE</title>
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
                
                    $sort = 'desc';
                    if(!isset($_POST['Submit'])){
                        
                        if(isset($_GET['Sort']))
                            $sort = $_GET['Sort'];
                        
                    }
                    else
                        $sort = $_POST['Sort'];
                
                //CONTO IL TOTALE DEI PRODOTTI DA MOSTRARE
                    $ProdCount = countAllProducts() - countAllProdottiEliminati();
                
                    echo    '<h1 class="page-heading">';
                    echo        '<span>Lista dei Prodotti</span>';
                    echo        '<span class="product-counter">Ci sono '.$ProdCount.' prodotti.</span>';
                    echo    '</h1>';
                
                //CALCOLO QUANTE PAGINE SERVIRANNO (contando $NUMERO_PRODOTTI_PER_PAGINA prodotti per pagina!!)
                    $MaxPage = ceil($ProdCount/$NUMERO_PRODOTTI_PER_PAGINA);
                
                    if($MaxPage == 0)   //SE NON CI SONO PRODOTTI, SERVE COMUNQUE ALMENO 1 PAGINA
                        $MaxPage = 1;
                
            
                //IN PRESENZA DI ERRORI, LI SEGNALO
                    require "./util/formErrorHandler.php";
                    require "./util/MessageHandler.php";
                ?>
                
                 <form name="product_sort_form" id="product_sort_form" class="sorting_bar" method="post" action="./admin_VisProdotti.php">
                    <label for="product_sort">Ordina</label>
                    <select name="Sort" id="product_sort" class="form-control">
                        
                        <?php
                            if($sort == 'desc'){
                                echo    '<option value="desc">Prezzo: dal meno caro</option>';
                                echo    '<option value="asc">Prezzo: dal pi&ugrave; caro</option>';
                            }
                            else{
                                echo    '<option value="asc">Prezzo: dal pi&ugrave; caro</option>';
                                echo    '<option value="desc">Prezzo: dal meno caro</option>';
                            }
                            
                        ?>
            
                    </select>
                    
                    <input type="submit" name="Submit" class="btn" value="INVIA">
                </form>
                
                <div id="product_list_container">
                    
                    <?php   //IN PRESENZA DI ERRORI DI INSERIMENTO, LI SEGNALO
                    
                    //MOSTRO LA LISTA DI PRODOTTI SELEZIONATI
                        showProductList($ProdCount, 'admin', '', '', '', '', $sort, $NUMERO_PRODOTTI_PER_PAGINA, $currPage);    
				    ?>
                    
                </div>
                
                <?php
                    echo    '<div class="container">';
                    echo        '<div class="pagination_sort_bar_container">';
                
                    $returnURLFlag = './admin_VisProdotti.php?Sort='.$sort;
                
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
                ?>
                 
            </div>
        </main>
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
    </body>
</html>