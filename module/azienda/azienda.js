/**
 * azienda.js file javascript per il modulo azienda
 *
 * @author Joël Moix  
 */

/**
 * Apre la modal per la creazione di un'azienda
 *
 */
 function openModalcreaAzienda() {
    $("#btn_cancella").hide();
    $("#btn_modifica").hide();
    $("#titolo_modal_azienda").html("Aggiungi azienda");
    $("#modal_azienda").modal({ keyboard: false });
  }

function creaAzienda(){
  $.ajax({
    type: "POST",
    url: "/module/azienda/ajax_services.php",
    data: {
        cmd: "creaAzienda",
        nome: $("#nome").val(),
        telefono: $("#telefono").val(),
        sito: $("#sito").val(),
        indirizzo: $("#indirizzo").val(),
        citta: $("#citta").val(),
        cap: $("#cap").val(),
        provincia: $("#provincia").val(),
        nazione: $("#nazione").val(),
    },
    success: function (text) {
      try{
        var objVal;
        
        objVal = JSON.parse(text);
        if (objVal.ajax_result !== "ok") {
            alert(objVal.ajax_result + " " +objVal.error);
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
  
  function showDettagli(p_id_azienda){
    $.ajax({
      type: "POST",
      url: "/azienda/ajax_services.php",
      data: {
          cmd: "getDettagli",
          id: p_id_azienda
      },
      success: function (text) {
        try{
          var objVal;
          
          objVal = JSON.parse(text);
          if (objVal.ajax_result !== "ok") {
              alert(objVal.ajax_result + " " +objVal.error);
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
  