<?php

/**
 * impostazioni.php file per la gestione delle impostazioni
 *
 * @author Joël Moix  
 */

# Controllo se l'utente è loggato
if (!utente::isLogged()) {
    die();
}

$settings = impostazioni::getSettings();

?>

<div class="container-fluid">
    <div class='row'>
        <span id="fields"></span>
        <?php
        foreach ($settings as $key => $value) {
            if($key == "id"){
                continue;
            }

            echo "<div class='form-group col-lg-3 mb-3'>";
                echo "<span class='badge bg-primary p-1'>$key</span>";
                echo "<input class='form-control' type='text' id='$key' value='$value' onchange='changeSetting(this)'>";
            echo "</div>";
        }
        ?>
    </div>
</div>