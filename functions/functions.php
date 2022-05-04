<?php
/**
* functions.php File php con delle funzioni globali
*
* @author Joël Moix
*/

/**
 * Funzione per ritornare una combobox con gli utenti compilati
 * 
 * @param int $p_identificativo_dropdown    id con il quale identificare il dropdown
 * 
 * @return string stringa contenente la combobox * 
 */
function getComboUtenti( $p_identificativo_dropdown ) {

    $sqlStmt = 'SELECT nome, cognome, id FROM utente';

    try {
        # faccio la connessione al databse
        $dbConnect = DB::connect();
        $sth = $dbConnect->prepare( $sqlStmt );
        # Eseguo la query;
        $sth->execute();
    } catch ( PDOException $e ) {
        return 'errore query: ' . $e;
    }

    $utenti = '';
    while ( $row = $sth->fetch( PDO::FETCH_OBJ ) ) {
        $utenti .= "<a class='dropdown-item' id='$row->id'>$row->nome $row->cognome</a>";
    }

    $combo = "<div class='btn-group'>
    <button id='" . $p_identificativo_dropdown . "'type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      Seleziona utente
    </button>
    <div class='dropdown-menu'>
        " . $utenti . "
    </div>
  </div>";

    return $combo;
}