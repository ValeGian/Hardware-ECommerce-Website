<?php
	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

    if (isset($_SESSION['Logged']) && $_SESSION['Logged'] === true){    //SE GIà LOGGATO
        header('Location: ./personalProfile.php');    //REINDIRIZZA AL PROFILO PERSONALE
        exit;
    }	
    if (!isset($_SESSION['Email'])){    //SE NON è SETTATA LA EMAIL
        header('Location: ./loginPage.php');    //REINDIRIZZA ALLA PAGINA DI LOGIN
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
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
		<title>Registrazione - Hardware E-COMMERCE</title>
    </head>
    <body>
        
        <?php 
            require_once "./pathConfig.php";
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        
        <main>
            <div id="main_content" class="principal-content">
                <div class="padded-container">
                    <h1 class="page-title">CREA UN ACCOUNT</h1>
                    
                    <?php   //IN PRESENZA DI ERRORI, LI SEGNALO
					   require "./util/formErrorHandler.php";
				    ?>
                    
                    <form name="registration" action="./operative_use/registration.php" method="post" id="register_account_form">
                        <fieldset>
                            <h2 class="title-box">I TUOI DATI PERSONALI</h2>
                            <div class="box">

                                <span><sup>*</sup>  Campo richiesto</span>

                                <p class="row">
                                    <label for="nome">Nome <sup>*</sup></label>
                                    <input type="text" name="nome" id="nome" class="form-control" pattern="^[a-zA-Zàòèéùì'\s]+$" autofocus>
                                </p>
                                <p class="row">
                                    <label for="cognome">Cognome <sup>*</sup></label>
                                    <input type="text" name="cognome" id="cognome" class="form-control" pattern="^[a-zA-Zàòèéùì'\s]+$">
                                </p>
                                <p class="row">
                                    <label for="nomeUtente">Nome Utente <sup>*</sup></label>
                                    <input type="text" name="nomeUtente" id="nomeUtente" class="form-control" pattern="^[a-zA-Z0-9_]+$">
                                </p>
                                
                                <?php   //SETTO L'EMAIL INSERITA NELLA PAGINA DI VALIDAZIONE E LA RENDO NON PIù MODIFICABILE DALL'UTENTE
                                echo '<p class="row">';
                                echo     '<label for="Email">Email <sup>*</sup></label>';
                                echo     '<input type="email" id="Email" value=' . $_SESSION['Email'] . ' name="Email" class="form-control" readonly>';
                                echo '</p>';
                                ?>
                                
                                <p class="row">
                                    <label for="passwd">Password <sup>*</sup></label>
                                    <input type="password" name="passwd" id="passwd" class="form-control" autocomplete="off">
                                </p>
                                <p class="row">
                                    <label for="Conf_passwd">Conferma Password <sup>*</sup></label>
                                    <input type="password" name="Conf_passwd" id="Conf_passwd" class="form-control">
                                </p>
                            </div>
                        </fieldset>

                        <fieldset>
                            <h2 class="title-box">IL TUO INDIRIZZO</h2>
                            <div class="box">
                                <p class="row">
                                    <label for="indirizzo">Indirizzo <sup>*</sup></label>
                                    <input type="text" name="indirizzo" id="indirizzo" class="form-control">
                                </p>
                                <p class="row">
                                    <label for="cod_postale">Codice postale <sup>*</sup></label>
                                    <input type="text" name="cod_postale" id="cod_postale" class="form-control" pattern="^\d{5}$" maxlength="5">
                                </p>
                                <p class="row">
                                    <label for="citta">Citt&agrave; <sup>*</sup></label>
                                    <input type="text" name="citta" id="citta" class="form-control" pattern="^[A-Za-zàòèéùì'\s]+$">
                                </p>
                                <p class="row">
                                    <label for="provincia">Provincia <sup>*</sup></label>
                                    <select name="provincia" id="provincia" class="form-control">
                                        <option value="-">-</option>
                                        <option value="Agrigento">Agrigento</option><option value="Alessandria">Alessandria</option><option value="Ancona">Ancona</option><option value="Aosta">Aosta</option><option value="Arezzo">Arezzo</option><option value="Ascoli Piceno">Ascoli Piceno</option><option value="Asti">Asti</option><option value="Avellino">Avellino</option><option value="Bari">Bari</option><option value="Barletta-Andria-Trani">Barletta-Andria-Trani</option><option value="Belluno">Belluno</option><option value="Benevento">Benevento</option><option value="Bergamo">Bergamo</option><option value="Biella">Biella</option><option value="Bologna">Bologna</option><option value="Bolzano">Bolzano</option><option value="Brescia">Brescia</option><option value="Brindisi">Brindisi</option><option value="Cagliari">Cagliari</option><option value="Caltanissetta">Caltanissetta</option><option value="Campobasso">Campobasso</option><option value="Carbonia-Iglesias">Carbonia-Iglesias</option><option value="Caserta">Caserta</option><option value="Catania">Catania</option><option value="Catanzaro">Catanzaro</option><option value="Chieti">Chieti</option><option value="Como">Como</option><option value="Cosenza">Cosenza</option><option value="Cremona">Cremona</option><option value="Crotone">Crotone</option><option value="Cuneo">Cuneo</option><option value="Enna">Enna</option><option value="Fermo">Fermo</option><option value="Ferrara">Ferrara</option><option value="Firenze">Firenze</option><option value="Foggia">Foggia</option><option value="Forlì-Cesena">Forlì-Cesena</option><option value="Frosinone">Frosinone</option><option value="Genova">Genova</option><option value="Gorizia">Gorizia</option><option value="Grosseto">Grosseto</option><option value="Imperia">Imperia</option><option value="Isernia">Isernia</option><option value="L\'Aquila">L'Aquila</option><option value="La Spezia">La Spezia</option><option value="Latina">Latina</option><option value="Lecce">Lecce</option><option value="Lecco">Lecco</option><option value="Livorno">Livorno</option><option value="Lodi">Lodi</option><option value="Lucca">Lucca</option><option value="Macerata">Macerata</option><option value="Mantova">Mantova</option><option value="Massa">Massa</option><option value="Matera">Matera</option><option value="Medio Campidano">Medio Campidano</option><option value="Messina">Messina</option><option value="Milano">Milano</option><option value="Modena">Modena</option><option value="Monza e della Brianza">Monza e della Brianza</option><option value="Napoli">Napoli</option><option value="Novara">Novara</option><option value="Nuoro">Nuoro</option><option value="Ogliastra">Ogliastra</option><option value="Olbia-Tempio">Olbia-Tempio</option><option value="Oristano">Oristano</option><option value="Padova">Padova</option><option value="Palermo">Palermo</option><option value="Parma">Parma</option><option value="Pavia">Pavia</option><option value="Perugia">Perugia</option><option value="Pesaro-Urbino">Pesaro-Urbino</option><option value="Pescara">Pescara</option><option value="Piacenza">Piacenza</option><option value="Pisa">Pisa</option><option value="Pistoia">Pistoia</option><option value="77">Pordenone</option><option value="78">Potenza</option><option value="79">Prato</option><option value="Ragusa">Ragusa</option><option value="Ravenna">Ravenna</option><option value="Reggio Calabria">Reggio Calabria</option><option value="Reggio Emilia">Reggio Emilia</option><option value="Rieti">Rieti</option><option value="Rimini">Rimini</option><option value="Roma">Roma</option><option value="Rovigo">Rovigo</option><option value="Salerno">Salerno</option><option value="Sassari">Sassari</option><option value="Savona">Savona</option><option value="Siena">Siena</option><option value="Siracusa">Siracusa</option><option value="Sondrio">Sondrio</option><option value="Taranto">Taranto</option><option value="Teramo">Teramo</option><option value="Terni">Terni</option><option value="Torino">Torino</option><option value="Trapani">Trapani</option><option value="Trento">Trento</option><option value="Treviso">Treviso</option><option value="Trieste">Trieste</option><option value="Udine">Udine</option><option value="Varese">Varese</option><option value="Venezia">Venezia</option><option value="Verbano-Cusio-Ossola">Verbano-Cusio-Ossola</option><option value="Vercelli">Vercelli</option><option value="Verona">Verona</option><option value="Vibo Valentia">Vibo Valentia</option><option value="Vicenza">Vicenza</option><option value="Viterbo">Viterbo</option>
                                    </select>
                                </p>

                            </div>
                        </fieldset>

                        <input type="submit" id="Submit_New_Account" name="Submit_New_Account" class="sub_btn" value="REGISTRA >" >

                     </form>
                </div>
            </div>
        </main>
        
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
        
    </body>
</html>