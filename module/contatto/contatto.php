<?php
/**
 * contatto.php file per la gestione dei contatti
 *
 * @author Joël Moix  
 */

 # Controllo se l'utente è loggato
if(!utente::isLogged()){
    die();
}

$flt = " ";

if(isset($_GET['src'])){
    $flt .= "and ct.nome LIKE '%". $_GET['src']. "%' ";
    $flt .= "or ct.cognome LIKE '%". $_GET['src']. "%' ";
    $flt .= "or az.nome LIKE '%". $_GET['src']. "%' ";
}

$sqlStmt = "select ct.*, az.nome as azienda "
. "from contatto as ct "
    . "inner join azienda as az on az.id=ct.id_azienda "
    . "where 1=1 " . $flt . " order by az.nome asc";

try {
    # faccio la connessione al databse
    $dbConnect = DB::connect();
    $sth = $dbConnect->prepare($sqlStmt);
    # Eseguo la query;
    $sth->execute();
} catch (PDOException $e) {
    return "errore query: " . $e;
}

?>
  <div style="width: 20%;" class="input-group mb-3 "> &nbsp;
  <button class="btn btn-primary" onclick="clearSearch()">Resetta filtro</button> &nbsp;
  <div class="input-group-prepend">
                <span class="input-group-text">Cerca</span>
            </div>
            <input type="text" class="form-control" onchange="changeParam('src', this.value )">
        </div>


<table class="table table-hover table-bordered">
            <thead>
                <tr class="bg-light">
                    <th class="col-1">#</th>
                    <th class="col-1">Nome</th>
                    <th class="col-1">Cognome</th>
                    <th class="col-2">Num. telefono</th>
                    <th class="col-1">Azienda</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
                ?>
                    <tr>
                        <td class="col-1"><?php echo $row->id; ?>
                        &nbsp;&nbsp;<span class="bi bi-eye-fill selectable" onclick="showDettagli(<?php echo $row->id; ?>, true)"></span>
                        &nbsp; &nbsp;<span class="bi bi-pencil-square selectable" onclick="openModalModificaAzienda(<?php echo $row->id; ?>);">&nbsp;</span>
                        </td>

                        <td class="col-1"><?php echo $row->nome; ?></td>
                        <td class="col-1"><?php echo $row->cognome; ?></td>
                        <td class="col-1"><a href="tel:+<?php echo $row->telefono; ?>"><?php echo $row->telefono; ?></a></td>
                        <td class="col-2"><?php echo $row->azienda; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
