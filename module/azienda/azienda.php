<?php

/**
 * azienda.php file per la gestione delle aziende
 *
 * @author Joël Moix  
 */

# Controllo se l'utente è loggato
if (!utente::isLogged()) {
    die();
}

$flt = " ";
$src = "";
if (isset($_GET['src'])) {
    $flt .= "and az.nome LIKE '%" . $_GET['src'] . "%' ";

    $src = $_GET['src'];
}

if (isset($_GET['usr'])) {
    $flt .= "and id_utente=" . $_GET["usr"] . " ";
}


$sqlStmt = "SELECT az.*, CONCAT(ute.nome, ' ',ute.cognome) as utente "
. "FROM Azienda as az "
. "left join utente as ute on ute.id=az.id_utente "
. "where 1=1" . $flt . " order by nome asc";


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
    <div style="width: 40%;" class="input-group mb-3 ">
        <button class="btn btn-primary" onclick="openModalcreaAzienda()">Aggiungi Azienda</button> &nbsp;
        <button class="btn btn-primary" onclick="resetFlt()">Resetta filtro</button>&nbsp;
        <div class="input-group-prepend">
            <span class="input-group-text">Cerca azienda</span>
        </div>
        <input type="text" class="form-control" value="<?php echo $src ?>" onchange="changeParam('src', this.value )"> &nbsp;
        <?php echo getComboUtenti("setUsr"); ?>
    </div>

    <table class="table table-hover table-bordered">
        <thead>
            <tr class="bg-light">
                <th class="col-1">#</th>
                <th class="col-1">Nome azienda</th>
                <th class="col-1">Città</th>
                <th class="col-1">Sito web</th>
                <th class="col-1">Num. telefono</th>
                <th class="col-1">Assegnato a</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
            ?>
                <tr>
                    <td class="col-1">
                        &nbsp;&nbsp;<span class="bi bi-eye-fill selectable" onclick="showDettagli(<?php echo $row->id; ?>, true)"></span>
                        &nbsp; &nbsp;<span class="bi bi-pencil-square selectable" onclick="openModalModificaAzienda(<?php echo $row->id; ?>);"></span>
                        &nbsp; &nbsp;<span class="bi bi-diagram-2 selectable" onclick="openModalAssegna(<?php echo $row->id; ?>);">&nbsp;</span>
                    </td>

                    <td class="col-1"><?php echo $row->nome; ?></td>
                    <td class="col-1"><?php echo $row->citta; ?></td>
                    <td class="col-1"><a target="_blank" href="<?php echo $row->sito_web; ?>"><?php echo $row->sito_web; ?></a>
                    </td>
                    <td class="col-1"><a href="tel:+<?php echo $row->telefono; ?>"><?php echo $row->telefono; ?></a></td>
                    <td class="col-1"><?php echo $row->utente; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
<?php

require_once "modal_azienda.php";
require_once "modal_utente.php";