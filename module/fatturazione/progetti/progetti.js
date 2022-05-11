/**
 * progetti.js file javascript per il sottomodulo progetti
 *
 * @author Joël Moix  
 */

/**
 * Funzione per aprire la modal per la creazione della fattura
 */
 function modalFattura(p_id_progetto){
  $("#titolo_modal_fattura").html("Crea fattura");
  $("#id_progetto").val(p_id_progetto);
  $("#modal_fattura").modal({ keyboard: false });
}

/**
 * Funzione per stampare una fattura
 */
 function stampaFatturaProgetto(){
    $.ajax({
      type: "POST",
      url: "/module/fatturazione/progetti/ajax_services.php",
      data: {
        cmd: "stampaFattura",
        id: $("#id_progetto").val(),
        tipo_fatt:$('#scelta_fatt input:radio:checked').prop("id"),
      },
      success: function (text) {
        try {
          var objVal;
  
          objVal = JSON.parse(text);
          if (objVal.ajax_result !== "ok") {
            alert(objVal.ajax_result + " " + objVal.error);
            return false;
          } else {
            alert("Inizio donwload");
          }
        } catch (error) {
          alert("Errore: " + error + " " + text);
        }
      },
    });
  }