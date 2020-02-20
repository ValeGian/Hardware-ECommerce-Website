<?php
    if(session_id() == '')  //SE NON è STATA ANCORA APERTA UNA SESSIONE
        session_start();

    $ADMIN_IS_HERE = false; //SETTATA true SE L'ACCESSO ALLA PAGINA VIENE EFFETTUATO DA UNO USER ADMIN

    if(isset($_SESSION['NomeUtente']) && $_SESSION['NomeUtente'] == 'Admin')
        $ADMIN_IS_HERE = true;
?>

<div id="principal-header-container" class="container">
    <header> 
        <div id="header-logo">
            <a href="./index.php" title="Hardware E-COMMERCE by Giannini Valerio">
                <img src="../css/img/Logo.png" alt="Hardware E-COMMERCE by GIANNINI VALERIO" >
            </a>
        </div>
                
        <div id="header_search_bar_container">
            <form action="./productListPage.php" name="Search_Bar_Form" id="Search_Bar_Form" method="post">
                <div>
                    <input type="text" name="search_query" onkeyup="userSearchBarEventHandler.onKeyUpSearchBarEvent(this)" id="search_bar_input" autocomplete="off">
                    <button type="submit" name="Submit_Search" id="Submit_Search" class="sub_btn">
                        <span id="search_icon"></span>
                    </button>
                </div>
                <div id="search_bar_products_box">
                    <div id="search_result_count">
                        <span><b>0</b> Risultati Trovati</span>
                    </div>
                    <div id="search_bar_products_list_container" onscroll="userSearchBarEventHandler.onScrollSearchBarEvent()">
                        <!-- AJAX SEARCH BAR -->
                    </div>
                </div>
            </form>
        </div>
                <?php   
                    if(!$ADMIN_IS_HERE){
                        
                        echo'<div class="header-element-right">
                                <a id="shopping-cart" href="./cartPage.php" title="Vedi il tuo Carrello" class="header-box">';
                        
                    //SE LOGGATO E NON ADMIN, SEGNALO IL TOTALE CORRENTE DELLA SPESA DEL CARRELLO
                        $spesa = '0.00';
                        if(isset($_SESSION['NomeUtente'])){

                            require_once "./pathConfig.php";
                            require_once DIR_UTIL . "dbManager.php";//includo la classe per la gestione del database

                            global $dbManager;

                            if (isset($_SESSION['Logged']) && $_SESSION['Logged'] === true){    //SE GIà LOGGATO
                                $email = $_SESSION['Email'];
                                $nomeUtente = $_SESSION['NomeUtente'];
                            }
                            else{
                                $email = '';
                                $nomeUtente = '';
                            }

                            $queryText = 'select sum(P.Prezzo * C.Quantita) as Spesa from prodotto as P inner join carrello as C on P.id_Prodotto = C.id_prodotto inner join utente on Utente = Nome_Utente where Nome_Utente="'.$nomeUtente.'";';
                            $result = $dbManager->performQuery($queryText);

                            if(!$result){
                                $spesa = "0.00";
                            }
                            else{
                                $row = $result->fetch_assoc();
                                $spesa = $row['Spesa'];
                                $spesa = number_format(round($spesa, 2), 2);
                            }
                        }
                        echo'<span id="spesaCartH">&euro;'.$spesa.'</span>';
                        
                        echo'   </a>
                            </div>';
                    }
                ?>
        
        <div class="header-element-right">
        <?php
            
            if(!isset($_SESSION['Logged']) || $_SESSION['Logged'] === false){ //SE UN UTENTE ACCEDE AL SITO MA NON SI è ANCORA LOGGATO/REGISTRATO
                echo '<a class="header-box" href="./loginPage.php" title="Accedi al tuo account cliente">Accedi</a>';
            }
            else if($ADMIN_IS_HERE){   //SE è LOGGATO L'ADMIN
                echo '<a class="header-box" title="Sei l\'Admin">ADMIN</a>';
            }
            else{   //SE è LOGGATO UN UTENTE
                echo '<a class="header-box" href="./personalProfile.php" title="Vedi il tuo account">' . $_SESSION['NomeUtente'] . '</a>';
            }
        ?>
            
        </div>
        
        <?php
            if($ADMIN_IS_HERE){
                echo '<div class="header-element-right">
                         <form name="logout" action="./operative_use/logout.php" method="post" class="header-box">
                             <button type="submit" id="Submit_Logout" name="Submit_Logout" class="btn">
                                 <img src="../css/img/Logout.png" alt=""> LOGOUT
                             </button>
                         </form>
                     </div>';
            }
        ?>
        
        <div id="header-principal-navigation-container" class="container">
            <nav class="header-principal-navigation">
                <ul>
                    
                    <?php

                        if($ADMIN_IS_HERE){  
                            echo    '<li class="dropdown-trigger admin_page_trigger">';
                            echo        '<a href="./admin_VisOrdini.php" class="principal-navigation-item">VISUALIZZA ORDINI</a>';
                            echo    '</li>';
                            echo    '<li class="dropdown-trigger admin_page_trigger">';
                            echo        '<a href="./admin_VisProdotti.php" class="principal-navigation-item">VISUALIZZA PRODOTTI</a>';
                            echo    '</li>';
                            echo    '<li class="dropdown-trigger admin_page_trigger">';
                            echo        '<a href="./admin_InsProdotto.php" class="principal-navigation-item">INSERIMENTO PRODOTTI</a>';
                            echo    '</li>';
                            echo    '<li class="dropdown-trigger admin_page_trigger">';
                            echo        '<a href="./admin_ModProdotto.php" class="principal-navigation-item">MODIFICA PRODOTTI</a>';
                            echo    '</li>';
                            echo    '<li class="dropdown-trigger admin_page_trigger">';
                            echo        '<a href="./admin_DelProdotto.php" class="principal-navigation-item">ELIMINA PRODOTTI</a>';
                            echo    '</li>';
                            echo    '<li class="dropdown-trigger admin_page_trigger">';
                            echo        '<a href="./admin_GestOrdini.php" class="principal-navigation-item">GESTISCI ORDINI</a>';
                            echo    '</li>';
                        }
                        else{
                            echo    '<li class="dropdown-trigger">
                                        <div class="principal-navigation-item default-cursor">
                                                    Notebook &amp; PC Desktop
                                            <sup class="information">WORKSTATION</sup>
                                        </div>

                                        <div class="dropdown three-col">

                                            <div class="column-layout">
                                                <div class="dropdown-content">
                                                    <h2>
                                                        <strong>
                                                                <a href="./productListPage.php?Tabella=computer&Tipo=notebook&Page=1">
                                                                    <span>NOTEBOOK ></span>
                                                                    <img src="../css/img/Notebook.jpg" alt="">
                                                                </a>
                                                        </strong>
                                                    </h2>

                                                    <ul>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=notebook&Produttore=acer&Page=1">Acer</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=notebook&Produttore=apple&Page=1">Apple</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=notebook&Produttore=asus&Page=1">Asus</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=notebook&Produttore=lenovo&Page=1">Lenovo</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=notebook&Produttore=Altro&Page=1">Altro</a>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>

                                            <div class="column-layout">
                                                <div class="dropdown-content">
                                                    <h2>
                                                        <strong>
                                                                <a href="./productListPage.php?Tabella=computer&Tipo=pc_desktop&Page=1">
                                                                    <span>PC DESKTOP ></span>
                                                                    <img src="../css/img/PC-Desktop.jpg" alt="">
                                                                </a>
                                                        </strong>
                                                    </h2>

                                                    <ul>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=pc_desktop&Produttore=acer&Page=1">Acer</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=pc_desktop&Produttore=apple&Page=1">Apple</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=pc_desktop&Produttore=asus&Page=1">Asus</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=pc_desktop&Produttore=lenovo&Page=1">Lenovo</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=pc_desktop&Produttore=Altro&Page=1">Altro</a>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>

                                            <div class="column-layout">
                                                <div class="dropdown-content">
                                                    <h2>
                                                        <strong>
                                                                <a href="./productListPage.php?Tabella=computer&Tipo=workstation&Page=1">
                                                                    <span>WORKSTATION ></span>
                                                                    <img src="../css/img/Workstation.jpg" alt="">
                                                                </a>
                                                        </strong>
                                                    </h2>

                                                    <ul>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=workstation&Produttore=dell&Page=1">Dell</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=workstation&Produttore=fujitsu&Page=1">Fujitsu</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=workstation&Produttore=lenovo&Page=1">Lenovo</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=computer&Tipo=workstation&Produttore=Altro&Page=1">Altro</a>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>

                                    </li>

                                    <li class="dropdown-trigger">
                                        <div class="principal-navigation-item default-cursor">
                                            Hardware &amp; Periferiche
                                            <sup  class="information">COMPONENTI PC</sup>
                                        </div>
                                        <div class="dropdown two-col">

                                            <div class="column-layout">
                                                <div class="dropdown-content">
                                                    <h2>
                                                        <strong>
                                                                <a href="./productListPage.php?Tabella=memoria&Page=1">
                                                                    <span>COMPONENTI PC ></span>
                                                                </a>
                                                        </strong>
                                                    </h2>

                                                    <ul>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=memoria&Tipo=RAM&Page=1">Memorie RAM</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=memoria&Tipo=HDD&Page=1">Hard Disk</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=memoria&Tipo=SSD&Page=1">SSD</a>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>

                                            <div class="column-layout">
                                                <div class="dropdown-content">
                                                    <h2>
                                                        <strong>
                                                                <a href="./productListPage.php?Tabella=periferica&Page=1">
                                                                    <span>PERIFERICHE PC ></span>
                                                                </a>
                                                        </strong>
                                                    </h2>

                                                    <ul>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=periferica&Tipo=mouse&Page=1">Mouse</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=periferica&Tipo=tastiera&Page=1">Tastiere</a>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="dropdown-trigger">
                                        <div class="principal-navigation-item default-cursor">Tablet</div>

                                        <div class="dropdown one-col">

                                            <div class="column-layout">
                                                <div class="dropdown-content">
                                                    <h2>
                                                        <strong>
                                                                <a href="./productListPage.php?Tabella=tablet&Page=1">
                                                                    <span>TABLET ></span>
                                                                    <img src="../css/img/Tablet.jpg" alt="">
                                                                </a>
                                                        </strong>
                                                    </h2>

                                                    <ul>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=tablet&Produttore=apple&Page=1">Apple</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=tablet&Produttore=huawei&Page=1">Huawei</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=tablet&Produttore=samsung&Page=1">Samsung</a>
                                                        </li>
                                                        <li>
                                                            <a href="./productListPage.php?Tabella=tablet&Produttore=Altro&Page=1">Altro</a>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>

                                        </div>

                                    </li>';
                                }
                    ?>

                </ul>
            </nav>
        </div>
    </header>
</div>