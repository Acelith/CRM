<?php
/**
 * fatturazione.php file per la gestione delle fatture
 *
 * @author Joël Moix  
 */
# Controllo se l'utente è loggato
if(!utente::isLogged()){
    die();
}

 # Definisco i submenu da caricare 
 # A sinistra il nome da far comparire nel menu, a destra la cartella
 $subMenu = array(
     "Progetti" => "progetti",
     "Ticket" => "ticket",
     "Ticket Aziende" => "ticket_aziende",
     "Storico" => "registro"
 );

 $Nav = New subModule("fatturazione");
 $subNav = $Nav->loadSubmenu($subMenu, "ticket_aziende");
 ?>
 
 
 <?php  
 # importo la barra di navigazione
 echo $subNav["subNav"];
 # Importo il modulo richiesto
 require_once $subNav['file'];
 ?>
