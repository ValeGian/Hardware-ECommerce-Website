<?php
	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }
    
    if (!isset($_SESSION['Logged']) || $_SESSION['Logged'] === false){    //SE NON LOGGATO 
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
        <link rel="stylesheet" href="../css/Cart_Purchase.css" type="text/css" media="screen" />
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
        <title>Modifica i Tuoi Dati - Hardware E-COMMERCE</title>
    </head>
    <body>
        
        <?php 
            require_once "./pathConfig.php";
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        
        <main>
             <div id="main_content" class="principal-content">
                <div class="padded-container">
                <?php
                    require "./util/formErrorHandler.php";
                    
                if(isset($_GET['Change']) && $_GET['Change'] == 'email'){
                    echo'<h1>LA TUA EMAIL</h1>';
                    
                    echo'<h2 class="title-box">MODIFICA EMAIL</h2>';
                    echo'<div class="box">'; 
                    
                    echo    '<form name="productMod" action="./operative_use/userMod.php?Submit=userModPage&Change=email" method="post" class="row">';
                    echo        '<span><sup>*</sup>  Campo richiesto</span>';
                    
                    $oldEmail = $_GET['Email'];
                    
                    echo        '<p class="row">';
                    echo            '<label for="old_email">Vecchia Email</label>';
                    echo            '<input type="email" id="old_email" value="'.$oldEmail.'" name="oldEmail" class="form-control" readonly>';
                    echo        '</p>';
                    
                    echo        '<p class="row">';
                    echo            '<label for="new_email">Nuova Email <sup>*</sup></label>';
                    echo            '<input type="email" id="new_email" value="'.$oldEmail.'" name="newEmail" class="form-control" autofocus>';
                    echo        '</p>';
                    
                    echo        '<input type="submit" name="Submit_Mod_User" id="mod_user" class="sub_btn" value="INVIA >">';
                    echo    '</form>';
                    echo'<div>';
                }
                else{
                      
                    echo'<h1>IL TUO INDIRIZZO DI CONSEGNA</h1>';
                    
                    echo'<h2 class="title-box">MODIFICA INDIRIZZO</h2>';
                    echo'<div class="box">';
                        
                    $url = '../Personal_InfoPage.php';
                    if(isset($_POST['hidden_url']))
                        $url = $_POST['hidden_url'];
                    else if(isset($_GET['Url']))
                        $url = $_GET['Url'];
                    
                    echo    '<form name="productMod" action="./operative_use/userMod.php?Submit=userModPage&Url='.$url.'&Email='.$_GET['Email'].'" method="post" class="row">';
                    echo        '<span><sup>*</sup>  Campo richiesto</span>';

                    $indirizzo = $_GET['Indirizzo'];
                    $cap = $_GET['Cap'];
                    $citta = $_GET['Citta'];
                    $provincia = $_GET['Provincia'];

                    echo        '<p class="row">';
                    echo            '<label for="indirizzo">Indirizzo <sup>*</sup></label>';
                    echo            '<input type="text" id="indirizzo" value="'.$indirizzo.'" name="indirizzo" class="form-control" autofocus>';
                    echo        '</p>';

                    echo        '<p class="row">';
                    echo            '<label for="cod_postale">Codice postale <sup>*</sup></label>';
                    echo            '<input type="text" id="cod_postale" value="'.$cap.'" name="cod_postale" class="form-control" pattern="\d{5}" maxlength="5">';
                    echo        '</p>';

                    echo        '<p class="row">';
                    echo            '<label for="citta">Citt&agrave; <sup>*</sup></label>';
                    echo            '<input type="text" id="citta" value="'.$citta.'" name="citta" class="form-control">';
                    echo        '</p>';

                    echo        '<p class="row">
                                    <label for="provincia">Provincia <sup>*</sup></label>
                                    <select name="provincia" id="provincia" class="form-control">
                                        <option value="'.$provincia.'">'.$provincia.'</option>
                                        <option value="Agrigento">Agrigento</option><option value="Alessandria">Alessandria</option><option value="Ancona">Ancona</option><option value="Aosta">Aosta</option><option value="Arezzo">Arezzo</option><option value="Ascoli Piceno">Ascoli Piceno</option><option value="Asti">Asti</option><option value="Avellino">Avellino</option><option value="Bari">Bari</option><option value="Barletta-Andria-Trani">Barletta-Andria-Trani</option><option value="Belluno">Belluno</option><option value="Benevento">Benevento</option><option value="Bergamo">Bergamo</option><option value="Biella">Biella</option><option value="Bologna">Bologna</option><option value="Bolzano">Bolzano</option><option value="Brescia">Brescia</option><option value="Brindisi">Brindisi</option><option value="Cagliari">Cagliari</option><option value="Caltanissetta">Caltanissetta</option><option value="Campobasso">Campobasso</option><option value="Carbonia-Iglesias">Carbonia-Iglesias</option><option value="Caserta">Caserta</option><option value="Catania">Catania</option><option value="Catanzaro">Catanzaro</option><option value="Chieti">Chieti</option><option value="Como">Como</option><option value="Cosenza">Cosenza</option><option value="Cremona">Cremona</option><option value="Crotone">Crotone</option><option value="Cuneo">Cuneo</option><option value="Enna">Enna</option><option value="Fermo">Fermo</option><option value="Ferrara">Ferrara</option><option value="Firenze">Firenze</option><option value="Foggia">Foggia</option><option value="Forlì-Cesena">Forlì-Cesena</option><option value="Frosinone">Frosinone</option><option value="Genova">Genova</option><option value="Gorizia">Gorizia</option><option value="Grosseto">Grosseto</option><option value="Imperia">Imperia</option><option value="Isernia">Isernia</option><option value="L\'Aquila">L\'Aquila</option><option value="La Spezia">La Spezia</option><option value="Latina">Latina</option><option value="Lecce">Lecce</option><option value="Lecco">Lecco</option><option value="Livorno">Livorno</option><option value="Lodi">Lodi</option><option value="Lucca">Lucca</option><option value="Macerata">Macerata</option><option value="Mantova">Mantova</option><option value="Massa">Massa</option><option value="Matera">Matera</option><option value="Medio Campidano">Medio Campidano</option><option value="Messina">Messina</option><option value="Milano">Milano</option><option value="Modena">Modena</option><option value="Monza e della Brianza">Monza e della Brianza</option><option value="Napoli">Napoli</option><option value="Novara">Novara</option><option value="Nuoro">Nuoro</option><option value="Ogliastra">Ogliastra</option><option value="Olbia-Tempio">Olbia-Tempio</option><option value="Oristano">Oristano</option><option value="Padova">Padova</option><option value="Palermo">Palermo</option><option value="Parma">Parma</option><option value="Pavia">Pavia</option><option value="Perugia">Perugia</option><option value="Pesaro-Urbino">Pesaro-Urbino</option><option value="Pescara">Pescara</option><option value="Piacenza">Piacenza</option><option value="Pisa">Pisa</option><option value="Pistoia">Pistoia</option><option value="77">Pordenone</option><option value="78">Potenza</option><option value="79">Prato</option><option value="Ragusa">Ragusa</option><option value="Ravenna">Ravenna</option><option value="Reggio Calabria">Reggio Calabria</option><option value="Reggio Emilia">Reggio Emilia</option><option value="Rieti">Rieti</option><option value="Rimini">Rimini</option><option value="Roma">Roma</option><option value="Rovigo">Rovigo</option><option value="Salerno">Salerno</option><option value="Sassari">Sassari</option><option value="Savona">Savona</option><option value="Siena">Siena</option><option value="Siracusa">Siracusa</option><option value="Sondrio">Sondrio</option><option value="Taranto">Taranto</option><option value="Teramo">Teramo</option><option value="Terni">Terni</option><option value="Torino">Torino</option><option value="Trapani">Trapani</option><option value="Trento">Trento</option><option value="Treviso">Treviso</option><option value="Trieste">Trieste</option><option value="Udine">Udine</option><option value="Varese">Varese</option><option value="Venezia">Venezia</option><option value="Verbano-Cusio-Ossola">Verbano-Cusio-Ossola</option><option value="Vercelli">Vercelli</option><option value="Verona">Verona</option><option value="Vibo Valentia">Vibo Valentia</option><option value="Vicenza">Vicenza</option><option value="Viterbo">Viterbo</option>
                                    </select>
                                </p>';

                echo        '<input type="submit" name="Submit_Mod_User" id="mod_user" class="sub_btn" value="INVIA >">';
                echo    '</form>';
                echo'</div>';

                }
                ?>
                    
                </div>
            </div>

        </main>
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
    </body>
</html>