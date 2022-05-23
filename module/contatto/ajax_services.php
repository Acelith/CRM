<?php

/**
 * ajax_services.php Servizi ajax per contatto.js 
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
                # Ritorno i dettagli dell'azienda
            case 'getDettagli':
                $id = $_POST['id'];

                $sqlStmt = "SELECT ct.*, az.nome as nome_azienda 
                FROM contatto as ct
                inner join azienda as az on az.id = ct.id_azienda
                WHERE ct.id=:id";

                $parArr = array(
                    ":id" => $id,
                );

                $sth = DB::doQueryParam($sqlStmt, $parArr, $retArr);

                $row = $sth->fetch(PDO::FETCH_OBJ);

                $retArr['id_contatto'] = $row->id;
                $retArr['nome'] = $row->nome;
                $retArr['telefono'] = $row->telefono;
                $retArr['cognome'] = $row->cognome;
                $retArr['azienda'] = $row->nome_azienda;
                $retArr["email"] = $row->email;
                break;

            case 'creaContatto':
                $nome = $_POST['nome'];
                $cognome = $_POST['cognome'];
                $telefono = $_POST['telefono'];
                $id_azienda = $_POST['id_azienda'];
                $email = $_POST['email'];

                $sqlStmt = "INSERT INTO contatto
                    (nome, cognome, telefono, id_azienda, email)
                    VALUES(:nome, :cognome, :telefono, :id_azienda, :email)";

                $parArr = array(
                    ":nome" => $nome,
                    ":cognome" => $cognome,
                    ":telefono" => $telefono,
                    ":id_azienda" => $id_azienda,
                    ":email" => $email
                );

                $sth = DB::doQueryParam($sqlStmt, $parArr, $retArr);


                break;

            case 'modContatto':
                $id = $_POST['id'];
                $nome = $_POST['nome'];
                $telefono = $_POST['telefono'];
                $cognome = $_POST['cognome'];
                $email = $_POST['email'];

                $sqlStmt = "UPDATE contatto
                SET nome=:nome, telefono=:telefono, cognome=:cognome, email=:email
                WHERE id=:id";

                $parArr = array(
                    ":id" => $id,
                    ":nome" => $nome,
                    ":telefono" => $telefono,
                    ":cognome" => $cognome,
                    ":email" => $email
                );

                $sth = DB::doQueryParam($sqlStmt, $parArr, $retArr); 

                break;

            case "delContatto":
                $id = $_POST['id'];

                $sqlStmt = "DELETE FROM contatto
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
