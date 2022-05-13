/**
 * ticket_aziende.js    file javascript per la gestione dei ticket delle aziende
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
function resetFlt() {
  var params = ["usr", "src"];
  delParam(params);
}

/**
 * Funzione per aprire la modal per la creazione della fattura
 */
function modalFattura(p_id_azienda) {
  $("#titolo_modal_fattura").html("Crea fattura");
  $("#id_azienda").val(p_id_azienda);
  $("#tipo_fatt").val(2);
  $("#id_azienda").hide();
  $("#tipo_fatt").hide();
  $("#modal_fattura").modal({ keyboard: false });
}
