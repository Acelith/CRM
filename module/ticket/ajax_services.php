<?php

/**
 * ajax_services.php Servizi ajax per ticket.js 
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

            case 'creaTicket':
                $titolo = $_POST['titolo'];
                $data_inizio = $_POST['data_inizio'];
                $ore = $_POST['ore'];
                $fatturare = $_POST['fatturare'];

                # JS restituisce false in stringa invece che in bool
                # riassegnazione per database   
                if ($fatturare == "true") {
                    $fatturare = "1";
                } else if ($fatturare == "false") {
                    $fatturare = "0";
                }

                $id_azienda = $_POST['azienda'];
                $id_operatore = $_POST['operatore'];
                $descrizione = $_POST['descrizione'];
                $soluzione = $_POST['soluzione'];
                $stato = $_POST['stato'];

                $data_inizio = new DateTime($data_inizio);

                $sqlStmt = "INSERT INTO ticket
                    (id_azienda, id_operatore, titolo, orario_inizio, stato, descrizione, soluzione, ore, da_fatturare)
                    VALUES(:id_azienda, :id_operatore, :titolo, :orario_inizio, :stato, :descrizione, :soluzione, :ore, :da_fatturare)";

                $parArr = array(
                    ":titolo" => $titolo,
                    ":orario_inizio" => $data_inizio->format('Y-m-d i:s.u'),
                    ":ore" => $ore,
                    ":da_fatturare" => $fatturare,
                    ":id_azienda" => $id_azienda,
                    ":id_operatore" => $id_operatore,
                    ":descrizione" => $descrizione,
                    ":soluzione" => $soluzione,
                    ":stato" => $stato
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


            case 'getDettagli':
                $id = $_POST['id'];

                $sqlStmt = "SELECT tk.*, az.nome as azienda, CONCAT(ute.nome, ' ', ute.cognome) as operatore, az.id as id_azienda, ute.id as id_operatore
                            FROM ticket as tk
                            INNER JOIN azienda as az on az.id = tk.id_azienda
                            INNER JOIN utente as ute on ute.id = tk.id_operatore
                            WHERE tk.id=:id";

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

                $retArr['titolo'] = $row->titolo;
                $retArr['orario_inizio'] = $row->orario_inizio;
                $retArr['ore'] = $row->ore;
                $retArr['fatturare'] = $row->da_fatturare;
                $retArr['azienda'] = $row->azienda;
                $retArr['operatore'] = $row->operatore;
                $retArr['descrizione'] = $row->descrizione;
                $retArr['soluzione'] = $row->soluzione;
                $retArr['id_azienda'] = $row->id_azienda;
                $retArr['stato'] = $row->stato;
                $retArr['id_operatore'] = $row->id_operatore;
                break;

            case 'modificaTicket':
                $id = $_POST['id'];
                $titolo = $_POST['titolo'];
                $data_inizio = $_POST['data_inizio'];
                $ore = $_POST['ore'];
                $fatturare = $_POST['fatturare'];

                # JS restituisce false in stringa invece che in bool
                # riassegnazione per database   
                if ($fatturare == "true") {
                    $fatturare = "1";
                } else if ($fatturare == "false") {
                    $fatturare = "0";
                }

                $id_azienda = $_POST['azienda'];
                $id_operatore = $_POST['operatore'];
                $descrizione = $_POST['descrizione'];
                $soluzione = $_POST['soluzione'];
                $stato = $_POST['stato'];

                $data_inizio = new DateTime($data_inizio);

                $sqlStmt = "UPDATE ticket
                            SET id_azienda=:id_azienda, id_operatore=:id_operatore, titolo=:titolo, orario_inizio=:orario_inizio, stato=:stato, descrizione=:descrizione, soluzione=:soluzione, ore=:ore, da_fatturare=:fatturare
                            WHERE id=:id";


                $parArr = array(
                    ":id" => $id,
                    ":titolo" => $titolo,
                    ":orario_inizio" => $data_inizio->format('Y-m-d'),
                    ":ore" => $ore,
                    ":fatturare" => $fatturare,
                    ":id_azienda" => $id_azienda,
                    ":id_operatore" => $id_operatore,
                    ":descrizione" => $descrizione,
                    ":soluzione" => $soluzione,
                    ":stato" => $stato
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
