<?php
    if(isset($_POST['Submit_Logout']) || (isset($_GET['Submit']) && $_GET['Submit'] == 'logout')){
        if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
            session_start();
        }
        unset($_SESSION['Logged']);
        unset($_SESSION['Email']);
        unset($_SESSION['NomeUtente']);

        header("Location: ../index.php");
        exit;
    }
?>