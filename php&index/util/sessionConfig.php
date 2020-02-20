<?php
    if(session_id() == ''){ //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();
    }

	function setSession($logged, $nomeUtente, $Email){
		$_SESSION['Logged'] = $logged;
        $_SESSION['NomeUtente'] = $nomeUtente;
        $_SESSION['Email'] = $Email;
	}
?>