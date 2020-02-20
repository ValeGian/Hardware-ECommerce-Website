<?php
    if(isset($_POST['Submit_New_Account'])){
        require_once "../pathConfig.php";
        require_once DIR_UTIL."ECommerceDbManager.php";
        require_once DIR_UTIL."sessionConfig.php";//includo la funzione per settare le variabili di sessione relative all'utente

        $errorType = null;
        $errorKind = 'ac_reg_error';

        if($_POST['nome'] == '' || $_POST['cognome'] == '' || $_POST['nomeUtente'] == '' || $_POST['Email'] == '' || $_POST['passwd'] == '' || $_POST['Conf_passwd'] == '' || $_POST['indirizzo'] == '' || $_POST['cod_postale'] == '' || $_POST['citta'] == ''){   //SE NON SONO SETTATI CAMPI OBBLIGATORI
            $errorType = 'form_compile_error';
            header('Location: ../registrationPage.php?errorKind='.$errorKind.'&errorType=' . $errorType );
            exit;
        }

        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $nomeUtente = $_POST['nomeUtente'];
        $email = $_POST['Email'];
        $password = $_POST['passwd'];
        $conf_password = $_POST['Conf_passwd'];
        $indirizzo = $_POST['indirizzo'];
        $cod_postale = $_POST['cod_postale'];
        $citta = $_POST['citta'];
        $provincia = $_POST['provincia'];

    //CONTROLLO SE L'ACCOUNT ESISTE GIà
        $result = getUserData($nomeUtente);
        $numRow = mysqli_num_rows($result);

        if($numRow != 0){   //SE ESISTE

            $errorType = 'utente_already_exists_error';
            header('Location: ../registrationPage.php?errorKind=ac_reg_error&errorType=' . $errorType );
            exit;
        }

        if($password !== $conf_password){    //SE LA PASSWORD DI CONFERMA NON è UGUALE ALLA PASSWORD
            $errorType = 'password_conf';
        }
        else if($provincia === '-'){    //SE NON è STATA SELEZIONATA UNA PROVINCIA VALIDA
            $errorType = 'provincia_error';
        }
        else{   //REGISTRO IL NUOVO ACCOUNT
            $result = insertUser($nomeUtente, $email, $nome, $cognome, $password, $indirizzo, $cod_postale, $citta, $provincia);

            if($result === false){
                $errorType = 'reg_failure';
            }
            else{
                if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
                    session_start();
                }
                setSession(true, $nomeUtente, $email);
                header('Location: ../personalProfile.php');    //REINDIRIZZA AL PROFILO PERSONALE
                exit;
            }
        }
        header('Location: ../registrationPage.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, REINDIRIZZO ALLA PAGINA DI REGISTRAZIONE E LO SEGNALO
    }
?>