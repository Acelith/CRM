<?php

/**
 * registro.PHP  Registro delle fattzre create
 *
 * @author Joël Moix  
 */

# Importo i file necessari
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";

# Controllo se l'utente è loggato
if (!utente::isLogged()) {
    die();
}


$limit = " ";
if (isset($_GET['pag'])) {
    if ($_GET['pag'] == "") {
        $pag = 1;
    } else {
        $pag = $_GET['pag'];
    }
    $end = 50 * $pag;
    $start = $end - 50;
    $limit = "LIMIT $start, 50";
} else {
    $limit = "LIMIT 0, 50";
}

$nav = "
<button class='btn btn-primary' onclick='precedentePagina()'><</button>
<div style='width:5%'>
    <input class='form-control'  onchange='changePage(this)' id='numero_pagina' type='text'></input>
    </div>
<button class='btn btn-primary' onclick='prossimaPagina()'>></button>

";


$flt = " ";
$src = " ";
if (isset($_GET['src'])) {
    $flt .= "and az.nome LIKE '%" . $_GET['src'] . "%' ";
    $src = $_GET['src'];
}

$sqlStmt = " SELECT ft.*, az.nome as nome_azienda
             from fattura as ft
             inner join azienda as az on az.id = ft.id_azienda
             where 1=1 " . $flt . $limit;

try {
    # faccio la connessione al databse
    $dbConnect = DB::connect();
    $sth = $dbConnect->prepare($sqlStmt);
    # Eseguo la query;
    $sth->execute();
} catch (PDOException $e) {
    echo "errore query: " . $e;
}

?>
<script type='text/javascript' src="/module/fatturazione/registro/registro.js"></script>
<div class="container-fluid">
    <div class="input-group mb-3 filter-bar">
        <button class="btn btn-primary" onclick="resetFlt()">Resetta filtro</button>&nbsp;
        <div class="input-group-prepend">
            <span class="input-group-text">Cerca azienda</span>
        </div>
        <input type="text" class="form-control" value="<?php echo $src ?>" onchange="changeParam('src', this.value )">
        &nbsp;
        <?php echo $nav; ?>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
            <tr class="bg-light">
                <th class="col-1">#</th>
                <th class="col-1">N. fattura</th>
                <th class="col-1">Azienda</th>
                <th class="col-1">Data emissione</th>
                <th class="col-1">Identificativo</th>
                <th class="col-1">Importo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
                $data_emissione = new DateTime($row->dt_ins_rec);
            ?>
                <tr>
                    <td class="col-1">
                        <span class="bi bi-printer selectable" onclick="modalFattura(<?php echo $row->id; ?>);"></span>
                    </td>
                    <td class="col-1"><?php echo $row->id; ?></td>
                    <td class="col-1"><?php echo $row->nome_azienda; ?></td>
                    <td class="col-1"><?php echo $data_emissione->format('d-m-Y') ?></td>
                    <td class="col-1"><?php echo $row->identificativo_interno; ?></td>
                    <td class="col-1"><?php echo $row->importo_totale . " " . Impostazioni::getSetting("valuta"); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
<?php
require_once "modal_fattura.php";
