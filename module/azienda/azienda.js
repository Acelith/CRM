/**
 * azienda.js file javascript per il modulo azienda
 *
 * @author Joël Moix
 */

function setUsr(p_val) {
  var id = $(p_val).attr("id");
  changeParam("usr", id);
}

function resetFlt(){
  var params = ["usr", "src"];
  delParam(params);
}
/**
 * Apre la modal per la creazione dell'azienda
 */
function openModalcreaAzienda() {
  $("#btn_cancella").hide();
  $("#btn_modifica").hide();
  $("#titolo_modal_azienda").html("Aggiungi azienda");
  $("#modal_azienda").modal({ keyboard: false });
}

/**
 * Funzione per la creazione di un'azienda
 */
function creaAzienda() {
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
 * Apre la modal per la visualizazzione dei dettagli di un'azienda
 * @param p_id_azienda - id dell'azienda
 */
function showDettagli(p_id_azienda, p_readonly) {
  $.ajax({
    type: "POST",
    url: "/module/azienda/ajax_services.php",
    data: {
      cmd: "getDettagli",
      id: p_id_azienda,
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
          $("#sito").val(objVal.sito).prop("readOnly", p_readonly);
          $("#indirizzo").val(objVal.indirizzo).prop("readOnly", p_readonly);
          $("#citta").val(objVal.citta).prop("readOnly", p_readonly);
          $("#cap").val(objVal.cap).prop("readOnly", p_readonly);
          $("#provincia").val(objVal.provincia).prop("readOnly", p_readonly);
          $("#nazione").val(objVal.nazione).prop("readOnly", p_readonly);
          // Nascondo i bottoni
          $("#btn_cancella").hide();
          $("#btn_modifica").hide();
          $("#btn_aggiungi").hide();
          $("#titolo_modal_azienda").html("Dettagli " + objVal.nome);
          $("#modal_azienda").modal({ keyboard: false });
        }
      } catch (error) {
        alert("Errore: " + error + " " + text);
      }
    },
  });
}

/**
 * Apre la modal per la modifica dell'azienda
 */
function openModalModificaAzienda(p_id_azienda) {
  $.ajax({
    type: "POST",
    url: "/module/azienda/ajax_services.php",
    data: {
      cmd: "getDettagli",
      id: p_id_azienda,
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
          $("#nome").val(objVal.nome);
          $("#telefono").val(objVal.telefono);
          $("#sito").val(objVal.sito);
          $("#indirizzo").val(objVal.indirizzo);
          $("#citta").val(objVal.citta);
          $("#cap").val(objVal.cap);
          $("#provincia").val(objVal.provincia);
          $("#nazione").val(objVal.nazione);
          $("#id_azienda").val(p_id_azienda);
          // Nascondo i bottoni
          $("#btn_cancella").hide();
          $("#btn_modifica").show();
          $("#btn_aggiungi").hide();
          $("#titolo_modal_azienda").html("Modifica " + objVal.nome);
          $("#modal_azienda").modal({ keyboard: false });
        }
      } catch (error) {
        alert("Errore: " + error + " " + text);
      }
    },
  });
}

/**
 * Modifica un'azienda
 */
function modificaAzienda() {
  $.ajax({
    type: "POST",
    url: "/module/azienda/ajax_services.php",
    data: {
      cmd: "modAzienda",
      id: $("#id_azienda").val(),
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
