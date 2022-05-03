<?php

/**
 * ajax_services.php: servizi ajax per login.php
 *
 * @author Joël Moix  
 */

# Importo i file necessari 
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";;
$retArr = array();

# Controllo se è stato impostato un comando 
if (isset($_POST['cmd'])) {
    $cmd = $_POST['cmd'];

    switch ($cmd) {
        case 'login':
            # Controllo se la password immessa corrisponde alla mail immessa nel DB 
            # Nel caso uno dei due sia errato restituisco un errore 
            if (checkLogin($_POST['password'], $_POST['email'])) {

                # Preparo la query per salvare il tentativo di login 
                $sqlStmt = "UPDATE utente
                                 SET dt_last_login=:current_date
                                 WHERE id=:id";

                $parArr = array(
                    ":id" =>  $_POST['usr_id'],
                    ":current_date" => date("Y-m-d H:i:s")
                );

                try {
                    # faccio la connessione al databse
                    $dbConnect = DB::connect();
                    $sth = $dbConnect->prepare($sqlStmt);
                    # Eseguo la query;
                    $sth->execute($parArr);

                    $_SESSION['loggato'] = true;
                    $retArr['ajax_result'] = "ok";
                } catch (PDOException $e) {
                    $retArr['ajax_result'] = "err";
                    $retArr['error'] = "err";
                }
            } else {
                $retArr['ajax_result'] = "ok";
                $retArr['error'] = "wrpwd";
            }
            break;
    }
} else {
    $retArr['ajax_result'] = "error";
    $retArr['error'] = "Cmd mancante";
}
$encode = json_encode($retArr);
echo $encode;

/**
 * Controlla se la password immessa per l'utente immesso sia corretta
 * 
 * @param String $p_password        Password inserita da verificare
 * @param String $p_email_utente    Email dell'utente da verificare 
 * 
 */

function checkLogin($password, $email)
{

    $db = new DB();

    $sqlStmt = "SELECT * FROM utente where email=:email";
    $parArr = array(
        ":email" => $email,
    );

    try {
        # faccio la connessione al databse
        $dbConnect = DB::connect();
        $sth = $dbConnect->prepare($sqlStmt);
        # Eseguo la query;
        $sth->execute($parArr);
        $retArr['ajax_result'] = "ok";
    } catch (PDOException $e) {
        $retArr['ajax_result'] = "errore";
        $retArr['error'] = "Query fallita: " . $e;
    }

    $usr = $sth->fetch(PDO::FETCH_OBJ);
    if (password_verify($password, $usr->password)) {
        $_POST['usr_id'] = $usr->id;
        $_SESSION['id_utente'] = $usr->id;
        return true;
    } else {
        return false;
    }
}
