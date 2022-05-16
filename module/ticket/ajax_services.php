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
                if($fatturare == "true"){
                    $fatturare = true;
                } else if($fattuare == "false"){
                    $fatturare = false;
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
