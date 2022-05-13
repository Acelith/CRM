<?php

/**
 * ajax_services.php Servizi ajax per progetto.js 
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

                $sqlStmt = "SELECT prj.*, az.nome as azienda
                            FROM progetto as prj
                            inner join azienda as az on az.id = prj.id_azienda
                            WHERE prj.id=:id";
                $parArr = array(
                    ":id" => $id,
                );

                try {
                    # faccio la connessione al databse
                    $dbConnect = DB::connect();
                    $sth = $dbConnect->prepare($sqlStmt);

                    # Eseguo la query;
                    $sth->execute($parArr);

                    $retArr['ajax_result'] = "ok";
                } catch (PDOException $e) {
                    $retArr['error'] = "err";
                }

                $row = $sth->fetch(PDO::FETCH_OBJ);

                $retArr['nome'] = $row->nome;
                $retArr['data_inizio'] = $row->data_inizio;
                $retArr['data_fine_target'] = $row->data_fine_target;
                $retArr['data_fine_effettiva'] = $row->data_fine;
                $retArr['budget'] = $row->budget;
                $retArr['budget_usato'] = $row->budget_usato;
                $retArr['progresso'] = $row->progresso;
                $retArr['azienda'] = $row->azienda;
                $retArr['descrizione'] = $row->descrizione;
                $retArr['ajax_result'] = "ok";
                break;

            case 'creaProgetto':
                $nome = $_POST['nome'];
                $data_inizio = $_POST['data_inizio'];
                $data_fine_target = $_POST['data_fine_target'];
                $data_fine_effettiva = $_POST['data_fine_effettiva'];
                $budget_usato = $_POST['budget_usato'];
                $descrizione = $_POST['descrizione'];
                $budget = $_POST['budget'];
                $progresso = $_POST['progresso'];
                $id_azienda = $_POST['id_azienda'];

                $data_inizio = new DateTime($data_inizio);
                $data_fine_target = new DateTime($data_fine_target);
                $data_fine_effettiva = new DateTime($data_fine_effettiva);

                $sqlStmt = "INSERT INTO progetto
                    (id_azienda, nome, data_inizio, data_fine, data_fine_target, budget, budget_usato, descrizione, progresso)
                    VALUES(:id_azienda, :nome, :data_inizio, :data_fine_effettiva, :data_fine_target,:budget, :budget_usato, :descrizione, :progresso)";

                $parArr = array(
                    ":nome" => $nome,
                    ":data_inizio" => $data_inizio->format('Y-m-d i:s.u'),
                    ":data_fine_target" => $data_fine_target->format('Y-m-d i:s.u'),
                    ":data_fine_effettiva" => $data_fine_effettiva->format('Y-m-d i:s.u'),
                    ":budget_usato" => $budget_usato,
                    ":budget" => $budget,
                    ":descrizione" => $descrizione,
                    ":progresso" => $progresso,
                    ":id_azienda" => $id_azienda
                );

                try {
                    # faccio la connessione al databse
                    $dbConnect = DB::connect();
                    $sth = $dbConnect->prepare($sqlStmt);

                    # Eseguo la query;
                    $sth->execute($parArr);

                    $retArr['ajax_result'] = "ok";
                } catch (PDOException $e) {
                    $retArr['error'] = "err";
                }

                break;

            case 'modAzienda':
                $nome = $_POST['nome'];
                $data_inizio = $_POST['data_inizio'];
                $data_fine_target = $_POST['data_fine_target'];
                $data_fine_effettiva = $_POST['data_fine_effettiva'];
                $budget_usato = $_POST['budget_usato'];
                $descrizione = $_POST['descrizione'];
                $budget = $_POST['budget'];
                $progresso = $_POST['progresso'];
                $id_progetto = $_POST['id_progetto'];


                $sqlStmt = "UPDATE progetto
                SET nome=:nome, data_inizio=:data_inizio, data_fine=:data_fine, data_fine_target=:data_fine_target, budget=:budget, budget_usato=:budget_usato, descrizione=:descrizione, progresso=:progresso 
                WHERE id=:id_progetto";

                $parArr = array(
                    ":nome" => $nome,
                    ":data_inizio" => $data_inizio,
                    ":data_fine_target" => $data_fine_target,
                    ":data_fine_effettiva" => $data_fine_effettiva,
                    ":budget_usato" => $budget_usato,
                    ":budget" => $budget,
                    ":descrizione" => $descrizione,
                    ":progresso" => $progresso,
                    ":id_progetto" => $id_progetto
                );

                try {
                    # faccio la connessione al databse
                    $dbConnect = DB::connect();
                    $sth = $dbConnect->prepare($sqlStmt);

                    # Eseguo la query;
                    $sth->execute($parArr);

                    $retArr['ajax_result'] = "ok";
                } catch (PDOException $e) {
                    $retArr['error'] = "err";
                }
                break;

            case "assUtente":
                $idUte = $_POST['id_ute'];
                $idAz = $_POST['id_az'];

                $sqlStmt = "UPDATE azienda
                    SET id_utente=:id_utente
                    WHERE id=:id_azienda";

                $parArr = array(
                    ":id_utente" => $idUte,
                    ":id_azienda" => $idAz
                );

                try {
                    # faccio la connessione al databse
                    $dbConnect = DB::connect();
                    $sth = $dbConnect->prepare($sqlStmt);

                    # Eseguo la query;
                    $sth->execute($parArr);

                    $retArr['ajax_result'] = "ok";
                } catch (PDOException $e) {
                    $retArr['error'] = "err";
                }

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
