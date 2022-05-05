<?php
/**
 * index.php    file principale per il caricamento del programma 
 *
 * @author Joël Moix  
 */

#Importo i file necessari 
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>

    <!-- Importo Bootbox -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.3/bootbox.js" integrity="sha512-OMYI9iOelB12PWdWHfU6XouDuUvszFZEywO4W9KFJGP3aj/nP5UECd5ctMqRm+/9Qk3oOFqhbXVi6cJAqlAUuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Importo bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <!-- Importo Icone -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- importo custom Js -->
    <?php echo $ret['js']; ?>

    <!-- importo custom css -->
    <?php echo $ret['css']; ?>

    <title>Gestionale</title>
</head>

<body>
    <?php
    if (utente::isLogged()) {
        echo "<img class='img_header' src='/img/" . impostazioni::getSetting("immagine_azienda") . "'>";
        echo " <div class='welcome-msg'>";
        echo "<p>Buongiorno&nbsp;";
        $info = utente::getUserInformation(utente::getCurrentUserId(), array("nome", "cognome"));
        echo $info['nome'] . "&nbsp;" . $info['cognome'];
        echo "</p>";
        echo "</div>";
    }
    ?>

    <?php
    # Importo la navbar
    echo $ret['navbar'];
    echo "<br>";
    # Importo il file php principale del modulo
    require_once $ret['php'];
    ?>
</body>


</html>