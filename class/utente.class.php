<?php

/**
 * utente.class.php: Gestione dell'utente
 * 
 * @author Joël Moix  
 */

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";;

session_start();

/**
 * Classe per gestire l'utente 
 */
class utente
{
    /**
     * Controlla se un utente è loggato
     * 
     * @return bool     ritorna true se è loggato, false se non lo è
     */
    static function isLogged()
    {
        if (!isset($_SESSION['loggato']) or $_SESSION['loggato'] == false or !isset($_SESSION['id_utente'])) {
            return false;
        } else {
            return true;
        }
    }

    /* Ritorna l'id dell'utente corrente. */
    static function getCurrentUserId()
    {
        return $_SESSION['id_utente'];
    }

    /* Controlla se l'utente è un'amministratore. */
    static function isAdmin()
    {
        $id = utente::getCurrentUserId();

        $sqlStmt = "SELECT admin from utente where id=:id";

        $parArr = array(
            ":id" => $id
        );

        $sth = DB::doQueryParam($sqlStmt, $parArr); 

        $row = $sth->fetch(PDO::FETCH_OBJ);

        if ($row->admin) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Cambia la password di un utente  
     * @param  int   $p_id_utente   id dell'utente da cambiare la passoword
     * @param  int   $password      password da cambiare 
     * @return string     
     */
    static function changePassword($p_id_utente, $password)
    {
        $sqlStmt = "UPDATE utente
                    SET password=:password
                    WHERE id=:id";

        $parArr = array(
            ":id" => $p_id_utente,
            ":password" => password_hash($password, PASSWORD_BCRYPT),
        );

        $sth = DB::doQueryParam($sqlStmt, $parArr); 
    }

    /**
     * Ritorna delle informazioni dell'utente
     * @param  int            $p_id_utente   id dell'utente da cambiare la passoword
     * @param  string/array   $p_info        informazione/i da estrarre  
     * @return array     
     */
    static function getUserInformation($p_id_utente, $p_info)
    {
        if (is_array($p_info)) {
            $infos = " ";
            foreach ($p_info as $key => $val) {
                if ($key === array_key_last($p_info)) {
                    $infos .= $val . " ";
                } else {
                    $infos .= $val . ", ";
                }
            }

            $sqlStmt = "SELECT $infos
                    FROM utente
                    WHERE id=:id";

            $parArr = array(
                ":id" => $p_id_utente,
            );

            $sth = DB::doQueryParam($sqlStmt, $parArr); 
            
            return $sth->fetch(PDO::FETCH_ASSOC);
        } else {
            $sqlStmt = "SELECT $p_info
            from utente
            WHERE id=:id";

            $parArr = array(
                ":id" => $p_id_utente
            );

            $sth = DB::doQueryParam($sqlStmt, $parArr); 

            return $sth->fetch(PDO::FETCH_ASSOC);
        }
    }
}
