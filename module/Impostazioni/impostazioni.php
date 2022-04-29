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
?>

<div class="container-fluid">
    <div class='row'>
        <span id="fields"></span>
        <div class='form-group col-lg-3 mb-3'>
            <span class="badge bg-primary p-1">default_modulo</span>
            <input class='form-control' type="text" id="default_modulo" value="<?php echo Impostazioni::getSetting('default_modulo'); ?>" onchange="changeSetting(this)">
        </div>
    </div>
</div>