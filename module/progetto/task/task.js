  /**
 * task.js file javascript per il sottomodulo task
 *
 * @author Joël Moix  
 */

  /**
 * Funzione per la creazione di un'azienda
 */
function creaProgetto() {
  $.ajax({
    type: "POST",
    url: "/module/progetto/progetto/ajax_services.php",
    data: {
      cmd: "creaProgetto",
      nome: $("#nome").val(),
      data_inizio: $("#data_inizio").val(),
      data_fine_target: $("#data_fine_target").val(),
      data_fine_effettiva: $("#data_fine_effettiva").val(),
      budget_usato: $("#budget_usato").val(),
      budget: $("#budget").val(),
      descrizione: $("#descrizione").val(),
      progresso: $("#progresso").val(),
      id_azienda: $("#id_azienda").val(),
    },
    success: function (text) {
      try {
        var objVal;

        objVal = JSON.parse(text);
        if (objVal.ajax_result !== "ok") {
          alert(objVal.ajax_result + " " + objVal.error);
          return false;
        } else {
          location.reload(true);
        }
      } catch (error) {
        alert("Errore: " + error + " " + text);
      }
    },
  });
}
  /**
 * Imposta l'utenet di ricerca per la query
 * @param p_val - l'ID dell'utente da cercare
 */
   function setUsr(p_val) {
    var id = $(p_val).attr("id");
    changeParam("usr", id);
  }

  /**
 * Cancella i parametri di ricerca dall'url
 */
 function resetFlt(){
    var params = ["usr", "src"];
    delParam(params);
  }
