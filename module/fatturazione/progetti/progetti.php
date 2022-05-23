<?php

/**
 * progetti.PHP  script per la gestione delle fatture dei progetti 
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
    $flt .= "or prj.nome LIKE '%" . $_GET['src'] . "%' ";

    $src = $_GET['src'];
}

if (isset($_GET['usr'])) {
    $flt .= "and az.id_utente=" . $_GET["usr"] . " ";
}


$sqlStmt = "SELECT prj.*, az.nome as nome_azienda, SUM(tsk      .ore_lavorate) as ore_lavorate "
    . "from progetto as prj "
    .   "inner join azienda as az on az.id = prj.id_azienda "
    .   "left join task_progetto as tsk on tsk.id_progetto = prj.id "
    .   "WHERE 1=1 " . $flt . " group by prj.id " . $limit;

    $sth = DB::doQuery($sqlStmt); 

?>
<script type='text/javascript' src="/module/fatturazione/progetti/progetti.js"></script>
<div class="container-fluid">
    <div class="input-group mb-3 filter-bar">
        <button class="btn btn-primary" onclick="resetFlt()">Resetta filtro</button>&nbsp;
        <div class="input-group-prepend">
            <span class="input-group-text">Cerca Progetto</span>
        </div>
        <input type="text" class="form-control" value="<?php echo $src ?>" onchange="changeParam('src', this.value )"> &nbsp;
        <?php echo getComboUtenti("setUsr"); ?> &nbsp;
        <?php echo $nav; ?>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
            <tr class="bg-light">
                <th class="col-1">#</th>
                <th class="col-1">Progetto</th>
                <th class="col-1">Azienda</th>
                <th class="col-2">Descrizione</th>
                <th class="col-1">Budget usato</th>
                <th class="col-1">Ore dedicate totali</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
            ?>
                <tr>
                    <td class="col-1">
                        <span class="bi bi-printer selectable" onclick="modalFattura(<?php echo $row->id; ?>);"></span>
                    </td>
                    <td class="col-1"><?php echo $row->nome; ?></td>
                    <td class="col-1"><?php echo $row->nome_azienda; ?></td>
                    <td class="col-2"><?php echo $row->descrizione; ?></td>
                    <td class="col-1"><?php echo $row->budget_usato;
                                        echo " " . impostazioni::getSetting("valuta") ?></td>
                    <td class="col-1"><?php echo $row->ore_lavorate; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
<?php
require_once "modal_fattura.php";
