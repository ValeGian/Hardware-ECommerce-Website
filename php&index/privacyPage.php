<?php
	if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
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
        
        <script src="../js/ajax/ajaxManager.js"></script>
        <script src="../js/ajax/userSearchBarEventHandler.js"></script>
        <script src="../js/ajax/SearchBarUtility.js"></script>
        
		<title>Privacy - Hardware E-COMMERCE</title>
    </head>
    <body>
        <?php 
            require_once "./pathConfig.php";
            require DIR_LAYOUT."Principal_Header.php"; 
        ?>
        <main>
            <div id="main_content" class="principal-content">
                <div class="padded-container">
                    <section>
                        <h1>Termini di Servizio</h1>
                        
                        <div class="padded-container">
                            <h2>1. Accettare i Termini di Servizio</h2>
                            <p>Si prega di leggere i Termini di Servizio attentamente prima di usare il sito.<br>
                            Usando o accedendo i Servizi, accetta di essere legato dai termini e dalle condizioni presentate da questa informativa.<br>
                            Se non accetta tutti i termini e condizioni presentate, non dovrebbe utilizzare i Servizi.</p>

                            <h2>2.Modifiche a questo Accordo</h2>
                            <p>Hardware E-COMMERCE si riserva il diritto di modificare questo accordo (1) postando un Accordo rivisionato e (2) informandola che questo Accordo &egrave; stato modificato. Lei &egrave; responsabile di leggere eventuali modifiche a questo Accordo.<br>
                            </p>
                        </div>
                    </section>
                    
                    <section>
                        <h1>Privacy Policy</h1>
                        
                        <div class="padded-container">
                            <h2>Cosa copre questa Privacy Policy</h2>
                            <p>Questa Privacy Policy copre il trattamento delle informazioni raccolte quando sta usando o accedendo ai nostri Servizi.<br>
                            Questa Privacy Policy copre anche il trattamento di ogni informazione relativa a lei che i nostri partner condividono con noi o che noi condividiamo con i nostri partner.<br>
                            Questa Privacy Policy non si applica all'uso di terze parti da noi non possedute, controllate o gestite, incluso ma non limitato a siti, servizi o applicazionidi terze parti ("Servizi di Terze Parti").<br>
                            Pur provando a lavorare solo con Servizi di Terze Parti che condividono il nostro rispetto per la sua privacy, non ci prendiamo la responsabilit&agrave; per i contenuti o le privacy policies di tali Servizi di Terze Parti. La incoraggiamo a controllare attentamente tali privacy policies dei servizi ai quali accede.
                            </p>

                            <h2>Che Cosa Raccogliamo e Come lo Usiamo</h2>
                            <p><strong>Account Information:</strong> Quando crea un account, le verranno chieste informazioni come username, password e indirizzo email ("Account Information"). Usiamo tali informazioni, da sole o insieme ad altre, per migliorare i Servizi, ad esempio personalizzando la sua esperienza sul sito.<br><br>
                            <strong>Comunicazioni Email:</strong> Come parte dei Servizi, potrebbe occasionalmente ricevere email e altre comunicazioni da noi. Comunicazioni amministrative relative al suo Account (ad esempio allo scopo di recuperare i dati del suo account)sono considerate parte dei Servizi.
                            </p>

                            <h2>La Sicurezza delle sue Informazioni</h2>
                            <p>Le Informazioni del suo Account sono protette da una password per la sua privacy e sicurezza. Per prevenire accessi non autorizzati al suo Account, deve creare una password unica, sicura e protetta e deve limitare l'accesso al profilo dal suo computer e dal suo browser eseguendo il Sign-out dopo aver finito di utilizzare il sito.<br>
                            Il nostro scopo &egrave; quello di proteggere le sue informazioni per assicurare che esse siano mantenute private, non possiamo per&oacute; garantire al sicurezza di alcuna informazione. Accessi non autorizzati, errori hardware o software e altri fattori potrebbero compromettere la sicurezza delle sue informazioni in ogni momento.
                            </p>

                            <h2>Che Informazioni pu&oacute; Accedere</h2>
                            <p>Se &egrave; un utente registrato, pu&oacute; accedere alla maggior parte delle informazioni relative al suo account loggando e controllando i dati del suo account.
                            </p>

                            <h2>Modifiche alla Privacy Policy</h2>
                            <p>Potrebbero venir fatte delle modifiche a questa Privacy Policy di tanto in tanto. L'uso delle informazioni personali che raccogliamo sono soggette alla Privacy Policy in effetto al momento del raccoglimento di tali informazioni.
                            </p>
                        </div>
                    </section>
                </div>
            </div>
        </main>
        <?php require DIR_LAYOUT."Principal_Footer.php"; ?>
    </body>
</html>


					