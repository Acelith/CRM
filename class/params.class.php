<?php

/**
 * params.class.php: lettura del file con i parametri
 *
 * @author Joël Moix  
 */

# Includo i file necessari
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";

/**
 * Classe per la gestione dei parametri 
 */
class Parametri
{

    /**
     * Legge i parametri dal file db_conf.ini
     * 
     * @return array    array associativo con i parametri di connessione al DB 
     */
    static function getParamsDB()
    {
        $params = parse_ini_file(ROOT_PATH . "db_conf.ini");
        return $params;
    }
}
