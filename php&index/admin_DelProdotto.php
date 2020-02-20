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

    $tabella = '';
    $modelloP = '';
    if(isset($_GET['Tabella'])){
        $tabella = $_GET['Tabella'];
        if(isset($_GET['Modello']))
            $modelloP = $_GET['Modello'];
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
        <link rel="stylesheet" href="../css/Form_Layout.css" type="text/css" media="screen" />
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        <script src="../js/utility.js"></script>	
        
        <title>Hardware E-COMMERCE</title>
    </head>
    <body 
        <?php
            if(isset($_GET['Tabella']))
                echo'onload="openProductList()"';
        ?>
    >
        
        <?php
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        
        <main>
             <div id="main_content" class="principal-content">
                <div class="padded-container">
                    <h1>ELIMINA PRODOTTI</h1>
                    
                    <?php   //IN PRESENZA DI ERRORI, LI SEGNALO
				        require "./util/formErrorHandler.php";
                        require "./util/MessageHandler.php";
				    ?>
                    
                    <h2>DATI PRODOTTO</h2>
                    <div class="box">
                        <!-- SELEZIONO IL TIPO DI PRODOTTO DA ELIMINARE -->
                        <form name="productDel" action="./operative_use/productDel.php" method="post" class="row" novalidate>
                            <label for="tipo_prodotto">Tipo Prodotto</label>
                                <select name="tipo_prodotto" id="tipo_prodotto" class="form-control" 
                            <?php
                                if(!isset($_GET['Tabella']))
                                    echo'onchange="openProductList()"';
                            ?>
                        >
                        <?php
                            if(!isset($_GET['Tabella'])){
                                echo'<option value="-">-</option>
                                    <option value="computer">Computer</option>
                                    <option value="memoria">Memoria</option>
                                    <option value="tablet">Tablet</option>
                                    <option value="periferica">Periferica</option>';
                            }
                            else{
                                echo'<option value="'.$tabella.'">'.$tabella.'</option>';
                            }
                        ?>
                                </select>
                                    
                        <fieldset id="computer_Container" class="dispNone">
                                <h2>COMPUTER</h2>

                                <div class="box">
                                    
                                    <span><sup>*</sup>  Campo richiesto</span>
                                    
                                    <p class="row">
                                        <label for="Modello_C">Modello da Eliminare <sup>*</sup></label>
                                        <select name="Modello_C" id="Modello_C" class="form-control">
                                            
                                            <?php
                                                if($modelloP === ''){
                                                    echo'<option value="">-</option>';
                                                    $result = getProductFromTable('computer');
                                                    $numRow = mysqli_num_rows($result);

                                                    for($i = 1; $i <= $numRow; $i++){
                                                        $row = $result->fetch_assoc();
                                                        $modello = $row['Modello'];
                                                        echo'<option value="'.$modello.'">'.$modello.'</option>';
                                                    }
                                                }
                                                else
                                                    echo'<option value="'.$modelloP.'">'.$modelloP.'</option>';
                                            ?>
                                            
                                        </select>
                                    </p>

                                </div>

                            </fieldset>
                            
                            
                            <fieldset id="memoria_Container" class="dispNone">
                                <h2>MEMORIA</h2>

                                <div class="box">
                                    
                                    <span><sup>*</sup>  Campo richiesto</span>
                                    
                                    <p class="row">
                                        <label for="Modello_M">Modello da Eliminare <sup>*</sup></label>
                                        <select name="Modello_M" id="Modello_M" class="form-control">
                                            
                                            <?php
                                                if($modelloP === ''){
                                                    echo'<option value="">-</option>';
                                                    $result = getProductFromTable('memoria');
                                                    $numRow = mysqli_num_rows($result);

                                                    for($i = 1; $i <= $numRow; $i++){
                                                        $row = $result->fetch_assoc();
                                                        $modello = $row['Modello'];
                                                        echo'<option value="'.$modello.'">'.$modello.'</option>';
                                                    }
                                                }
                                                else
                                                    echo'<option value="'.$modelloP.'">'.$modelloP.'</option>';
                                            ?>
                                            
                                        </select>
                                    </p>

                                </div>

                            </fieldset>
                            
                            
                            <fieldset id="tablet_Container" class="dispNone">
                                <h2>TABLET</h2>

                                <div class="box">
                                    
                                    <span><sup>*</sup>  Campo richiesto</span>
                                    
                                    <p class="row">
                                        <label for="Modello_T">Modello da Eliminare <sup>*</sup></label>
                                        <select name="Modello_T" id="Modello_T" class="form-control">
                                            
                                            <?php
                                                if($modelloP === ''){
                                                    echo'<option value="">-</option>';
                                                    $result = getProductFromTable('tablet');
                                                    $numRow = mysqli_num_rows($result);

                                                    for($i = 1; $i <= $numRow; $i++){
                                                        $row = $result->fetch_assoc();
                                                        $modello = $row['Modello'];
                                                        echo'<option value="'.$modello.'">'.$modello.'</option>';
                                                    }
                                                }
                                                else
                                                    echo'<option value="'.$modelloP.'">'.$modelloP.'</option>';
                                            ?>
                                            
                                        </select>
                                    </p>

                                </div>

                            </fieldset>
                            
                            
                            <fieldset id="periferica_Container" class="dispNone">
                                <h2>PERIFERICA</h2>

                                <div class="box">
                                    
                                    <span><sup>*</sup>  Campo richiesto</span>
                                    
                                    <p class="row">
                                        <label for="Modello_P">Modello da Eliminare <sup>*</sup></label>
                                        <select name="Modello_P" id="Modello_P" class="form-control">
                                            
                                            <?php
                                                if($modelloP === ''){
                                                    echo'<option value="">-</option>';
                                                    $result = getProductFromTable('periferica');
                                                    $numRow = mysqli_num_rows($result);

                                                    for($i = 1; $i <= $numRow; $i++){
                                                        $row = $result->fetch_assoc();
                                                        $modello = $row['Modello'];
                                                        echo'<option value="'.$modello.'">'.$modello.'</option>';
                                                    }
                                                }
                                                else
                                                    echo'<option value="'.$modelloP.'">'.$modelloP.'</option>';
                                            ?>
                                            
                                        </select>
                                    </p>

                             </div>

                            </fieldset>
                            
                            <input type="submit" id="Submit_Prodotto" name="Submit_Prodotto" class="dispNone sub_btn" value="ELIMINA >">
                        </form>
                        
                    </div>
                </div>
            </div>

        </main>
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
    </body>
</html>