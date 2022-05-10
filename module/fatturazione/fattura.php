<?php

/**
 * fattura.php file per la creazione della fattura
 * 
 * @author Joël Moix  
 */
# Controllo se l'utente è loggato
if (!utente::isLogged()) {
    die();
}


function creaFatturaProgetto($p_id_progetto, $p_fattura_on_budget = true){
    if ($p_fattura_on_budget) {
        $sqlStmt = "SELECT * from progetto where id=:id";
        $parArr = array(
            ":id" => $p_id_progetto
        );

        try {
            # faccio la connessione al databse
            $dbConnect = DB::connect();
            $sth = $dbConnect->prepare($sqlStmt);
            # Eseguo la query;
            $sth->execute($parArr);
        } catch (PDOException $e) {
            echo "errore query: " . $e;
        }
    }

    $invoiceRow = "";
    while($row= $sth->fetch(PDO::FETCH_OBJ)) {
        $invoiceRow = "
        <tr class='item'>
        <td>$row->nome</td>

        <td>$row->budget_usato</td>
    </tr>";
    }

    return $invoiceRow;
}
