<?php

/**
 * progetto.PHP  script per la gestione dei progetti 
 *
 * @author Joël Moix  
 */

# Controllo se l'utente è loggato
if (!utente::isLogged()) {
    die();
}

# Definisco i submenu da caricare 
# A sinistra il nome da far comparire nel menu, a destra la cartella
$subMenu = array(
    "Progetti" => "progetto",
    "Task" => "task",
);


$Nav = New subModule("progetto");
$subNav = $Nav->loadSubmenu($subMenu, "progetto");
?>


<?php
# importo la barra di navigazione
echo $subNav["subNav"];
# Importo il modulo richiesto
require_once $subNav['file'];
?>