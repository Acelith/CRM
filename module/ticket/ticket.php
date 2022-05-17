<?php

/**
 * ticket.PHP  script per la gestione dei ticket 
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
    $flt .= "or tk.titolo LIKE '%" . $_GET['src'] . "%' ";

    $src = $_GET['src'];
}

if (isset($_GET['usr'])) {
    $flt .= "and ute.id=" . $_GET["usr"] . " ";
}

if (isset($_GET['stat'])) {
    $flt .= "and sttk.id=" . $_GET["stat"] . " ";
}

$sqlStmt = "SELECT tk.*, az.nome as nome_azienda, CONCAT(ute.nome, ' ', ute.cognome) as nome_operatore, sttk.stato
            FROM ticket as tk
            inner join azienda as az on az.id = tk.id_azienda
            inner join utente as ute on ute.id = tk.id_operatore
            inner join stato_ticket as sttk on sttk.id = tk.stato
            WHERE 1=1 " . $flt . $limit;

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
<div class="container-fluid">
    <div class="input-group mb-3 filter-bar">
        <button class="btn btn-primary" onclick="openModalcreaTicket()">Aggiungi Ticket</button> &nbsp;
        <button class="btn btn-primary" onclick="resetFlt()">Resetta filtro</button>&nbsp;
        <div class="input-group-prepend">
            <span class="input-group-text">Cerca Ticket</span>
        </div>
        <input type="text" class="form-control" value="<?php echo $src ?>" onchange="changeParam('src', this.value )"> &nbsp;
        <?php echo getComboUtenti("setUsr"); ?> &nbsp;
        <?php echo getComboStatoTicket("setStato"); ?> &nbsp;
        <?php echo $nav; ?>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
            <tr class="bg-light">
                <th class="col-1">#</th>
                <th class="col-2">Ticket</th>
                <th class="col-1">Azienda</th>
                <th class="col-1">Operatore</th>
                <th class="col-1">Stato</th>
                <th class="col-1">Ore</th>
                <th class="col-2">Descrizione</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
            ?>
                <tr>
                    <td class="col-1">
                        &nbsp;&nbsp;<span class="bi bi-eye-fill selectable" onclick="showDettagli(<?php echo $row->id; ?>)"></span>
                        &nbsp; &nbsp;<span class="bi bi-pencil-square selectable" onclick="openModalModificaTicket(<?php echo $row->id; ?>);"></span>
                    </td>
                    <td class="col-2"><?php echo $row->titolo; ?></td>
                    <td class="col-1"><?php echo $row->nome_azienda; ?></td>
                    <td class="col-1"><?php echo $row->nome_operatore; ?></td>
                    <td class="col-1"><?php echo $row->stato; ?></td>
                    <td class="col-1"><?php echo $row->ore; ?></td>
                    <td class="col-2"><?php echo $row->descrizione; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>

<?php
require_once "modal_ticket.php";
require_once "modal_utente.php";
require_once "modal_sel_azienda.php";

/**
 *  ritorna la combo con gli stati del ticket
 * 
 * @return string combo
 */
function getStatoTicket()
{
    $sqlStmt = "SELECT * from stato_ticket";

    try {
        # faccio la connessione al databse
        $dbConnect = DB::connect();
        $sth = $dbConnect->prepare($sqlStmt);
        # Eseguo la query;
        $sth->execute();
    } catch (PDOException $e) {
        echo "errore query: " . $e;
    }

    $combo = "<label for='selStato'>Seleziona stato</label>
                <select name='selStato' id='selStato'>";
    while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
        $combo .= "<option value='$row->id'>$row->stato</option>";
    }
    $combo .= "</select>";

    return $combo;
}