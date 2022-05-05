<?php

/**
 * ajax_services.php Servizi ajax per azienda.js 
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

                $sqlStmt = "SELECT * FROM azienda WHERE id=:id";
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
                $retArr['telefono'] = $row->telefono;
                $retArr['sito'] = $row->sito_web;
                $retArr['indirizzo'] = $row->indirizzo;
                $retArr['citta'] = $row->citta;
                $retArr['cap'] = $row->cap;
                $retArr['provincia'] = $row->provincia;
                $retArr['nazione'] = $row->nazione;
                $retArr['ajax_result'] = "ok";
                break;

            case 'creaAzienda':
                $nome = $_POST['nome'];
                $telefono = $_POST['telefono'];
                $sito = $_POST['sito'];
                $indirizzo = $_POST['indirizzo'];
                $citta = $_POST['citta'];
                $cap = $_POST['cap'];
                $provincia = $_POST['provincia'];
                $nazione = $_POST['nazione'];

                $sqlStmt = "INSERT INTO azienda
                    (nome, telefono, sito_web, indirizzo, citta, cap, provincia, nazione)
                    VALUES(:nome, :telefono, :sito, :indirizzo, :citta, :cap, :provincia, :nazione)";
                    
                $parArr = array(
                    ":nome" => $nome,
                    ":telefono" => $telefono,
                    ":sito" => $sito,
                    ":indirizzo" => $indirizzo,
                    ":citta" => $citta,
                    ":cap" => $cap,
                    ":provincia" => $provincia,
                    ":nazione" => $nazione
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
                $id = $_POST['id'];
                $nome = $_POST['nome'];
                $telefono = $_POST['telefono'];
                $sito = $_POST['sito'];
                $indirizzo = $_POST['indirizzo'];
                $citta = $_POST['citta'];
                $cap = $_POST['cap'];
                $provincia = $_POST['provincia'];
                $nazione = $_POST['nazione'];

                $sqlStmt = "UPDATE azienda
                SET nome=:nome, telefono=:telefono, sito_web=:sito, indirizzo=:indirizzo, citta=:citta, cap=:cap, provincia=:provincia, nazione=:nazione
                WHERE id=:id";

                $parArr = array(
                    ":id" => $id,
                    ":nome" => $nome,
                    ":telefono" => $telefono,
                    ":sito" => $sito,
                    ":indirizzo" => $indirizzo,
                    ":citta" => $citta,
                    ":cap" => $cap,
                    ":provincia" => $provincia,
                    ":nazione" => $nazione
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
