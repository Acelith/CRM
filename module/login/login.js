/**
 * login.js: Funzioni per il modulo login
 *
 * @author Joël Moix  
 */

/**
 * login() controlla se la password e la mail inserite sono corrette
 */
function login() {
  $.ajax({
    type: "POST",
    async: false,
    url: "/module/login/ajax_services.php",
    data: {
      cmd: "login",
      email: $("#email").val(),
      password: $("#password").val(),
    },
    success: function (text) {
      var objVal;
      try {
        objVal = JSON.parse(text);
        if (objVal.ajax_result !== "ok") {
          alert(objVal.ajax_result + " " + objVal.error);
          return false;
        } else {
          if (objVal.error != undefined) {
            // cambio i parametri dell'url per far comparire un avviso
            changeParam("err", objVal.error);
          } else {
            delParams();
          }
        }
      } catch (error) {
        alert("errore " + error + " " + text);
      }
    },
  });
}
