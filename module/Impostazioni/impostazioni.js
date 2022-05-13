/**
 * impostazioni.js file javascript per il modulo impostazioni
 *
 * @author Joël Moix
 */

/**
 * Cambia l'impostazione data
 *
 * @param   object p_field  campo da aggiornare
 */
function changeSetting(p_field) {
  $.ajax({
    type: "POST",
    async: false,
    url: "/module/impostazioni/ajax_services.php",
    data: {
      cmd: "changeSetting",
      name: $(p_field).attr("id"),
      val: $(p_field).val(),
    },
    success: function (text) {
      try {
        var objVal;

        objVal = JSON.parse(text);
        if (objVal.ajax_result !== "ok") {
          alert(objVal.ajax_result + " " + objVal.error);
          return false;
        } else {
          if (objVal.error != undefined) {
          }
        }
      } catch (error) {
        alert("Errore: " + error + " " + text);
      }
    },
  });
}
