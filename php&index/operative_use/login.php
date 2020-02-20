<?php
    if(isset($_POST['Submit_Login'])){
        require_once "../pathConfig.php";
        require_once DIR_UTIL."dbManager.php";//includo la classe per la gestione del database
        require_once DIR_UTIL."sessionConfig.php";//includo la funzione per settare le variabili di sessione relative all'utente
        require_once DIR_UTIL."ECommerceDbManager.php"; //INCLUDO LE FUNZIONI DI UTILITà PER ACCEDERE AL DATABASE

        $errorType = null;
        $errorKind = 'login_error';

        if($_POST['login-id'] == '' || $_POST['passwd'] == ''){   //SE NON è STATA SETTATA LA MAIL O LA PASSWORD
            $errorType = 'form_compile_error';
            header('Location: ../loginPage.php?errorKind='.$errorKind.'&errorType=' . $errorType );
            exit;
        }

        $utente = $_POST['login-id'];
        $password = $_POST['passwd'];

        //CONTROLLO SE ESISTE UN ACCOUNT CON TALE EMAIL O NOME UTENTE
        $result = getUserData($utente);
        $numRow = mysqli_num_rows($result);

        if($numRow != 1){   //SE NON ESISTE
            $errorType = 'utente_dnot_exists_error';
        }
        else{   //CONTROLLO CHE LA PASSWORD SIA CORRETTA PER TALE ACCOUNT
            $result = checkUserPassword($utente, $password);
            $numRow = mysqli_num_rows($result);

            if($numRow != 1){   //SE LA PASSWORD NON è CORRETTA
                $errorType = 'password_error';
            }
            else{
                $userInfo = $result->fetch_assoc();
                $nomeUtente = $userInfo['Nome_Utente'];
                $email = $userInfo['Email'];
                setSession(true, $nomeUtente, $email);

                header('Location: ../personalProfile.php');    //REINDIRIZZA AL PROFILO PERSONALE
                exit;
            }
        }

        header('Location: ../loginPage.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, REINDIRIZZO ALLA PAGINA DI LOGIN E LO SEGNALO
        exit;
    }
?>