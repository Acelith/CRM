<?php
/**
 * utente.class.php: Gestione dell'utente
 * 
 * @author Joël Moix  
 */

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";;

session_start();

/**
 * Classe per gestire l'utente corrente
 */
class utente{
    /**
     * Controlla se un utente è loggato
     * 
     * @return bool     ritorna true se è loggato, false se non lo è
     */
    static function isLogged(){
        if(!isset($_SESSION['loggato']) or $_SESSION['loggato'] == false){
            return false;
        } else {
            return true;
        }
    }
}