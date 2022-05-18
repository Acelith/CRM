<?php

/**
 * download_fattura.php     File per scaricare la fattura 
 *
 * @author Joël Moix  
 */

# Importo i file necessari
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";
require_once MODULE_PATH . "fatturazione" . DIRECTORY_SEPARATOR . "fattura.php";

use Spipu\Html2Pdf\Html2Pdf;

# Controllo se l'utente è loggato
if (!utente::isLogged()) {
    die();
}

if ($_POST['tipo_fatt'] == "1") {
    stampaFattProgetto();
} else if ($_POST['tipo_fatt'] == "0") {
    stampaFattTicket();
} else if ($_POST['tipo_fatt'] == "2") {
    stampaFattTickets();
} else {
    echo "<h1>Err</h1>";
}
/**
 * Stampa la fattura dei ticket in massa
 */
function stampaFattTickets()
{
    $id_azienda = $_POST['id_azienda'];
    $sqlStmt = "SELECT tk.id, az.nome as nome_azienda, az.indirizzo, az.citta, az.cap, az.id as az_id
                from ticket as tk
                inner join azienda as az on az.id = tk.id_azienda
                where tk.id_azienda=:id and tk.da_fatturare=1 and tk.stato=2";
    $parArr = array(
        ":id" => $id_azienda,
    );

    try {
        # faccio la connessione al databse
        $dbConnect = DB::connect();
        $sth = $dbConnect->prepare($sqlStmt);

        # Eseguo la query;
        $sth->execute($parArr);
    } catch (PDOException $e) {
        echo $e;
    }

    $ids = array();
    
    while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
        array_push($ids, $row->id);

        $nome = $row->nome_azienda;
        $via = $row->indirizzo;
        $citta = $row->citta;
        $cap = $row->cap;
        $id_az = $row->az_id;
    }

    $besrid = "210000";
    $num_fattura = "313947143000901";
    $info_supp = "Erogazione di prestazioni";

    $fattura = new Fattura($besrid, $num_fattura, $info_supp);


    $fattura->setDebitore($nome, $via, $citta, $cap, $id_az);

    $fattura->setRigeFatturaTicket($ids);

    $fattura->calcolaTotale();
    $fattura->creaFattura();
    $fattura->salvaFatturaTicket($ids);
    $fattura->getPdf();
}

/**
 * stampa la fattura del singolo ticket
 */
function stampaFattTicket()
{
    $id_ticket = json_decode($_POST['id_ticket']);
    $sqlStmt = "SELECT tk.*, az.indirizzo, az.citta, az.cap, az.nome as nome_azienda, az.id
    FROM ticket as tk
    inner join azienda as az on az.id = tk.id_azienda
    WHERE tk.id=:id";
    $parArr = array(
        ":id" => $id_ticket,
    );

    try {
        # faccio la connessione al databse
        $dbConnect = DB::connect();
        $sth = $dbConnect->prepare($sqlStmt);

        # Eseguo la query;
        $sth->execute($parArr);
    } catch (PDOException $e) {
        echo $e;
    }

    $row = $sth->fetch(PDO::FETCH_OBJ);

    $besrid = "210000";
    $num_fattura = "313947143000901";
    $info_supp = "Erogazione di prestazioni";

    $fattura = new Fattura($besrid, $num_fattura, $info_supp);

    $nome = $row->nome_azienda;
    $via = $row->indirizzo;
    $citta = $row->citta;
    $cap = $row->cap;
    $id = $row->id_azienda;

    $fattura->setDebitore($nome, $via, $citta, $cap, $id);

    $fattura->setRigeFatturaTicket($id_ticket);


    $fattura->calcolaTotale();
    $fattura->creaFattura();
    $fattura->salvaFatturaTicket($id_ticket);
    $fattura->getPdf();
}

/* Crea la fattura del progetto in PDF e la scarica. */
function stampaFattProgetto()
{
    $id_progetto = $_POST['id_progetto'];
    $sqlStmt = "SELECT prj.*, az.indirizzo, az.citta, az.cap, az.nome as nome_azienda, az.id
    FROM progetto as prj
    inner join azienda as az on az.id = prj.id_azienda
    WHERE prj.id=:id";
    $parArr = array(
        ":id" => $id_progetto,
    );

    try {
        # faccio la connessione al databse
        $dbConnect = DB::connect();
        $sth = $dbConnect->prepare($sqlStmt);

        # Eseguo la query;
        $sth->execute($parArr);
    } catch (PDOException $e) {
        echo $e;
    }

    $row = $sth->fetch(PDO::FETCH_OBJ);

    $besrid = "210000";
    $num_fattura = "313947143000901";
    $info_supp = "Erogazione di prestazioni";

    $fattura = new Fattura($besrid, $num_fattura, $info_supp);

    $nome = $row->nome_azienda;
    $via = $row->indirizzo;
    $citta = $row->citta;
    $cap = $row->cap;
    $id = $row->id;

    $fattura->setDebitore($nome, $via, $citta, $cap, $id);

    if (isset($_POST["ore"])) {
        $fattura->setRigeFatturaProgetto($id_progetto, false);
    } else if (isset($_POST["budget"])) {
        $fattura->setRigeFatturaProgetto($id_progetto, true);
    }

    $fattura->calcolaTotale();
    $fattura->creaFattura();
    $fattura->salvaFatturaProgetto($id_progetto);
    $fattura->getPdf();
}