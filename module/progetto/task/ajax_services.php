<?php

/**
 * ajax_services.php Servizi ajax per task.js 
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
            case 'getTask':
                $id_task = $_POST['id_task'];

                $sqlStmt = "SELECT tk.*, prj.nome as nome_progetto
                            FROM task_progetto as tk
                            inner join progetto as prj on prj.id = tk.id_progetto
                            WHERE tk.id=:id";
                $parArr = array(
                    ":id" => $id_task,
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

                $data_inizio = new DateTime($row->data_inizio);
                $data_fine = new DateTime($row->data_fine);

                $retArr['nome'] = $row->nome_attivita;
                $retArr['progresso'] = $row->progresso;
                $retArr['ore'] = $row->ore_lavorate;
                $retArr['data_inizio'] = $data_inizio->format('m/d/Y');
                $retArr['data_fine'] = $data_fine->format('m/d/Y');
                $retArr['descrizione'] = $row->descrizione;
                $retArr['progetto'] = $row->nome_progetto;
                $retArr['id_task'] = $row->id;
                break;

            case 'creaTask':
                $nome = $_POST['nome'];
                $data_inizio = $_POST['data_inizio'];
                $data_fine = $_POST['data_fine'];
                $ore = $_POST['ore'];
                $progresso = $_POST['progresso'];
                $id_progetto = $_POST['id_progetto'];
                $descrizione = $_POST['descrizione'];
                
                if($data_inizio != ""){
                    $data_inizio = new DateTime($data_inizio);    
                    $data_inizio = $data_inizio->format('Y-m-d i:s.u');
                } else {
                    $data_fine = null;
                }
                
                if($data_fine != ""){
                    $data_fine = new DateTime($data_fine);
                    $data_fine = $data_fine->format('Y-m-d i:s.u');                    
                } else {
                    $data_fine = null;
                }
                
                
                

                $sqlStmt = "INSERT INTO task_progetto
                    (nome_attivita, progresso, ore_lavorate, data_inizio, data_fine, descrizione, id_progetto)
                    VALUES(:nome, :progresso, :ore, :data_inizio, :data_fine, :descrizione, :id_progetto)";

                $parArr = array(
                    ":nome" => $nome,
                    ":data_inizio" => $data_inizio,
                    ":data_fine" => $data_fine,
                    ":progresso" => $progresso,
                    ":ore" => $ore,
                    ":descrizione" => $descrizione,
                    ":id_progetto" => $id_progetto,
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

            case 'modTask':
                $id_task = $_POST['id_task'];
                $nome = $_POST['nome'];
                $data_inizio = $_POST['data_inizio'];
                $data_fine = $_POST['data_fine'];
                $ore = $_POST['ore'];
                $progresso = $_POST['progresso'];
                $descrizione = $_POST['descrizione'];

                $data_inizio = new DateTime($data_inizio);
                $data_fine = new DateTime($data_fine);


                $sqlStmt = "UPDATE task_progetto
                SET nome_attivita=:nome, progresso=:progresso, ore_lavorate=:ore, data_inizio=:data_inizio, data_fine=:data_fine,descrizione=:descrizione
                WHERE id=:id";

                $parArr = array(
                    ":nome" => $nome,
                    ":data_inizio" => $data_inizio->format('Y-m-d i:s.u'),
                    ":data_fine" => $data_fine->format('Y-m-d i:s.u'),
                    ":progresso" => $progresso,
                    ":ore" => $ore,
                    ":descrizione" => $descrizione,
                    ":id" => $id_task,
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
            case "delTask":
                $id_task = $_POST['id_task'];

                $sqlStmt = "DELETE FROM task_progetto
                            WHERE id=:id";

                $parArr = array(
                    ":id" => $id_task,
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
