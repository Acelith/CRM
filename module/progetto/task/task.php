<?php

/**
 * task.PHP  script per la gestione dei task dei progetti  
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
$src = "";
if (isset($_GET['src'])) {
    $flt .= "and az.nome LIKE '%" . $_GET['src'] . "%' ";
    $flt .= "or prj.nome LIKE '%" . $_GET['src'] . "%' ";
    $flt .= "or tsk.nome_attivita LIKE '%" . $_GET['src'] . "%' ";

    $src = $_GET['src'];
}

if (isset($_GET['usr'])) {
    $flt .= "and az.id_utente=" . $_GET["usr"] . " ";
}


$sqlStmt = "SELECT tsk.*, prj.nome as nome_progetto
from task_progetto as tsk
inner join progetto as prj on prj.id = tsk.id_progetto
inner join azienda as az on az.id = prj.id_azienda
where 1=1  " . $flt . $limit;


$sth = DB::doQuery($sqlStmt); 

?>
<script type='text/javascript' src="/module/progetto/task/task.js"></script>
<div class="container-fluid">
    <div class="input-group mb-3 filter-bar">
        <button class="btn btn-primary" onclick="openModalCreaTask()">Aggiungi Task</button> &nbsp;
        <button class="btn btn-primary" onclick="resetFlt()">Resetta filtro</button>&nbsp;
        <div class="input-group-prepend">
            <span class="input-group-text">Cerca Task</span>
        </div>
        <input type="text" class="form-control" value="<?php echo $src ?>" onchange="changeParam('src', this.value )"> &nbsp;
        <?php echo getComboUtenti("setUsr"); ?> &nbsp;
        <?php echo $nav; ?>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
            <tr class="bg-light">
                <th class="col-1">#</th>
                <th class="col-1">Task</th>
                <th class="col-1">Progetto</th>
                <th class="col-1">Progresso</th>
                <th class="col-1">Data di inizio</th>
                <th class="col-2">Descrizione</th>
                <th class="col-1">Ore lavorate</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
            ?>
                <tr>
                    <td class="col-1">
                        &nbsp; &nbsp;<span class="bi bi-pencil-square selectable" onclick="openModalModificaTask(<?php echo $row->id; ?>);"></span>
                    </td>

                    <td class="col-1"><?php echo $row->nome_attivita; ?></td>
                    <td class="col-1"><?php echo $row->nome_progetto; ?></td>
                    <td class="col-1"><?php echo $row->progresso; ?>%</td>
                    <td class="col-1"><?php echo $row->data_inizio; ?></td>
                    <td class="col-2"><?php echo $row->descrizione; ?></td>
                    <td class="col-1"><?php echo $row->ore_lavorate; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>

<?php
require_once "modal_task.php";
require_once "modal_sel_progetto.php";

function getProgettoSelect()
{

    $sqlStmt = 'SELECT * FROM progetto';

    $sth = DB::doQuery($sqlStmt); 

    $progetti = '';
    while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
        $progetti .= "<div class='form-check'>";
        $progetti .= " <input class='form-check-input' type='radio' data-nome='$row->nome' name='listaProgetto' id='$row->id'>";
        $progetti .= "<label class='form-check-label' for='$row->id'>
                         " . $row->nome . "
                        </label>";
        $progetti .= "</div>";
    }

    $radio = "
    <div id='lista_progetto'>
       $progetti
    </div>";
    return $radio;
}
