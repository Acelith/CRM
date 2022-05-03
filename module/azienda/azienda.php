<?php
/**
 * azienda.php file per la gestione delle aziende
 *
 * @author Joël Moix  
 */

 # Controllo se l'utente è loggato
if(!utente::isLogged()){
    die();
}

$sqlStmt = "SELECT * FROM Azienda";


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

<div class="container-fluid ">
    <div class="row">
    <button class="btn btn-primary" onclick="openModalcreaAzienda()">Aggiungi Azienda</button>
        <table class="table table-hover table-bordered">
            <thead>
                <tr class="bg-light">
                    <th class="col-1">#</th>
                    <th class="col-1">Nome azienda</th>
                    <th class="col-1">Città</th>
                    <th class="col-2">Sito web</th>
                    <th class="col-1">Num. telefono</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
                ?>
                    <tr>
                        <td class="col-1"><?php echo $row->id; ?>
                            &nbsp;<span class="bi bi-eye-fill selectable" onclick="showDettagli(<?php echo $row->id; ?>, true)"></span>
                            &nbsp;<span class="bi bi-pencil-square selectable" onclick="openModalModificaAzienda(<?php echo $row->id; ?>);">&nbsp;</span>
                        </td>

                        <td class="col-1"><?php echo $row->nome; ?></td>
                        <td class="col-1"><?php echo $row->citta; ?></td>
                        <td class="col-2"><a target="_blank"  href="<?php echo $row->sito_web; ?>"><?php echo $row->sito_web; ?></a></td>
                        <td class="col-1"><a href="tel:+<?php echo $row->telefono; ?>"><?php echo $row->telefono; ?></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php

require_once "modal_azienda.php";