<?php

/**
 * admin.php: gestione delle componenti amministrative 
 *
 * @author Joël Moix  
 */

if (!utente::isLogged()) {
    die();
}


$sqlStmt = "SELECT nome, cognome, email, admin, dt_last_login, id FROM utente";

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
<div class="container-fluid">
    <button class="btn btn-primary" onclick="openModalCreaUtente()">Aggiungi Utente</button> &nbsp;
    <br><br>
    <table class="table table-hover table-bordered">
        <thead>
            <tr class="bg-light">
                <th class="col-1">#</th>
                <th class="col-1">Utente</th>
                <th class="col-1">email</th>
                <th class="col-2">Admin</th>
                <th class="col-1">Ultimo login</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
            ?>
                <tr>
                    <td class="col-1"><?php echo $row->id; ?>
                        <span class="bi bi-pencil-square selectable" onclick="openModalModificaUtente(<?php echo $row->id; ?>);">&nbsp;</span>
                    </td>

                    <td class="col-1"><?php echo $row->nome . "&nbsp;" . $row->cognome; ?></td>
                    <td class="col-1"><?php echo $row->email; ?></td>
                    <td class="col-2">
                        <?php
                        if ($row->admin) {
                            echo "Si";
                        } else {
                            echo "No";
                        }
                        ?>
                    </td>
                    <td class="col-1"><?php echo $row->dt_last_login; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
require_once "modal_utente.php";
?>