<?php
/**
 * fatturazione.php file per la gestione delle fatture
 *
 * @author Joël Moix  
 */
# Controllo se l'utente è loggato
if(!utente::isLogged()){
    die();
}

 # Definisco i submenu da caricare 
 # A sinistra il nome da far comparire nel menu, a destra la cartella
 $subMenu = array(
     "Progetti" => "progetti",
     "Ticket" => "ticket",
     "Ticket Aziende" => "ticket_aziende"
 );

$navbarMenu = "";
$to_import = array();
# Costruisco il menu della navbar
foreach ($subMenu as $nome => $cartella){
    $to_check = MODULE_PATH . "fatturazione" . DIRECTORY_SEPARATOR . $cartella . DIRECTORY_SEPARATOR . $cartella . ".php";
    if(file_exists($to_check)){
        $navbarMenu .= "<a class='nav-item nav-link selectable el-navbar' onclick='subMenu(\"$cartella\")'>$nome</a>";
        $to_import[$cartella] = $cartella;
    }
}

$modulo_to_load = "";
# Sottomodulo da caricare in caso non sia impostato un modulo specifico da caricare
$default = MODULE_PATH . "fatturazione" . DIRECTORY_SEPARATOR . "progetti" . DIRECTORY_SEPARATOR . "progetti" . ".php";

if(isset($_GET['submod'])){
    if(key_exists($_GET['submod'], $to_import)){
        $modulo_to_load = MODULE_PATH . "fatturazione" . DIRECTORY_SEPARATOR . $_GET['submod'] . DIRECTORY_SEPARATOR . $_GET['submod'] . ".php";
    } else {
        $modulo_to_load = $default;
    }
} else {
    $modulo_to_load = $default;
}


?>
<nav class="navbar  navbar-expand-lg navbar-light sub-navbar">
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav ">
      <?php echo $navbarMenu?>
    </div>
  </div>
</nav>
<br>
<?php 

# Importo il modulo richiesto
require_once $modulo_to_load;
?>

