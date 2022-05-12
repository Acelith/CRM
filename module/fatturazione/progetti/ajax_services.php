<?php

/**
 * ajax_services.php Servizi ajax per azienda.js 
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

$retArr = array();
# Controllo se è stato passato un comando
if (isset($_POST['cmd'])) {

    $cmd = $_POST['cmd'];

    try {
        switch ($cmd) {
                # Stampo la fattura
            case 'stampaFattura':
                $id_azienda = $_POST['id'];
                $sqlStmt = "SELECT prj.*, az.indirizzo, az.citta, az.cap, az.nome as nome_azienda
                FROM progetto as prj
                inner join azienda as az on az.id = prj.id_azienda
                 WHERE prj.id=:id";
                $parArr = array(
                    ":id" => $id_azienda,
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

                $totale = $row->budget_usato;
                $besrid = "210000";
                $num_fattura = "313947143000901";
                $info_supp = "Erogazione di prestazioni";

                $fattura = new Fattura($besrid, $num_fattura, $info_supp);
                
                $nome = $row->nome_azienda;
                $via = $row->indirizzo;
                $citta = $row->citta;
                $cap = $row->cap;
                
                $fattura->setDebitore($nome, $via, $citta, $cap);
                if($_POST["tipo_fatt"] == "ore"){
                    $fattura->setRigeFattura($id_azienda, false);

                } else if($_POST["tipo_fatt"] = "budget") {
                    $fattura->setRigeFattura($id_azienda, true);
                }
                
                $fattura->calcolaTotale();
               
                $retArr["corpo"] =  $fattura->getCorpo();
                $retArr["testa"] = $fattura->getTesta();

                $fattura->getPdf();

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