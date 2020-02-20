<?php
    if(isset($_GET['Submit']) && $_GET['Submit'] == 'userModPage'){
        require_once "../pathConfig.php";
        require_once DIR_UTIL."ECommerceDbManager.php";
        require_once DIR_UTIL."sessionConfig.php";    //includo la funzione per settare le variabili di sessione relative all'utente

        global $dbManager;


        if(isset($_GET['Change']) && $_GET['Change'] == 'email'){
            $urlRet = '../personal_InfoPage.php?';
            $errorKind = 'mod_ind_error';

            $oldEmail = $_POST['oldEmail'];
            $newEmail = $_POST['newEmail'];

            if($newEmail == ''){
                $urlRet = '../userModPage.php?Change=email&Email='.$oldEmail.'&errorKind='.$errorKind.'&errorType=form_compile_error';
            }
            else{
                if($oldEmail !== $newEmail){
                    $result = updateUserEmail($newEmail, $oldEmail);  

                    $_SESSION['Email'] = $newEmail;
                }
                $urlRet .= 'Message=email_succ_changed';
            }
        }
        else{
            $urlRet = $_GET['Url'];
            $errorKind = 'mod_dati_error';

            $email = $_GET['Email'];

            $indirizzo = $_POST['indirizzo'];
            $cap = $_POST['cod_postale'];
            $citta = $_POST['citta'];
            $provincia = $_POST['provincia'];

            if($indirizzo == '' || $cap == '' || $citta == '' || $provincia == ''){
                $urlRet = '../userModPage.php?Url=../Personal_InfoPage.php&Indirizzo=via%20chirico%2023&Cap=54233&Citta=bologna&Provincia=Bologna&Email=giorgioManfre@gmail.com&errorKind='.$errorKind.'&errorType=form_compile_error';
            }
            else{
                $result = updateUserInfo($email, $indirizzo, $cap, $citta, $provincia);   
                $urlRet.='?Message=address_succ_changed';
            }

        }

        header('Location: '.$urlRet);
        exit;
    }

?>