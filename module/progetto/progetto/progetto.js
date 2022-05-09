/**
 * progetto.js file javascript per il modulo progetto
 *
 * @author Joël Moix  
 */

/**
 * Cancella i parametri di ricerca dall'url
 */
 function resetFlt(){
    var params = ["usr", "src"];
    delParam(params);
  }

  /**
 * Imposta l'utenet di ricerca per la query
 * @param p_val - l'ID dell'utente da cercare
 */
function setUsr(p_val) {
    var id = $(p_val).attr("id");
    changeParam("usr", id);
  }
  