<?php

/**
 * functions.php File php con delle funzioni globali
 *
 * @author Joël Moix
 */

/**
 * Funzione per ritornare una combobox con gli utenti compilati
 * 
 * @param int $p_funzione   Funzione da chiamare quando si seleziona un'elemento
 * 
 * @return string stringa contenente la combobox * 
 */
function getComboUtenti($p_funzione)
{

    $sqlStmt = 'SELECT nome, cognome, id FROM utente';

    try {
        # faccio la connessione al databse
        $dbConnect = DB::connect();
        $sth = $dbConnect->prepare($sqlStmt);
        # Eseguo la query;
        $sth->execute();
    } catch (PDOException $e) {
        return 'errore query: ' . $e;
    }

    $utenti = '';
    while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
        $utenti .= "<a class='dropdown-item' onclick='" . $p_funzione . "(this)' id='$row->id'>$row->nome $row->cognome</a>";
    }

    $combo = "<div class='btn-group'>
    <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      Seleziona utente
    </button>
    <div class='dropdown-menu'>
        " . $utenti . "
    </div>
  </div>";

    return $combo;
}

/**
 * Funzione per ritornare una combobox con gli stati del ticket
 * 
 * @param int $p_funzione   Funzione da chiamare quando si seleziona un'elemento
 * 
 * @return string stringa contenente la combobox * 
 */
function getComboStatoTicket($p_funzione){
    
    $sqlStmt = 'SELECT * FROM stato_ticket';

    try {
        # faccio la connessione al databse
        $dbConnect = DB::connect();
        $sth = $dbConnect->prepare($sqlStmt);
        # Eseguo la query;
        $sth->execute();
    } catch (PDOException $e) {
        return 'errore query: ' . $e;
    }

    $stati = '';
    while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
        $stati .= "<a class='dropdown-item' onclick='" . $p_funzione . "(this)' id='$row->id'>$row->stato</a>";
    }

    $combo = "<div class='btn-group'>
    <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      Seleziona uno stato
    </button>
    <div class='dropdown-menu'>
        " . $stati . "
    </div>
  </div>";

  return $combo;

}

/**
 * Restituisce una lista di Radio button per selezionare l'utente 
 * @param int $p_id_radio   id con il quale identificare la lista 
 * 
 * @return string Stringa contenente la lista 
 */
function getListUtenti($p_id_radio)
{

    $sqlStmt = 'SELECT nome, cognome, id FROM utente';

    try {
        # faccio la connessione al databse
        $dbConnect = DB::connect();
        $sth = $dbConnect->prepare($sqlStmt);
        # Eseguo la query;
        $sth->execute();
    } catch (PDOException $e) {
        return 'errore query: ' . $e;
    }

    $utenti = '';
    while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
        $utenti .= "<div class='form-check'>";
        $utenti .= " <input class='form-check-input' type='radio' name='listaUtenti' data-nome='" . $row->nome . " " . $row->cognome . "' id='$row->id'>";
        $utenti .= "<label class='form-check-label' for='$row->id'>
                         " . $row->nome . " " . $row->cognome . "
                        </label>";
        $utenti .= "</div>";
    }

    $radio = "
    <div id='$p_id_radio'>
       $utenti
    </div>";
    return $radio;
}

/**
 * Ritorna una lista con le aziende che si possono selezionare
 */
function getAziendeSelect()
{
    $sqlStmt = "SELECT * FROM azienda";


    try {
        # faccio la connessione al databse
        $dbConnect = DB::connect();
        $sth = $dbConnect->prepare($sqlStmt);
        # Eseguo la query;
        $sth->execute();
    } catch (PDOException $e) {
        echo "errore query: " . $e;
    }

    $aziende = '';
    while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
        $aziende .= "<div class='form-check'>";
        $aziende .= " <input class='form-check-input' type='radio' data-nome='$row->nome' name='listaAziende' id='$row->id'>";
        $aziende .= "<label class='form-check-label' for='$row->id'>
                         " . $row->nome . "
                        </label>";
        $aziende .= "</div>";
    }

    $radio = "
    <div id='selector_aziende'>
       $aziende
    </div>";
    return $radio;
}
