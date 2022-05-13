/**
 * admin.js file javascript per il modulo admin
 *
 * @author Joël Moix
 */

/**
 * Apre la modal per la creazione di un'utente
 */
function openModalCreaUtente() {
  $("#nome").val("");
  $("#cognome").val("");
  $("#email").val("");
  $("#dt_last_login").val("");
  $("#dt_creazione").val("");
  $("#id_utente").val("");
  $("#admin").prop("checked", false);

  $("#titolo_modal_utente").html("Crea utente");
  $("#btn_aggiungi").show();
  $("#btn_modifica").hide();
  $("#btn_cancella").hide();
  $("#modal_utente").modal({ keyboard: false });
}
/**
 * Funzione per la creazione di un'utente
 */
function creaUtente() {
  var pwd = $("#password").val();
  var confPwd = $("#confPassword").val();

  if (pwd != "" && confPwd != "") {
    if (pwd != confPwd) {
      alert("Le password non corrispondono!");
      return false;
    }
  }
  $.ajax({
    type: "POST",
    url: "/module/admin/ajax_services.php",
    data: {
      cmd: "creUtente",
      nome: $("#nome").val(),
      cognome: $("#cognome").val(),
      email: $("#email").val(),
      password: $("#password").val(),
      confPassword: $("#confPassword").val(),
      admin: $("#admin").is(":checked"),
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
 * Apre la modal per la visualizzazione dell'utente
 * @param p_id_utente - l'id dell'utente da visualizzare
 */
function openModalModificaUtente(p_id_utente) {
  $.ajax({
    type: "POST",
    url: "/module/admin/ajax_services.php",
    data: {
      cmd: "getUtente",
      id: p_id_utente,
    },
    success: function (text) {
      try {
        var objVal;

        objVal = JSON.parse(text);
        if (objVal.ajax_result !== "ok") {
          alert(objVal.ajax_result + " " + objVal.error);
          return false;
        } else {
          //Imposto i campi
          $("#nome").val(objVal.nome);
          $("#cognome").val(objVal.cognome);
          $("#email").val(objVal.email);
          $("#dt_last_login").val(objVal.dt_last_login);
          $("#dt_creazione").val(objVal.dt_creazione);
          $("#id_utente").val(p_id_utente);
          if (objVal.admin == 1) {
            $("#admin").prop("checked", true);
          } else {
            $("#admin").prop("checked", false);
          }

          $("#titolo_modal_utente").html(
            "Modifica utente " + objVal.nome + " " + objVal.cognome
          );
          $("#btn_aggiungi").hide();
          $("#btn_modifica").show();
          $("#btn_cancella").show();
          $("#modal_utente").modal({ keyboard: false });
        }
      } catch (error) {
        alert("Errore: " + error + " " + text);
      }
    },
  });
}

/**
 * Modifica l'utente
 */
function modificaUtente() {
  var pwd = $("#password").val();
  var confPwd = $("#confPassword").val();

  if (pwd != "" && confPwd != "") {
    if (pwd != confPwd) {
      alert("Le password non corrispondono!");
      return false;
    }
  }
  $.ajax({
    type: "POST",
    url: "/module/admin/ajax_services.php",
    data: {
      cmd: "modUtente",
      id: $("#id_utente").val(),
      nome: $("#nome").val(),
      cognome: $("#cognome").val(),
      email: $("#email").val(),
      password: $("#password").val(),
      confPassword: $("#confPassword").val(),
      admin: $("#admin").is(":checked"),
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
 * Funzione per cancellare un'utente
 */
function deleteUtente() {
  bootbox.confirm({
    title: "Cancello l'utente?",
    message: "L'azione è irreversibile",
    buttons: {
      cancel: {
        label: '<i class="fa fa-times"></i> No',
      },
      confirm: {
        label: '<i class="fa fa-check"></i> Si',
      },
    },
    callback: function (result) {
      if (result === true) {
        $.ajax({
          type: "POST",
          async: false,
          url: "/module/admin/ajax_services.php",
          data: {
            cmd: "delUtente",
            id: $("#id_utente").val(),
          },

          success: function (text) {
            try {
              var objVal;

              objVal = JSON.parse(text);
              if (objVal.ajax_result !== "ok") {
                alert(objVal.ajax_result + " " + objVal.error);
                return false;
              } else {
                location.reload();
              }
            } catch (error) {
              alert("Errore: " + error + " " + text);
            }
          },
        });
      }
    },
  });
}
