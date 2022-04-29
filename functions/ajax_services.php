<?php
/**
 * ajax_services.php Servizi ajax per function.js 
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
            # Distruggo la sessione per eseguire il logout
            case 'logout':
                session_unset();
                session_destroy();
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