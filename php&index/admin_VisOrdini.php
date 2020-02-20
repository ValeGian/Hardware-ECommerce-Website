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
    $NUMERO_ORDINI_PER_PAGINA = 10;
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
			
        <title>Hardware E-COMMERCE</title>
    </head>
    <body>
        
        <?php 
            require DIR_LAYOUT."Principal_Header.php"; 
        
            if(!isset($_POST['Submit']) && !isset($_GET['Sort']))
                $sort = 'all';
            else if(isset($_POST['Submit']))
                $sort = $_POST['Sort'];
            else if(isset($_GET['Sort']))
                $sort = $_GET['Sort'];
        
            $sortWhere = '';
        ?>
        
        <main>
            <div id="main_content" class="principal-content" style="margin-bottom:25px;">
                <h1>ELENCO ORDINI</h1>
                
                <?php   //IN PRESENZA DI ERRORI, LI SEGNALO
				    require "./util/formErrorHandler.php";
                    require "./util/MessageHandler.php";
                ?>
                
                <form name="ordini_sort_form" class="sorting_bar" action="./admin_VisOrdini.php" method="post" style="float: right;">
                    <label for="ordini_sort_form">Visualizza</label>
                    <select name="Sort" id="ordini_sort_form" class="form-control">
                            <?php
                            if($sort == 'all'){
                                $sortWhere = '';
                                    
                                echo    '<option value="all">Tutti gli Ordini</option>';
                                echo    '<option value="daPagare">Ordini da Pagare</option>';
                                echo    '<option value="Pagati">Ordini Pagati</option>';
                                echo    '<option value="Cancellati">Ordini Cancellati</option>';
                            }
                            else if($sort == 'daPagare'){
                                $sortWhere = 'where Pagato=0 and Cancellato=0';
                                    
                                echo    '<option value="daPagare">Ordini da Pagare</option>';
                                echo    '<option value="all">Tutti gli Ordini</option>';
                                echo    '<option value="Pagati">Ordini Pagati</option>';
                                echo    '<option value="Cancellati">Ordini Cancellati</option>';
                            }
                            else if($sort == 'Pagati'){
                                $sortWhere = 'where Pagato<>0';
                                    
                                echo    '<option value="Pagati">Ordini Pagati</option>';
                                echo    '<option value="all">Tutti gli Ordini</option>';
                                echo    '<option value="daPagare">Ordini da Pagare</option>';
                                echo    '<option value="Cancellati">Ordini Cancellati</option>';
                            }
                            else if($sort == 'Cancellati'){
                                $sortWhere = 'where Cancellato<>0';
                                    
                                echo    '<option value="Cancellati">Ordini Cancellati</option>';
                                echo    '<option value="all">Tutti gli Ordini</option>';
                                echo    '<option value="daPagare">Ordini da Pagare</option>';
                                echo    '<option value="Pagati">Ordini Pagati</option>';
                            }
                        ?>
                    </select>
                    
                    <input type="submit" name="Submit" class="btn" value="INVIA">
                </form>
                
                <?php
                    if(!isset($_GET['Page']))
                        $currPage = 1;
                    else
                        $currPage = $_GET['Page'];
                
                    $result = getAllOrdiniAndUsersData($sortWhere);
                    $ProdCount = mysqli_num_rows($result);

                //CALCOLO QUANTE PAGINE SERVIRANNO (contando $NUMERO_ORDINI_PER_PAGINA prodotti per pagina!!)
                    $MaxPage = ceil($ProdCount/$NUMERO_ORDINI_PER_PAGINA);
                
                    if($MaxPage == 0)   //SE NON CI SONO PRODOTTI, SERVE COMUNQUE ALMENO 1 PAGINA
                        $MaxPage = 1;
                
                    if($ProdCount == 0){   //SE NON CI SONO ORDINI FATTI DALL'UTENTE
                        echo    '<p class="alert">Non sono stati ancora eseguiti ordini.</p>';
                    }
                    else{
                        
                    //MOSTRO TUTTI GLI ORDINI DELL'UTENTE 
                        showUserOrdini($result, '', 'adminPage', $NUMERO_ORDINI_PER_PAGINA, $currPage, $sort);
                        
                        echo    '<div class="container">';
                        echo        '<div class="pagination_sort_bar_container">';
                        
                    //MOSTRO A SCHERMO LA BARRA DI PAGINAZIONE
                        $returnURLFlag = './admin_VisOrdini.php?Sort='.$sort;
                            
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