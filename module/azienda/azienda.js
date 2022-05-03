/**
 * azienda.js file javascript per il modulo azienda
 *
 * @author Joël Moix  
 */

/**
 * Apre la modal per la creazione di un'azienda
 *
 */
 function creaAzienda(p_id_azienda) {
    $("#modal_azienda").modal({ keyboard: false });
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
  