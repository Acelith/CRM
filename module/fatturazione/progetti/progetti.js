/**
 * progetti.js file javascript per il sottomodulo progetti
 *
 * @author Joël Moix  
 */

/**
 * Funzione per stampare una fattura
 */
 function stampaFatturaProgetto(p_id_fattura){
    $.ajax({
      type: "POST",
      url: "/module/fatturazione/progetti/ajax_services.php",
      data: {
        cmd: "stampaFattura",
        id: p_id_fattura,
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