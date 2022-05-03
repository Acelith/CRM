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
if(isset($_POST['cmd'])){
   
    $cmd = $_POST['cmd'];
   
    try{   
        switch($cmd){
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

                
                $retArr['ajax_result'] = "ok";
                break;
        }
    } catch(Exception $e){
        $retArr['ajax_result'] = "error";
        $retArr['error'] = "Ajax error: " . $e;
    }
} else {
    $retArr['ajax_result'] = "error";
    $retArr['error'] = "Cmd mancante";
}

echo json_encode($retArr);
?>