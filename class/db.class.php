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
class DB
{

  /**
   * Esegue la connessine al database
   */
  static function connect()
  {
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

  /**
   * esegue una query parametrica sul database
   * 
   * @param string $p_query  query da eseguire
   * @param array  $p_param  array con i parametri 
   * @param array  &$p_retArr array di ritorno default: null
   */
  static function doQueryParam($p_query, $p_param, &$p_retArr = null)
  {

    try {
      # faccio la connessione al databse
      $dbConnect = DB::connect();
      $sth = $dbConnect->prepare($p_query);

      # Eseguo la query;
      $sth->execute($p_param);

      $p_retArr['ajax_result'] = "ok";
    } catch (PDOException $e) {
      $p_retArr['error'] = "err";
    }
    return $sth;
  }

  /**
   * esegue una query sul database 
   * 
   * @param string $p_query  query da eseguire
   * @param array  &$p_retArr array di ritorno default: null
   */
  static function doQuery($p_query, &$p_retArr = null)
  {
    try {
      # faccio la connessione al databse
      $dbConnect = DB::connect();
      $sth = $dbConnect->prepare($p_query);

      # Eseguo la query;
      $sth->execute();

      $p_retArr['ajax_result'] = "ok";
      return $sth;
    } catch (PDOException $e) {
      $p_retArr['error'] = "err";
      return "Errore " . $e;
    }
     
  }
}
