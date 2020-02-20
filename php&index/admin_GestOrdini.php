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
                <div class="padded-container">
                    <h1>GESTISCI ORDINI</h1>
                    
                    <?php   //IN PRESENZA DI ERRORI, LI SEGNALO
				        require "./util/formErrorHandler.php";
                        require "./util/MessageHandler.php";
				    ?>
                    
                    <div class="box">
                        
                        <span><sup>*</sup>  Campo richiesto</span>
                        
                        <!-- SELEZIONO L'ORDINE DA GESTIRE -->
                        <form name="ordineGest" action="./operative_use/ordineGest.php" method="post" class="row" novalidate>
                            
                            <p class="row">
                                <label for="Gestione">Elimina o Segna Pagato <sup>*</sup></label>
                                <select name="Gestione" id="Gestione" class="form-control">
                                    <option value="">-</option>
                                    <option value="elimina">ELIMINA</option>
                                    <option value="pagato">PAGATO</option>
                                </select>
                            </p>
                            
                            <p class="row">
                                <label for="Ordine">Codice Ordine <sup>*</sup></label>
                                <select name="Ordine" id="Ordine" class="form-control">
                                    <option value="">-</option>

                                    <?php

                                        $queryText = "select * from ordine where Cancellato=0 and Pagato=0 order by Codice_ordine";   
                                        $result = callQuery($queryText);
                                        $numRow = mysqli_num_rows($result);

                                        for($i = 1; $i <= $numRow; $i++){
                                            $row = $result->fetch_assoc();
                                            $ordine = $row['Codice_ordine'];
                                            echo'<option value="'.$ordine.'">'.$ordine.'</option>';
                                        }
                                    ?>
                                </select>
                            </p>
                            
                            <input type="submit" id="Submit_Prodotto" name="Submit_Prodotto" class="sub_btn" value="INVIA >">
                        </form>
                        
                    </div>
                </div>
            </div>

        </main>
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
    </body>
</html>