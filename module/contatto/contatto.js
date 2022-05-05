/**
 * contatto.js: Funzioni javascript per i contatti 
 *
 * @author Joël Moix  
 */

/**
 * Imposta l'utenet di ricerca per la query
 * @param p_val - l'ID dell'utente da cercare
 */
 function setUsr(p_val) {
    var id = $(p_val).attr("id");
    changeParam("usr", id);
  }
  
/**
 * Resetta il filtro di ricerca 
 */
 function resetFlt(){
    var params = ["usr", "src"];
    delParam(params);
  }
