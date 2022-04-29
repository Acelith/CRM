<?php

/**
 * index.php    file principale per il caricamento del programma 
 *
 * @author Joël Moix  
 */

#Importo i file necessari 
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";;

# Controllo se l'utente è già loggato, nel caso non lo fosse visualizzo il modulo di login
if (!utente::isLogged()) {
    $ret = Module::loadLogin();
} else {

    # Controllo se è stato richiesto un modulo specifico altrimenti carico quello di default
    if (isset($_GET['m'])) {
        $ret = Module::loadModule($_GET['m']);
    } else {
        $ret = Module::loadDefault();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!-- Importo JQuery e JQuery di bootstrap-->
    <script src="lib/JQuery/JQuery.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.js"></script>

    <!-- Importo Bootbox -->
    <script src="lib/bootbox/bootbox.all.js"></script>

    <!-- Importo bootstrap -->
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">

    <!-- Importo Icone -->
    <link rel="stylesheet" href="/lib/fontawesome/css/all.css">
    <link rel="stylesheet" href="/lib/bootstrap-icons/font/bootstrap-icons.css">

    <!-- importo custom Js -->
    <?php echo $ret['js']; ?>

    <!-- importo custom css -->
    <?php echo $ret['css']; ?>

    <title>Gestionale</title>
</head>

<body>
    <?php
    # Importo la navbar
    echo $ret['navbar'];

    # Importo il file php principale del modulo
    require_once $ret['php'];
    ?>
</body>


</html>