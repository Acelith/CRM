<?php
/**
 * contatto.php file per la gestione dei contatti
 *
 * @author Joël Moix  
 */

 # Controllo se l'utente è loggato
if(!utente::isLogged()){
    die();
}

