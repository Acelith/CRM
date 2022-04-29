<?php

/**
 * db.calass.php: gestione del database
 *
 * @author Joël Moix  
 */

# Includo file necessari
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'dependencies.php';

/**
 * Classe per gestire le operazioni sul database
 */
class DB{

  /**
   * Esegue la connessine al database
   */
  static function connect(){
    # Prendo i parametri dal file .ini
    $params = Parametri::getParamsDB();
    $db_host = $params['db_host'];
    $db_name = $params['db_name'];
    $db_usr = $params['db_usr'];
    $db_pwd = $params['db_pwd'];

    # Faccio la connessione
    try {
      $dbConn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_usr, $db_pwd);

      return $dbConn;
    } catch (PDOException $e) {
      echo 'Connessione al DB fallita: ' . $e->getMessage();
      die();
    }
  }
}
