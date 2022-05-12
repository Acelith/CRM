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

if($_POST['tipo_fatt'] == "1"){
    stampaFattProgetto();
} else if ($_POST['tipo_fatt'] == "0"){
    stampaFattTicket();
} else {
    echo "<h1>Err</h1>";
}

function stampaFattTicket(){
    $id_ticket = json_decode($_POST['id_ticket']);
    $sqlStmt = "SELECT tk.*, az.indirizzo, az.citta, az.cap, az.nome as nome_azienda
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

    $fattura->setDebitore($nome, $via, $citta, $cap);

    $fattura->setRigeFatturaTicket($id_ticket);
    

    $fattura->calcolaTotale();
    $fattura->getPdf();
}

/* Crea la fattura del progetto in PDF e la scarica. */
function stampaFattProgetto()
{
    $id_progetto = $_POST['id_progetto'];
    $sqlStmt = "SELECT prj.*, az.indirizzo, az.citta, az.cap, az.nome as nome_azienda
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

    $fattura->setDebitore($nome, $via, $citta, $cap);
    
    if (isset($_POST["ore"])) {
        $fattura->setRigeFatturaProgetto($id_progetto, false);
    } 
    else if (isset($_POST["budget"])) {
        $fattura->setRigeFatturaProgetto($id_progetto, true);
    }

    $fattura->calcolaTotale();
    $fattura->getPdf();
}
