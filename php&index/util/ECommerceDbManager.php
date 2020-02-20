<?php
    require_once __DIR__."/../pathConfig.php";
    require_once DIR_UTIL."dbManager.php"; //includo la classe per la gestione del database
    require_once DIR_UTIL."utilFunctions.php";

    class Prodotto{
        //GENERALI
        public $tabella;
        public $prezzo;
        public $quantita;
        
        public $product_model;
        public $tipo;
        public $descrizione;
        public $immagine;
        public $produttore;
        
        //COMPUTER
        public $mem_SSD;
        public $mem_HDD;
        public $u_Misura_HDD;
        public $mem_RAM;
        public $scheda_Video;
        
        //MEMORIA
        public $q_Mem;
        public $u_Misura_Mem;
        public $velocita;
        
        //TABLET
        public $risoluzione;
        public $dim_Schermo;
        public $capacita_Mem;
        
        function Prodotto($product_model = null, $descrizione = null, $immagine = null){
            $this->product_model = $product_model;
            $this->descrizione = $descrizione;
            $this->immagine = $immagine;
        }
        
        function createProdotto($tabella, $prodotto){   //$prodotto è una riga del result della getProduct($tabella, $product_model), della getProductByID($tabella, $product_id) o della getProductByIDLike($product_id, $like)
            $this->tabella = $tabella;
            $this->prezzo = $prodotto['Prezzo'];
            $this->quantita = $prodotto['Quantita'];
            $this->product_model = $prodotto['Modello'];
            $this->descrizione = $prodotto['Descrizione'];
            $this->immagine = $prodotto['Immagine'];
            
            switch($tabella){
                case 'computer':
                    $this->tipo = $prodotto['Tipo_C'];
                    $this->produttore = $prodotto['Produttore'];
                    $this->mem_SSD = $prodotto['Mem_SSD'];
                    $this->mem_HDD = $prodotto['Mem_HDD'];
                    $this->u_Misura_HDD = $prodotto['u_Misura_HDD'];
                    $this->mem_RAM = $prodotto['Mem_RAM'];
                    $this->scheda_Video = $prodotto['Scheda_Video'];
                    break;
                case 'memoria':
                    $this->tipo = $prodotto['Tipo_M'];
                    $this->q_Mem = $prodotto['Q_Memoria'];
                    $this->u_Misura_Mem = $prodotto['u_Misura_Memoria'];
                    $this->velocita = $prodotto['Velocita'];
                    break;
                case 'tablet':
                    $this->produttore = $prodotto['Produttore'];
                    $this->risoluzione = $prodotto['Risoluzione'];
                    $this->dim_Schermo = $prodotto['Dim_Schermo'];
                    $this->capacita_Mem = $prodotto['Capacita_Mem'];
                    break;
                case 'periferica':
                    $this->tipo = $prodotto['Tipo_P'];
                    break;
            }
        }
    }

    
    function existsEmail($email){    //CERCO SE LA MAIL GIà ESISTE NEL DATABASE
        if($email != null){
            global $dbManager;
            $email = $dbManager->sqlInjectionFilter($email);
            $queryText = "select * from Utente where Email = '" . $email . "'";
            $result = $dbManager->performQuery($queryText);
            $dbManager->closeConnection();
            
            if(mysqli_num_rows($result) == 1){  //SE ESISTE GIà UN UTENTE CON TALE EMAIL 
                return 'email_crea_error';
            }
            else{
                return null;
            }
        }
    }

    function insertUser($utente, $email, $nome, $cognome, $password, $indirizzo, $cod_postale, $citta, $provincia){
        global $dbManager;
        
        $nome = $dbManager->sqlInjectionFilter($nome);
        $cognome = $dbManager->sqlInjectionFilter($cognome);
        $utente = $dbManager->sqlInjectionFilter($utente);
        $email = $dbManager->sqlInjectionFilter($email);
        $password = $dbManager->sqlInjectionFilter($password);
        $indirizzo = $dbManager->sqlInjectionFilter($indirizzo);
        $citta = $dbManager->sqlInjectionFilter($citta);
        
        $queryText = "insert into utente values ('" . $utente . "','" . $email . "','" . $nome . "','" . $cognome . "','" . $password . "','" . $indirizzo . "','" . $cod_postale . "','" . $citta . "','" . $provincia . "')";
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getUserData($utente){ 
        global $dbManager;
        $utente = $dbManager->sqlInjectionFilter($utente);
        $queryText = "select * from utente where Email = '" . $utente . "' or Nome_Utente = '" . $utente . "'";
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function checkUserPassword($utente, $password){
        global $dbManager;
        $utente = $dbManager->sqlInjectionFilter($utente);
        $password = $dbManager->sqlInjectionFilter($password);
        $queryText = "select * from utente where ( Email = '" . $utente . "' or Nome_Utente = '" . $utente . "' ) and Password = '" . $password . "'";
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function updateUserEmail($newEmail, $oldEmail){
        global $dbManager;
        
        $newEmail = $dbManager->sqlInjectionFilter($newEmail);
        
        $queryText = 'update utente set Email = "'.$newEmail.'" where Email = "'.$oldEmail.'";';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function updateUserInfo($email, $indirizzo, $cap, $citta, $provincia){
        global $dbManager;
        
        $email = $dbManager->sqlInjectionFilter($email);
        $indirizzo = $dbManager->sqlInjectionFilter($indirizzo);
        $citta = $dbManager->sqlInjectionFilter($citta);
        
        $queryText = 'update utente set Indirizzo="'.$indirizzo.'", Cod_Postale="'.$cap.'", Citta="'.$citta.'", Provincia="'.$provincia.'" where Email="'.$email.'";';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function existsProduct($tabella, $product_model){ 
        $result = getProduct($tabella, $product_model);
        $numRow = mysqli_num_rows($result);
        
        if($numRow >= 1){
            return true;
        }
        return false;
    }

    function insertProduct($prezzo, $quantita, $tabella, $prodotto){
        global $dbManager;
        $queryText = "insert into prodotto(Prezzo, Quantita) values (".$prezzo.",".$quantita.")";
        $result = $dbManager->performQuery($queryText);
        if(!$result){
            $dbManager->closeConnection();
            return $result;
        }
        
        $result = getMaxProductID();
        $row = $result->fetch_assoc();
        $product_id = $row['ID'];
        
        switch($tabella){
            case 'computer':
                $queryText = "insert into computer values ('".$product_id."','".$dbManager->sqlInjectionFilter($prodotto->product_model)."','".$prodotto->tipo."','".$dbManager->sqlInjectionFilter($prodotto->produttore)."','".$dbManager->sqlInjectionFilter($prodotto->descrizione)."','".$prodotto->mem_SSD."','".$prodotto->mem_HDD."','".$prodotto->u_Misura_HDD."','".$prodotto->mem_RAM."','".$dbManager->sqlInjectionFilter($prodotto->scheda_Video)."','".$prodotto->immagine."')";
                break;
            case 'memoria':
                $queryText = "insert into memoria values ('".$product_id."','".$dbManager->sqlInjectionFilter($prodotto->product_model)."','".$prodotto->tipo."','".$dbManager->sqlInjectionFilter($prodotto->descrizione)."','".$prodotto->q_Mem."','".$prodotto->u_Misura_Mem."','".$prodotto->velocita."','".$prodotto->immagine."')";
                break;
            case 'tablet':
                $queryText = "insert into tablet values ('".$product_id."','".$dbManager->sqlInjectionFilter($prodotto->product_model)."','".$prodotto->produttore."','".$dbManager->sqlInjectionFilter($prodotto->descrizione)."','".$prodotto->risoluzione."','".$prodotto->dim_Schermo."','".$prodotto->capacita_Mem."','".$prodotto->immagine."')";
                break;
            case 'periferica':
                $queryText = "insert into periferica values ('".$product_id."','".$dbManager->sqlInjectionFilter($prodotto->product_model)."','".$prodotto->tipo."','".$dbManager->sqlInjectionFilter($prodotto->descrizione)."','".$prodotto->immagine."')";
                break;
        }
        
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getAllProducts($sortOrder){
        global $dbManager;
        if($sortOrder == ''){
            $sortOrder = 'asc';
        }
        $queryText = 'select * from prodotto  order by Prezzo '.$sortOrder;
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getAllAcquirableProducts($sortOrder){
        global $dbManager;
        if($sortOrder == ''){
            $sortOrder = 'asc';
        }
        $queryText = 'select * from prodotto  where Acquistabile<>0 order by Prezzo '.$sortOrder;
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getProduct($tabella, $product_model){
        global $dbManager;
        $suff = suffix($tabella);
        $queryText = "select * from ".$tabella." inner join prodotto on id".$suff."=id_Prodotto where Modello='".$product_model."'";
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getProductByID($tabella, $product_id){
        global $dbManager;
        $suff = suffix($tabella);
        $queryText = 'select * from '.$tabella.' inner join prodotto on id'.$suff.'=id_Prodotto where id_Prodotto='.$product_id;
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

//CONTROLLO SE IL PRODOTTO DI ID $product_id PRESENTA LA STRINGA $like NEL NOME O NELLA DESCRIZIONE
    function getProductByIDLike($product_id, $like){
        global $dbManager;
        $like = $dbManager->sqlInjectionFilter($like);
        $tabella = findTable($product_id);
        $suff = suffix($tabella);
        $queryText = 'select * from '.$tabella.' inner join prodotto on id'.$suff.'=id_Prodotto where id_Prodotto='.$product_id.' and (Modello like \'%'.$like.'%\' or Descrizione like \'%'.$like.'%\')';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getProductQuantity($product_id){
        global $dbManager;
        $queryText = 'select Quantita from prodotto where id_Prodotto='.$product_id;
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $dbManager->closeConnection();
        return $row['Quantita'];
    }

    function getProductCartQuantity($product_id, $nomeUtente){
        global $dbManager;
        $queryText = 'select C.Quantita from prodotto as P inner join carrello as C on P.id_Prodotto=C.id_prodotto where P.id_Prodotto='.$product_id.' and C.Utente="'.$nomeUtente.'"';
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $dbManager->closeConnection();
        return $row['Quantita'];
    }

    function getProductFromTable($tabella){
        global $dbManager;
        $queryText = 'select * from '.$tabella;
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }
    
    function getTableProducts($tabella, $tipo, $produttore, $sortOrder){
        global $dbManager;
        $suff = suffix($tabella);
        $where = queryWhere($tabella, $tipo, $produttore, $suff);
        if($sortOrder == ''){
            $sortOrder = 'asc';
        }
        
        $queryText = 'select * from '.$tabella.' inner join prodotto on id_Prodotto = id'.$suff.$where.' order by Prezzo '.$sortOrder;
        
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getMaxProductID(){
        global $dbManager;
        $queryText = "select MAX(id_Prodotto) as ID from prodotto";
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function modProduct($tabella, $product_id, $prezzo, $quantita, $immagine, $descrizione, $errorKind){ //MODIFICA UN PRODOTTO
        global $dbManager;
        $suff = suffix($tabella);
        $queryText = "update prodotto set Prezzo=".$prezzo.", Quantita=".$quantita." where id_Prodotto = ".$product_id.";";
        $result = $dbManager->performQuery($queryText);
        
        if(!$result){
            $errorType = 'mod_product_error';
            $dbManager->closeConnection();
            header('Location: ../admin_ModProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, LO SEGNALO
            exit;
        }
        
        $queryText = "update ".$tabella." set Immagine='".$immagine."', Descrizione='".$dbManager->sqlInjectionFilter($descrizione)."' where id".$suff." = ".$product_id.";";
        $result = $dbManager->performQuery($queryText);
        
        if(!$result){
            $errorType = 'mod_product_error';
            $dbManager->closeConnection();
            header('Location: ../admin_ModProdotto.php?errorKind='.$errorKind.'&errorType=' . $errorType );//IN CASO DI ERRORE, LO SEGNALO
            exit;
        }
        
        $dbManager->closeConnection();
    }

    function deleteProduct($tabella, $product_model){
        global $dbManager;
        
        $result = getProduct($tabella, $product_model);
        $row = $result->fetch_assoc();
        $suff = suffix($tabella);
        $product_id = $row['id'.$suff];
        
        $queryText = "update prodotto set Acquistabile=0 where id_Prodotto=".$product_id.";";
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function countAllProducts(){
        global $dbManager;
        $queryText = 'select count(*) as NUM from prodotto';
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $dbManager->closeConnection();
        return $row['NUM'];
    }

    function countProducts($tabella, $tipo, $produttore){   //RESTITUISCE IL NUMERO DI PRODOTTI PRESENTI NEL DATABASE RELATIVI AD UNA DATA TIPOLOGIA
        global $dbManager;
        $suff = suffix($tabella);
        $where = queryWhere($tabella, $tipo, $produttore, $suff);
        $queryText = 'select count(*) as NUM from '.$tabella.$where;
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $dbManager->closeConnection();
        return $row['NUM'];
    }

    function countProductsAcquirableLike($like){
        global $dbManager;
        $like = $dbManager->sqlInjectionFilter($like);
        $sum = 0;
        $whereLike = ' Modello like \'%'.$like.'%\' or Descrizione like \'%'.$like.'%\' ';
    //CONTO I COMPUTER
        $queryText = 'select count(*) as NUM from prodotto inner join computer on id_Prodotto=id_C where Acquistabile<>0 and ('.$whereLike.')';
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $sum += $row['NUM'];
    //CONTO LE MEMORIE
        $queryText = 'select count(*) as NUM from prodotto inner join memoria on id_Prodotto=id_M where Acquistabile<>0 and ('.$whereLike.')';
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $sum += $row['NUM'];
    //CONTO I TABLET
        $queryText = 'select count(*) as NUM from prodotto inner join tablet on id_Prodotto=id_T where Acquistabile<>0 and ('.$whereLike.')';
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $sum += $row['NUM'];
    //CONTO LE PERIFERICHE
        $queryText = 'select count(*) as NUM from prodotto inner join periferica on id_Prodotto=id_P where Acquistabile<>0 and ('.$whereLike.')';
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $sum += $row['NUM'];
        
        $dbManager->closeConnection();
        return $sum;
    }

    function countAllProdottiEliminati(){
        global $dbManager;
        $queryText = 'select count(*) as NUM from prodotto where Acquistabile=0';
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $dbManager->closeConnection();
        return $row['NUM'];
    }

    function countProdottiEliminati($tabella, $tipo, $produttore){//RESTITUISCE IL NUMERO DI PRODOTTI PRESENTI NEL DATABASE SEGNATI COME 'NON ACQUISTABILI' RELATIVI AD UNA DATA TIPOLOGIA
        global $dbManager;
        $suff = suffix($tabella);
        $where = queryWhere($tabella, $tipo, $produttore, $suff);
        $queryText = 'select count(*) as NUM from '.$tabella.' inner join prodotto on id'.$suff.'=id_Prodotto '.$where.' and Acquistabile=0';
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $dbManager->closeConnection();
        return $row['NUM'];
    }

    function updateProductQuantity($id_prodotto, $newQuantita){
        global $dbManager;
        $ret = false;
        
        if($newQuantita >= 0){
            $queryText = 'update prodotto set Quantita='.$newQuantita.' where id_Prodotto='.$id_prodotto;
            $result = $dbManager->performQuery($queryText);
            
            $ret = true;
        }
        
        $dbManager->closeConnection();
        return $ret;
    }

    function findTable($id){    //RESTITUISCE IL NOME DELLA TABELLA ALLA QUALE APPARTIENE UN DATO PRODOTTO
        global $dbManager;
        $queryText = 'select count(*) as NUM from computer where id_C='.$id;
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        
        if($row['NUM'] == 1){
            $dbManager->closeConnection();
            return 'computer';
        } 
        
        $queryText = 'select count(*) as NUM from memoria where id_M='.$id;
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        if($row['NUM'] == 1){
            $dbManager->closeConnection();
            return 'memoria';
        }
        
        $queryText = 'select count(*) as NUM from periferica where id_P='.$id;
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        if($row['NUM'] == 1){
            $dbManager->closeConnection();
            return 'periferica';
        }
        
        $queryText = 'select count(*) as NUM from tablet where id_T='.$id;
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $dbManager->closeConnection();
        if($row['NUM'] == 1) return 'tablet';
        
        return '';
        
    }

    function getCartItem($utente, $item_id){
        global $dbManager;
        $queryText = 'select * from carrello where Utente="'.$utente.'" and id_prodotto='.$item_id;
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getAllCartItems($utente){
        global $dbManager;
        $queryText = 'select *, C.Quantita as C_Quantita, P.Quantita as P_Quantita from carrello as C inner join prodotto as P on C.id_prodotto=P.id_Prodotto where Utente="'.$utente.'"';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getSpesaCart($utente){
        global $dbManager;
        $queryText = 'select sum(C.quantita*P.Prezzo) as Spesa from carrello as C inner join prodotto as P on C.id_prodotto=P.id_Prodotto where Utente="'.$utente.'"';
        $result = $dbManager->performQuery($queryText);
        $row = $result->fetch_assoc();
        $dbManager->closeConnection();
        return $row['Spesa'];
    }

    function emptyCart($utente){
        global $dbManager;
        $queryText = 'delete from carrello where Utente="'.$utente.'";';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function deleteCartItem($utente, $item_id){
        global $dbManager;
        $queryText = 'delete from carrello where Utente="'.$utente.'" and id_prodotto='.$item_id;
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function insertCartItem($utente, $item_id){
        global $dbManager;
        $queryText = 'insert into carrello values ("'.$utente.'",'.$item_id.',1);';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function updateQuantityCartItem($utente, $product_id, $new_quantity){
        global $dbManager;
        $queryText = 'update carrello set Quantita='.$new_quantity.' where Utente="'.$utente.'" and id_prodotto='.$product_id;
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function checkIfCart($utente, $product_id){    //RESTITUISCE TRUE SE UN DATO PRODOTTO è PRESENTE NEL CARRELLO DI UNA DATA PERSONA, FALSE ALTRIMENTI
        global $dbManager;
        $queryText = 'select * from carrello where Utente = "'.$utente.'" and id_prodotto='.$product_id;
        $result = $dbManager->performQuery($queryText);
        $numRow = mysqli_num_rows($result);
        $dbManager->closeConnection();
        
        if($numRow > 0){
            return TRUE;
        }
        
        return FALSE;
    }

    function getAllOrdiniAndUsersData($whereClause){
        global $dbManager;
        $queryText = 'select *, date_format(Data_ordine, "%d %M %Y, %T") as Data from ordine inner join utente on Utente=Nome_Utente '.$whereClause.' order by Data desc;';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getUserOrdini($utente){
        global $dbManager;
        $queryText = 'select *, date_format(Data_ordine, "%d %M %Y, %T") as Data from ordine where Utente="'.$utente.'" order by Codice_Ordine desc;';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getOrdine($codice_Ordine){
        global $dbManager;
        $queryText = 'select *, date_format(Data_ordine, "%d %M %Y, %T") as Data from ordine where Codice_ordine='.$codice_Ordine;
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function insertOrdine($utente){
        global $dbManager;
        $queryText = 'insert into ordine (Utente) values ("'.$utente.'");';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }
    
    function getMaxOrdineID(){
        global $dbManager;
        $queryText = 'select MAX(Codice_ordine) as ID from ordine';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function setOrdineCancellato($ordine_id){
        global $dbManager;
        $queryText = 'update ordine set Cancellato=1 where Codice_ordine="'.$ordine_id.'";';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function setOrdinePagato($ordine_id){
        global $dbManager;
        $queryText = 'update ordine set Pagato=1 where Codice_ordine="'.$ordine_id.'";';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function deleteOrdine($utente, $ordine){
        global $dbManager;
    
    //RIPRISTINO LE QUANTITA PRE-ORDINE DEI PRODOTTI 
        $result = getOrdineProducts($utente, $ordine);
        $numRow = mysqli_num_rows($result);
        for($i = 1; $i <= $numRow; $i++){
            $row = $result->fetch_assoc();
            $id = $row['id_prodotto'];
            $deltaQuantita = $row['Quantita'];
            $oldQuantita = getProductQuantity($id);
            $newQuantita = $oldQuantita + $deltaQuantita;
            
            $result2 = updateProductQuantity($id, $newQuantita);
        }
        
    //CANCELLO L'ORDINE
        $result = setOrdineCancellato($ordine);
        $dbManager->closeConnection();
        return $result;
    }

    function getSpesaOrdine($utente, $ordine){
        global $dbManager;
        $queryText = 'select sum(Quantita*Prezzo) as Spesa from storico_acquisti natural join ordine where Utente="'.$utente.'" and Codice_ordine='.$ordine;
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function getOrdineProducts($utente, $ordine){
        global $dbManager;
        $queryText = 'select * from ordine natural join storico_acquisti where Utente="'.$utente.'" and Codice_ordine='.$ordine;
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function insertProductIntoStorico($id_prodotto, $prezzo, $quantita){
        global $dbManager;
        
        $result = getMaxOrdineID();
        $row = $result->fetch_assoc();
        $id_ordine = $row['ID'];
        
        $queryText = 'insert into storico_acquisti values ('.$id_ordine.', '.$id_prodotto.', '.$prezzo.', '.$quantita.');';
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }

    function callQuery($queryText){
        global $dbManager;
        $result = $dbManager->performQuery($queryText);
        $dbManager->closeConnection();
        return $result;
    }
?>