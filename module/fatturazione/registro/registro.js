/**
 * registro.js    file javascript per la consultazione delle fatture
 *
 * @author Joël Moix
 */

  /**
   * Resetta il filtro di ricerca
   */
  function resetFlt() {
    var params = ["src"];
    delParam(params);
  }
  
  /**
   * Funzione per aprire la modal per la creazione della fattura
   */
  function modalFattura(p_id_fattura) {
    $("#titolo_modal_fattura").html("Ristampa fattura");
    $("#id_fattura").val(p_id_fattura);
    $("#tipo_fatt").val(3);
    $("#id_fattura").hide();
    $("#tipo_fatt").hide();
    $("#modal_fattura").modal({ keyboard: false });
  }
  