<?php
/**
 * dependencies.php: File contenente tutti i file necessari da essere importati 
 *
 * @author Joël Moix  
 */

 /****************************************************************
  * dependencies.php: File contenente tutte le costanti per i path *
  ****************************************************************/
 require_once "config.inc.php";

  /***********************************************************
  * utente.class.php: Script PHP per la gestione dell'utente *
  ************************************************************/
  require_once CLASS_PATH . "utente.class.php";

 /**********************************************************************
  * params.class.php: Script PHP per la lettura dei file con parametri *
  **********************************************************************/
 require_once CLASS_PATH . "params.class.php";

 /********************************************************************
  * db.class.php: Script PHP per la gestione del database read/write *
  ********************************************************************/
 require_once CLASS_PATH . "db.class.php";

 /*******************************************************
  * module.class.php: Script PHP per il load dei moduli *
  *******************************************************/
 require_once CLASS_PATH . "module.class.php";

 /**************************************************************************************
  * impostazioni.class.php: Script PHP per la lettura e la modifica delle impostazioni *
  **************************************************************************************/
 require_once CLASS_PATH . "impostazioni.class.php";