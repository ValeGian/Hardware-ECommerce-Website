<?php
	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }
    
    if (!isset($_SESSION['Logged']) || !isset($_SESSION['Email']) || $_SESSION['Logged'] === false || $_SESSION['Email'] !== 'admin@admin.it'){    //SE NON LOGGATO O LOGGATO MA NON COME ADMIN
        header('Location: ./index.php');    //REINDIRIZZA ALLA PAGINA INIZIALE
        exit;
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
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
				
        <title>Hardware E-COMMERCE</title>
    </head>
    <body>
        
        <?php 
            require_once "./pathConfig.php";
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        
        <main>
             <div id="main_content" class="principal-content">
                <div class="padded-container">
                    <h1>INSERIMENTO PRODOTTI</h1>
                    
                    <?php   //IN PRESENZA DI ERRORI, LI SEGNALO
				        require "./util/formErrorHandler.php";
                        require "./util/MessageHandler.php";
				    ?>
                    
                    <h2>DATI PRODOTTO</h2>
                    <div class="box">
                        <!-- SELEZIONO IL TIPO DI PRODOTTO DA INSERIRE -->
                        <form name="productInsertion" action="./operative_use/productInsert.php" method="post" class="row" enctype="multipart/form-data">
                            <label for="tipo_prodotto">Tipo Prodotto</label>
                                <select name="tipo_prodotto" id="tipo_prodotto" class="form-control" onchange="openProductList()">
                                    <option value="-">-</option>
                                    <option value="computer">Computer</option>
                                    <option value="memoria">Memoria</option>
                                    <option value="tablet">Tablet</option>
                                    <option value="periferica">Periferica</option>
                                </select>
                        
                            
                            <fieldset id="computer_Container" class="dispNone">
                                <h2>COMPUTER</h2>

                                <div class="box">

                                    <span><sup>*</sup>  Campo richiesto</span>
                                    
                                    <p class="row">
                                        <label for="Modello_C">Modello <sup>*</sup></label>
                                        <input type="text" name="Modello_C" id="Modello_C" pattern="[^+'\u0022]+" class="form-control">
                                        <!--RICONOSCO SOLO MODELLI CHE NON CONTENTGONO I CARATTERI + ' " -->
                                    </p>

                                    <p class="row">
                                        <label for="Tipo_C">Tipologia<sup>*</sup></label>
                                        <select name="Tipo_C" id="Tipo_C" class="form-control">
                                            <option value="-">-</option>
                                            <option value="notebook">Notebook</option>
                                            <option value="pc_desktop">PC Desktop</option>
                                            <option value="workstation">Workstation</option>
                                        </select>
                                    </p>

                                    <p class="row">
                                        <label for="Produttore_C">Produttore<sup>*</sup></label>
                                        <input type="text" name="Produttore_C" id="Produttore_C" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Descrizione_C">Descrizione</label>
                                        <textarea name="Descrizione_C" rows="4" id="Descrizione_C" class="form-control"></textarea>
                                    </p>

                                    <p class="row">
                                        <label for="Mem_SSD_C">Memoria SSD (GB)</label>
                                        <input type="number" name="Mem_SSD_C" id="Mem_SSD_C" class="form-control">
                                    </p>

                                    <p class="row container">

                                        <label for="Mem_HDD_C">Memoria HDD</label>
                                        <input type="number" name="Mem_HDD_C" step=".1" id="Mem_HDD_C" class="form-control">

                                        <select name="u_misura_mem_C" class="form-control right-box">
                                            <option value="TB">TB</option>
                                            <option value="GB">GB</option>
                                        </select>

                                    </p>

                                    <p class="row">
                                        <label for="Mem_RAM_C">Memoria RAM<sup>*</sup> (GB)</label>
                                        <input type="number" name="Mem_RAM_C" id="Mem_RAM_C" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Scheda_Video_C">Scheda Video</label>
                                        <input type="text" name="Scheda_Video_C" id="Scheda_Video_C" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Immagine_C">Immagine</label>
                                        <input type="file" name="Immagine_C" id="Immagine_C" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Quantita_C">Quante unit&agrave; inserire?</label>
                                        <input type="number" name="Quantita_C" value="1" id="Quantita_C" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Prezzo_C">Prezzo per unit&agrave;<sup>*</sup> (&euro;)</label>
                                        <input type="number" name="Prezzo_C" step=".01" id="Prezzo_C" class="form-control">
                                    </p>

                                </div>

                            </fieldset>
                            
                            
                            <fieldset id="memoria_Container" class="dispNone">
                                <h2>MEMORIA</h2>

                                <div class="box">

                                    <span><sup>*</sup>  Campo richiesto</span>
                                    
                                    <p class="row">
                                        <label for="Modello_M">Modello <sup>*</sup></label>
                                        <input type="text" name="Modello_M" id="Modello_M" pattern="[^+'\u0022]+" class="form-control">
                                        <!--RICONOSCO SOLO MODELLI CHE NON CONTENTGONO I CARATTERI + ' " -->
                                    </p>

                                    <p class="row">
                                        <label for="Tipo_M">Tipologia<sup>*</sup></label>
                                        <select name="Tipo_M" id="Tipo_M" class="form-control">
                                            <option value="-">-</option>
                                            <option value="RAM">RAM</option>
                                            <option value="HDD">HDD</option>
                                            <option value="SSD">SSD</option>
                                        </select>
                                    </p>

                                    <p class="row">
                                        <label for="Descrizione_M">Descrizione</label>
                                        <textarea name="Descrizione_M" rows="4" id="Descrizione_M" class="form-control"></textarea>
                                    </p>

                                    <p class="row container">

                                        <label for="Q_Memoria_M">Memoria<sup>*</sup></label>
                                        <input type="number" name="Q_Memoria_M" step=".1" id="Q_Memoria_M" class="form-control">

                                        <select name="u_misura_mem_M" class="form-control right-box">
                                            <option value="GB">GB</option>
                                            <option value="TB">TB</option>
                                        </select>
                                    </p>

                                    <p class="row container">
                                        <label for="Velocita_M">Velocit&agrave; di Trasferimento Dati<sup>*</sup> (RAM->MHz, HDD->Mbit/s, SSD->Mbit/s)</label>
                                        <input type="number" name="Velocita_M" step=".1" id="Velocita_M" class="form-control">

                                    </p>

                                    <p class="row">
                                        <label for="Immagine_M">Immagine</label>
                                        <input type="file" name="Immagine_M" id="Immagine_M" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Quantita_M">Quante unit&agrave; inserire?</label>
                                        <input type="number" name="Quantita_M" id="Quantita_M" value="1" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Prezzo_M">Prezzo per unit&agrave;<sup>*</sup> (&euro;)</label>
                                        <input type="number" name="Prezzo_M" step=".01" id="Prezzo_M" class="form-control">
                                    </p>

                                </div>

                            </fieldset>
                            
                            
                            <fieldset id="tablet_Container" class="dispNone">
                                <h2>TABLET</h2>

                                <div class="box">

                                    <span><sup>*</sup>  Campo richiesto</span>
                                    
                                    <p class="row">
                                        <label for="Modello_T">Modello <sup>*</sup></label>
                                        <input type="text" name="Modello_T" pattern="[^+'\u0022]+" id="Modello_T" class="form-control">
                                        <!--RICONOSCO SOLO MODELLI CHE NON CONTENTGONO I CARATTERI + ' " -->
                                    </p>

                                    <p class="row">
                                        <label for="Produttore_T">Produttore<sup>*</sup></label>
                                        <input type="text" name="Produttore_T" id="Produttore_T" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Descrizione_T">Descrizione</label>
                                        <textarea name="Descrizione_T" rows="4" id="Descrizione_T" class="form-control"></textarea>
                                    </p>

                                    <p class="row">
                                        <label for="Risoluzione_T">Risoluzione<sup>*</sup> (Pixels)</label>
                                        <input type="text" name="Risoluzione_T" id="Risoluzione_T" class="form-control" placeholder="es: 1280x800">
                                    </p>

                                    <p class="row container">
                                        <label for="Dim_Schermo_T">Dimensioni schermo Diagonale<sup>*</sup> (Pollici)</label>
                                        <input type="number" name="Dim_Schermo_T" step=".01" id="Dim_Schermo_T" class="form-control">
                                    </p>

                                    <p class="row container">
                                        <label for="Capacita_Mem_T">Capacit&agrave; di Memoria<sup>*</sup> (GB)</label>
                                        <input type="number" name="Capacita_Mem_T" id="Capacita_Mem_T" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Immagine_T">Immagine</label>
                                        <input type="file" name="Immagine_T" id="Immagine_T" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Quantita_T">Quante unit&agrave; inserire?</label>
                                        <input type="number" name="Quantita_T" value="1" id="Quantita_T" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Prezzo_T">Prezzo per unit&agrave;<sup>*</sup> (&euro;)</label>
                                        <input type="number" name="Prezzo_T" step=".01" id="Prezzo_T" class="form-control">
                                    </p>

                                </div>

                            </fieldset>
                            
                            
                            <fieldset id="periferica_Container" class="dispNone">
                                <h2>PERIFERICA</h2>

                                <div class="box">
                                    
                                    <span><sup>*</sup>  Campo richiesto</span>
                                    
                                    <p class="row">
                                        <label for="Tipo_P">Tipologia<sup>*</sup></label>
                                        <select name="Tipo_P" id="Tipo_P" class="form-control">
                                            <option value="-">-</option>
                                            <option value="mouse">Mouse</option>
                                            <option value="tastiera">Tastiera</option>
                                        </select>
                                    </p>

                                    <p class="row">
                                        <label for="Modello_P">Modello <sup>*</sup></label>
                                        <input type="text" name="Modello_P" id="Modello_P" pattern="[^+'\u0022]+" class="form-control">
                                        <!--RICONOSCO SOLO MODELLI CHE NON CONTENTGONO I CARATTERI + ' " -->
                                    </p>

                                    <p class="row">
                                        <label for="Descrizione_P">Descrizione</label>
                                        <textarea name="Descrizione_P" rows="4" id="Descrizione_P" class="form-control"></textarea>
                                    </p>

                                    <p class="row">
                                        <label for="Immagine_P">Immagine</label>
                                        <input type="file" name="Immagine_P" id="Immagine_P" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Quantita_P">Quante unit&agrave; inserire?</label>
                                        <input type="number" name="Quantita_P" value="1" id="Quantita_P" class="form-control">
                                    </p>

                                    <p class="row">
                                        <label for="Prezzo_P">Prezzo per unit&agrave;<sup>*</sup> (&euro;)</label>
                                        <input type="number" name="Prezzo_P" step=".01" id="Prezzo_P" class="form-control">
                                    </p>

                                </div>

                            </fieldset>
                            
                            <input type="submit" id="Submit_Prodotto" name="Submit_Prodotto" class="dispNone sub_btn" value="INSERISCI >">
                        </form>
                        
                    </div>
                </div>
            </div>

        </main>
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
    </body>
</html>