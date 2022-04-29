<?php
/**
 * ajax_services.php Servizi ajax per impostazioni
 *
 * @author Joël Moix  
 */

 # Importo i file necessari
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";

# Controllo se l'utente è loggato
if(!utente::isLogged()){
    die();
}

$retArr = array();
# Controllo se è stato passato un comando
if(isset($_POST['cmd'])){
   
    $cmd = $_POST['cmd'];
  
        switch($cmd){
          
            case 'changeSetting':
                $val = $_POST['val'];
                $nome = $_POST['name'];

                Impostazioni::setSetting($nome, $val);

                $retArr['ajax_result'] = "ok";
               
                break;
        }
} else {
    $retArr['ajax_result'] = "error";
    $retArr['error'] = "Cmd mancante";
}

echo json_encode($retArr);
