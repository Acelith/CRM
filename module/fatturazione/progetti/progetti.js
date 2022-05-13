/**
 * progetti.js file javascript per il sottomodulo progetti
 *
 * @author Joël Moix
 */

/**
 * Funzione per aprire la modal per la creazione della fattura
 */
function modalFattura(p_id_progetto) {
  $("#titolo_modal_fattura").html("Crea fattura");
  $("#id_progetto").val(p_id_progetto);
  $("#tipo_fatt").val(1);
  $("#id_progetto").hide();
  $("#tipo_fatt").hide();
  $("#modal_fattura").modal({ keyboard: false });
}
