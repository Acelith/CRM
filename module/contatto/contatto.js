/**
 * contatto.js: Funzioni javascript per i contatti
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
 * Apre la modal per la creazione del contatto
 */
function openModalcreaContatto() {
  $("#nome").val("");
  $("#telefono").val("");
  $("#cognome").val("");
  $("#azienda").val("");
  $("#btn_cancella").hide();
  $("#btn_modifica").hide();
  $("#selAzienda").show();
  $("#btn_aggiungi").show();
  $("#titolo_modal_contatto").html("Aggiungi contatto");
  $("#modal_contatto").modal({ keyboard: false });
}

/**
 * Funzione per la creazione di un contatto
 */
function creaContatto() {
  $.ajax({
    type: "POST",
    url: "/module/contatto/ajax_services.php",
    data: {
      cmd: "creaContatto",
      nome: $("#nome").val(),
      telefono: $("#telefono").val(),
      cognome: $("#cognome").val(),
      id_azienda: $("#id_azienda").val(),
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
 * Apre la modal per la visualizazzione dei dettagli di un contatto
 * @param p_id_contatto - id del contatto
 */
function showDettagli(p_id_contatto) {
  $.ajax({
    type: "POST",
    url: "/module/contatto/ajax_services.php",
    data: {
      cmd: "getDettagli",
      id: p_id_contatto,
    },
    success: function (text) {
      try {
        var objVal;

        objVal = JSON.parse(text);
        if (objVal.ajax_result !== "ok") {
          alert(objVal.ajax_result + " " + objVal.error);
          return false;
        } else {
          // Assegno i valori ai campi
          $("#nome").val(objVal.nome).prop("readOnly", p_readonly);
          $("#telefono").val(objVal.telefono).prop("readOnly", p_readonly);
          $("#cognome").val(objVal.cognome).prop("readOnly", p_readonly);
          $("#azienda").val(objVal.azienda).prop("readOnly", p_readonly);
          // Nascondo i bottoni
          $("#btn_cancella").hide();
          $("#btn_modifica").hide();
          $("#btn_aggiungi").hide();
          $("#selAzienda").hide();
          $("#titolo_modal_contatto").html("Dettagli " + objVal.nome);
          $("#modal_contatto").modal({ keyboard: false });
        }
      } catch (error) {
        alert("Errore: " + error + " " + text);
      }
    },
  });
}

/**
 * Apre la modal per la modifica del contatto
 */
function openModalModificaContatto(p_id_contatto) {
  $.ajax({
    type: "POST",
    url: "/module/contatto/ajax_services.php",
    data: {
      cmd: "getDettagli",
      id: p_id_contatto,
    },
    success: function (text) {
      try {
        var objVal;

        objVal = JSON.parse(text);
        if (objVal.ajax_result !== "ok") {
          alert(objVal.ajax_result + " " + objVal.error);
          return false;
        } else {
          // Assegno i valori ai campi
          $("#id_contatto").val(objVal.id_contatto);
          $("#nome").val(objVal.nome).prop("readOnly", false);
          $("#telefono").val(objVal.telefono).prop("readOnly", false);
          $("#cognome").val(objVal.cognome).prop("readOnly", false);
          $("#azienda").val(objVal.azienda).prop("readOnly", true);
          // Nascondo i bottoni
          $("#selAzienda").hide();
          $("#btn_cancella").show();
          $("#btn_modifica").show();
          $("#btn_aggiungi").hide();
          $("#titolo_modal_contatto").html("Modifica " + objVal.nome);
          $("#modal_contatto").modal({ keyboard: false });
        }
      } catch (error) {
        alert("Errore: " + error + " " + text);
      }
    },
  });
}

/**
 * Modifica un contatto
 */
function modificaContatto() {
  $.ajax({
    type: "POST",
    url: "/module/contatto/ajax_services.php",
    data: {
      cmd: "modContatto",
      id: $("#id_contatto").val(),
      cognome: $("#cognome").val(),
      nome: $("#nome").val(),
      telefono: $("#telefono").val(),
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
 * cancella un contatto
 */
function deleteContatto() {
  bootbox.confirm({
    title: "Cancello il contatto?",
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
          url: "/module/contatto/ajax_services.php",
          data: {
            cmd: "delContatto",
            id: $("#id_contatto").val(),
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

/**
 * apre la modal per la selezione di un'azienda
 */
function openModalSelezionaAzienda() {
  $("#select_aziende").modal({ keyboard: false });
}

/**
 * seleziona un'azienda e cambia i valori di alcuni campi nella modal
 */
function selezioneAzienda() {
  var id = $("#selector_aziende input:radio:checked").prop("id");
  var nome = $("#selector_aziende input:radio:checked").data("nome");

  $("#azienda").val(nome);
  $("#id_azienda").val(id);
  $("#select_aziende").modal("toggle");
}
