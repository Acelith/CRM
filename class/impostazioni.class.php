<?php

/**
 * impostazioni.class.php: gestione delle impostazioni
 *
 * @author Joël Moix  
 */

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";;

/**
 * Classe impostazioni
 * Gestione delle impostazioni dell'applicazione
 * 
 */
class Impostazioni
{

    /**
     * getSettings():   Ritorna un array con tutte le impostazioni 
     * 
     * @return array    ritorna un Array associativo con le impostazioni 
     */
    static function getSettings()
    {
        $db = new DB();

        $sqlStmt = "SELECT * FROM impostazioni";

        $sth = $db->doQuery($sqlStmt);

        $retArr = $sth->fetch(PDO::FETCH_ASSOC);
        return $retArr;
    }

    /**
     * getSetting():                   Ritorna una stringa con l'impostazione richiesta
     * 
     * @param string    $p_setting     nome dell'impostazione
     * 
     * @return string   $setting       Stringa contenente l'impostazioni
     */
    static function getSetting($p_setting)
    {

        $resArr = self::getSettings();

        if (array_key_exists($p_setting, $resArr)) {
            $setting = $resArr[$p_setting];
        } else {
            die();
        }
        return $setting;
    }

    /**
     * Ritorna il modulo di default
     * 
     * @return int  ID del modulo di default
     */
    static function getDefaultModule()
    {
        $defaultModule = self::getSetting('default_modulo');
        return $defaultModule;
    }

    /**
     * Imposta un nuovo valore per l'impostazione data
     * 
     * @param string p_nome     nome dell'impostazione da cambiare
     * @param string p_val      valore da aggiornare
     */
    static function setSetting($p_nome, $p_val)
    {
        $db = new DB();

        $parArr = array(
            ":valore" => $p_val
        );

        $sqlStmt = "UPDATE impostazioni "
            . "SET $p_nome=:valore";

        $sth = $db->doQueryParam($sqlStmt, $parArr);
    }
}
