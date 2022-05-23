<?php

/**
 * ajax_services.php Servizi ajax per admin.js 
 *
 * @author Joël Moix  
 */

# Importo i file necessari
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";

# Controllo se l'utente è loggato
if (!utente::isLogged()) {
    die();
}

$retArr = array();
# Controllo se è stato passato un comando
if (isset($_POST['cmd'])) {

    $cmd = $_POST['cmd'];

    try {
        switch ($cmd) {
            case "getUtente":
                $id = $_POST['id'];
                $sqlStmt = "SELECT * FROM utente where id=:id";

                $parArr = array(
                    ":id" => $id
                );

                $sth = DB::doQueryParam($sqlStmt, $parArr, $retArr); 

                $row = $sth->fetch(PDO::FETCH_OBJ);
                $retArr["nome"] = $row->nome;
                $retArr["cognome"] = $row->cognome;
                $retArr["email"] = $row->email;
                $retArr["dt_creazione"] = $row->dt_creazione;
                $retArr["dt_last_login"] = $row->dt_last_login;
                $retArr["admin"] = $row->admin;
                break;

            case "modUtente":
                $id = $_POST['id'];
                $nome = $_POST['nome'];
                $cognome = $_POST['cognome'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confPassword = $_POST['confPassword'];
                $admin = $_POST["admin"];

                # Controlla se la password è da cambiare 
                if (!empty($password) && !empty($confPassword)) {
                    if ($password == $confPassword) {
                        $ret = utente::changePassword($id, $password);
                        if ($ret != "ok") {
                            $retArr['ajax_result'] == "error";
                            $retArr['error'] = "Impossibile cambiare la password";
                            break;
                        }
                    } else {
                        $retArr['ajax_result'] == "error";
                        $retArr['error'] = "Le password non sono uguali";
                        break;
                    }
                }

                if ($admin == "true") {
                    $admin = "1";
                } else {
                    $admin = "0";
                }

                $sqlStmt = "UPDATE utente
                SET email=:email, nome=:nome, cognome=:cognome, admin=:admin
                WHERE id=:id";

                $parArr = array(
                    ":id" => $id,
                    ":cognome" => $cognome,
                    ":nome" => $nome,
                    ":email" => $email,
                    ":admin" => $admin
                );

                $sth = DB::doQueryParam($sqlStmt, $parArr, $retArr); 

                break;

            case "creUtente":
                $nome = $_POST['nome'];
                $cognome = $_POST['cognome'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confPassword = $_POST['confPassword'];
                $admin = $_POST["admin"];

                # Controlla se la password è da cambiare 
                if (!empty($password) && !empty($confPassword)) {
                    if ($password != $confPassword) {
                        $retArr['ajax_result'] == "error";
                        $retArr['error'] = "Le password non sono uguali";
                        break;
                    }
                }

                if ($admin == "true") {
                    $admin = "1";
                } else {
                    $admin = "0";
                }

                $sqlStmt = "INSERT INTO utente
                    (email, password, nome, cognome, admin)
                    VALUES(:email,:password, :nome, :cognome, :admin)";

                $parArr = array(
                    ":cognome" => $cognome,
                    ":nome" => $nome,
                    ":email" => $email,
                    ":admin" => $admin,
                    ":password" => password_hash($password, PASSWORD_BCRYPT),
                );

                $sth = DB::doQueryParam($sqlStmt, $parArr, $retArr); 

                break;

            case "delUtente":
                $id = $_POST['id'];

                $sqlStmt = "DELETE FROM utente
                                WHERE id=:id";

                $parArr = array(
                    ":id" => $id
                );

                $sth = DB::doQueryParam($sqlStmt, $parArr, $retArr); 
                
                break;
        }
    } catch (Exception $e) {
        $retArr['ajax_result'] = "error";
        $retArr['error'] = "Ajax error: " . $e;
    }
} else {
    $retArr['ajax_result'] = "error";
    $retArr['error'] = "Cmd mancante";
}

echo json_encode($retArr);
