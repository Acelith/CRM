<?php

# Importo i file necessari
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";

# Controllo se l'utente è loggato
if (!utente::isLogged()) {
    die();
}
