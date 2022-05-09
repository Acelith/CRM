<?php 
/**
 * progetto.PHP  script per la gestione dei progetti 
 *
 * @author Joël Moix  
 */

  # Importo i file necessari
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";

# Controllo se l'utente è loggato
if(!utente::isLogged()){
    die();
}

 # Definisco i submenu da caricare 
 $subMenu = array(
     "Progetti" => "progetto",
     "Task" => "task"
 );

$navbarMenu = "";
$to_import = array();
foreach ($subMenu as $nome => $cartella){
    $to_check = MODULE_PATH . "progetto" . DIRECTORY_SEPARATOR . $cartella . DIRECTORY_SEPARATOR . $cartella . ".php";
    if(file_exists($to_check)){
        $navbarMenu .= "<a class='nav-item nav-link selectable' onclick='subMenu($cartella)'>$nome</a>";
        $to_import[$cartella] = $cartella;
    }
}

$modulo_to_load = "";
if(isset($_GET['submod'])){
    if(key_exists($_GET['submod'], $to_import)){
        $modulo_to_load = $_GET['submod'];
    } else {
        $modulo_to_load = "progetto";
    }
}


?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <?php echo $navbarMenu?>
    </div>
  </div>
</nav>

<?php 

foreach ($to_import as $file){
    require_once $file;
}
?>