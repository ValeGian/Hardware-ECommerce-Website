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
        
        <script src="../js/utility.js"></script>		
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/adminProductEventHandler.js"></script>
        <script src="../js/ajax/ProductUtility.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
        <title>Hardware E-COMMERCE</title>
    </head>
    <body 
        <?php
            if(isset($_GET['Tabella']))
                echo'onload="openProductList(); adminProductEventHandler.onLoadModProductEvent(\''.$tabella.'\', \''.$modelloP.'\');"'
        ?>>
        
        <?php 
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        
        <main>
             <div id="main_content" class="principal-content">
                <div class="padded-container">
                    <h1>MODIFICA PRODOTTI</h1>
                    
                    <?php   //IN PRESENZA DI ERRORI, LI SEGNALO
				        require "./util/formErrorHandler.php";
                        require "./util/MessageHandler.php";
				    ?>
                    
                    <h2>DATI PRODOTTO</h2>
                    <div class="box">
                        <!-- SELEZIONO IL TIPO DI PRODOTTO DA MODIFICARE -->
                        <form name="productMod" action="./operative_use/productMod.php" method="post" class="row" enctype="multipart/form-data">
                            <label for="tipo_prodotto">Tipo Prodotto</label>
                                <select name="tipo_prodotto" id="tipo_prodotto" class="form-control" 
                            <?php
                                if(!isset($_GET['Tabella']))
                                    echo'onchange="openProductList();"';
                            ?>>
                        
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
                                        <label for="Modello_C">Modello da Modificare <sup>*</sup></label>
                                        <select name="Modello_C" id="Modello_C" class="form-control" 
                                    <?php
                                        if(!isset($_GET['Tabella']))   echo'onchange="adminProductEventHandler.onChangeModProductEvent(\'computer\', this)"';
                                    ?>>
                                            
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

                                    <p class="row">
                                        <label for="Descrizione_C">Nuova Descrizione</label>
                                        <textarea name="Descrizione_C" rows="4" class="form-control" id="Descrizione_C" style="font-size: 0.9em;"></textarea>
                                    </p>

                                    <p class="row">
                                        <label for="Immagine_C">Nuova Immagine</label>
                                        <input type="file" name="Immagine_C" class="form-control" id="Immagine_C">
                                    </p>

                                    <p class="row">
                                        <label for="Quantita_C">Quante unit&agrave; aggiungere(+) / togliere(-)?</label>
                                        <input type="number" name="Quantita_C" value="0" id="Quantita_C" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Prezzo_C">Nuovo Prezzo per unit&agrave; (&euro;)</label>
                                        <input type="number" name="Prezzo_C" step=".01" class="form-control" id="Prezzo_C">
                                    </p>

                                </div>

                            </fieldset>
                            
                            
                            <fieldset id="memoria_Container" class="dispNone">
                                <h2>MEMORIA</h2>

                                <div class="box">

                                    <span><sup>*</sup>  Campo richiesto</span>
                                    
                                    <p class="row">
                                        <label for="Modello_M">Modello da Modificare <sup>*</sup></label>
                                        <select name="Modello_M" class="form-control" id="Modello_M"
                                    <?php
                                        if(!isset($_GET['Tabella']))
                                            echo'onchange="adminProductEventHandler.onChangeModProductEvent(\'memoria\', this);"';
                                    ?>>
                                            
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

                                    <p class="row">
                                        <label for="Descrizione_M">Nuova Descrizione</label>
                                        <textarea name="Descrizione_M" rows="4" class="form-control" id="Descrizione_M" style="font-size: 0.9em;"></textarea>
                                    </p>

                                    <p class="row">
                                        <label for="Immagine_M">Nuova Immagine</label>
                                        <input type="file" name="Immagine_M" class="form-control" id="Immagine_M">
                                    </p>

                                    <p class="row">
                                        <label for="Quantita_M">Quante unit&agrave; aggiungere(+) / togliere(-)?</label>
                                        <input type="number" name="Quantita_M" value="0" id="Quantita_M" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Prezzo_M">Nuovo Prezzo per unit&agrave; (&euro;)</label>
                                        <input type="number" name="Prezzo_M" step=".01" class="form-control" id="Prezzo_M">
                                    </p>

                                </div>

                            </fieldset>
                            
                            
                            <fieldset id="tablet_Container" class="dispNone">
                                <h2>TABLET</h2>

                                <div class="box">

                                    <span><sup>*</sup>  Campo richiesto</span>
                                    
                                    <p class="row">
                                        <label for="Modello_T">Modello da Modificare <sup>*</sup></label>
                                        <select name="Modello_T" class="form-control" id="Modello_T"
                                    <?php
                                        if(!isset($_GET['Tabella']))
                                            echo'onchange="adminProductEventHandler.onChangeModProductEvent(\'tablet\', this);"';
                                    ?>>
                                            
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

                                    <p class="row">
                                        <label for="Descrizione_T">Nuova Descrizione</label>
                                        <textarea name="Descrizione_T" rows="4" class="form-control" id="Descrizione_T" style="font-size: 0.9em;"></textarea>
                                    </p>

                                    <p class="row">
                                        <label for="Immagine_T">Nuova Immagine</label>
                                        <input type="file" name="Immagine_T" class="form-control" id="Immagine_T">
                                    </p>

                                    <p class="row">
                                        <label for="Quantita_T">Quante unit&agrave; aggiungere(+) / togliere(-)?</label>
                                        <input type="number" name="Quantita_T" value="0" id="Quantita_T" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Prezzo_T">Nuovo Prezzo per unit&agrave; (&euro;)</label>
                                        <input type="number" name="Prezzo_T" step=".01" class="form-control" id="Prezzo_T">
                                    </p>

                                </div>

                            </fieldset>
                            
                            
                            <fieldset id="periferica_Container" class="dispNone">
                                <h2>PERIFERICA</h2>

                                <div class="box">
                                    
                                    <span><sup>*</sup>  Campo richiesto</span>
                                    
                                    <p class="row">
                                        <label for="Modello_P">Modello da Modificare <sup>*</sup></label>
                                        <select name="Modello_P" class="form-control" id="Modello_P"
                                    <?php
                                        if(!isset($_GET['Tabella']))
                                            echo'onchange="adminProductEventHandler.onChangeModProductEvent(\'periferica\', this);"';
                                    ?>>
                                            
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

                                    <p class="row">
                                        <label for="Descrizione_P">Nuova Descrizione</label>
                                        <textarea name="Descrizione_P" rows="4" class="form-control" id="Descrizione_P" style="font-size: 0.9em;"></textarea>
                                    </p>

                                    <p class="row">
                                        <label for="Immagine_P">Nuova Immagine</label>
                                        <input type="file" name="Immagine_P" class="form-control" id="Immagine_P">
                                    </p>

                                    <p class="row">
                                        <label for="Quantita_P">Quante unit&agrave; aggiungere(+) / togliere(-)?</label>
                                        <input type="number" name="Quantita_P" value="0" id="Quantita_P" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Prezzo_P">Nuovo Prezzo per unit&agrave; (&euro;)</label>
                                        <input type="number" name="Prezzo_P" step=".01" class="form-control" id="Prezzo_P">
                                    </p>

                                </div>

                            </fieldset>
                            
                            <input type="submit" id="Submit_Prodotto" name="Submit_Prodotto" class="dispNone sub_btn" value="MODIFICA >">
                        </form>
                        
                    </div>
                </div>
            </div>

        </main>
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
    </body>
</html>