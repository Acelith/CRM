<?php

/**
 * ticket_aziende.PHP  script per la stampa della fatture per ticket ad azienda singola  
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
    $flt .= "or tk.titolo LIKE '%" . $_GET['src'] . "%' ";

    $src = $_GET['src'];
}

if (isset($_GET['usr'])) {
    $flt .= "and tk.id_operatore=" . $_GET["usr"] . " ";
}


$sqlStmt = "SELECT count(tk.id) as ticket_chiusi_da_fatturare, sum(tk.ore) as ore_accumulate_da_fatt, az.*
            from azienda as az 
                inner join ticket as tk on tk.id_azienda = az.id
            where tk.da_fatturare=1 and tk.stato=2 and tk.id_fattura IS NULL
            group by az.id order by ore_accumulate_da_fatt desc";

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
<script type='text/javascript' src="/module/fatturazione/ticket_aziende/ticket_aziende.js"></script>
<div class="container-fluid">
    <div class="input-group mb-3 filter-bar">
        <button class="btn btn-primary" onclick="resetFlt()">Resetta filtro</button>&nbsp;
        <div class="input-group-prepend">
            <span class="input-group-text">Cerca Azienda</span>
        </div>
        <input type="text" class="form-control" value="<?php echo $src ?>" onchange="changeParam('src', this.value )"> &nbsp;
        <?php echo getComboUtenti("setUsr"); ?> &nbsp;
        <?php echo $nav; ?>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
            <tr class="bg-light">
                <th class="col-1">#</th>
                <th class="col-2">Azienda</th>
                <th class="col-1">Ticket da fatturare</th>
                <th class="col-1">Ore accumulate</th>
                <th class="col-1">Totale dovuto senza IVA</th>
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
                    <td class="col-1"><?php echo $row->ticket_chiusi_da_fatturare; ?></td>
                    <td class="col-1"><?php echo $row->ore_accumulate_da_fatt; ?></td>
                    <td class="col-1"><?php echo $row->ore_accumulate_da_fatt * Impostazioni::getSetting("tariffa_oraria") . " " . Impostazioni::getSetting("valuta"); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
<?php
require_once "modal_fattura.php";
