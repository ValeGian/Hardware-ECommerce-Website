<?php
    if(isset($_POST['Submit_Crea'])){
        require_once "../pathConfig.php";
        require_once DIR_UTIL."ECommerceDbManager.php";

        $errorType = null;
        $errorKind = 'ac_creation_error';

        if($_POST['email_crea'] == ''){   //SE NON è STATA SETTATA LA MAIL
            $errorType = 'form_compile_error';
            header('Location: ../loginPage.php?errorKind='.$errorKind.'&errorType=' . $errorType );
            exit;
        }

        if(!isset($_POST['privacy_check'])){    //SE NON è STATA SPUNTATA LA CHECKBOX SULLA PRIVACY
            $errorType = 'privacy_check_error';
            header('Location: ../loginPage.php?errorKind='.$errorKind.'&errorType=' . $errorType );
            exit;
        }
        else{
            $email = $_POST['email_crea'];
            $errorType = existsEmail($email);
            if($errorType === null){ //SE NON CI SONO STATI ERRORI
                if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
                    session_start();
                }
                $_SESSION['Email'] = $email;    //SETTO LA VARIABILE DI SESSIONE Email
                header('Location: ../registrationPage.php');    //MANDO ALLA PAGINA PER LA REGISTRAZIONE EFFETTIVA
                exit;
            }
            else
                header('Location: ../loginPage.php?errorKind='.$errorKind.'&errorType=' . $errorType );
            exit;
        }
    }

?>