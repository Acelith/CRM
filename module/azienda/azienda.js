/**
 * azienda.js file javascript per il modulo azienda
 *
 * @author Joël Moix
 */

 $( document ).ready(function() {
  $("#numero_pagina").val(getParam("pag"));
})


/**
 * Imposta l'utenet di ricerca per la query
 * @param p_val - l'ID dell'utente da cercare
 */
function setUsr(p_val) {
  var id = $(p_val).attr("id");
  changeParam("usr", id);
}

/**
 * Cancella i parametri di ricerca dall'url
 */
function resetFlt(){
  var params = ["usr", "src"];
  delParam(params);
}
/**
 * Apre la modal per la creazione dell'azienda
 */
function openModalcreaAzienda() {
  $("#nome").val("");
  $("#telefono").val("");
  $("#sito").val("");
  $("#indirizzo").val("");
  $("#citta").val("");
  $("#cap").val("");
  $("#provincia").val("");
  $("#nazione").val("");
  $("#note").val("")
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
      note: $("#note").val(),
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
          $("#note").val(objVal.note).prop("readOnly", p_readonly);
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
          $("#nome").val(objVal.nome).prop("readOnly", false);
          $("#telefono").val(objVal.telefono).prop("readOnly", false);
          $("#sito").val(objVal.sito).prop("readOnly", false);
          $("#indirizzo").val(objVal.indirizzo).prop("readOnly", false);
          $("#citta").val(objVal.citta).prop("readOnly", false);
          $("#cap").val(objVal.cap).prop("readOnly", false);
          $("#provincia").val(objVal.provincia).prop("readOnly", false);
          $("#nazione").val(objVal.nazione).prop("readOnly", false);
          $("#id_azienda").val(p_id_azienda).prop("readOnly", false);
          $("#note").val(objVal.note).prop("readOnly", false);
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
      note: $("#note").val(),
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
 * Apre la modal per assegnare l'utente all'azienda 
 */
function openModalAssegna(p_id_azienda){
  $("#titolo_modal_utente").html("Assegna utente");
  $("#id_azienda_assegna").val(p_id_azienda);
  $("#modal_utente").modal({ keyboard: false });
}

/**
 * Funzione per assegnare l'utente ad una azienda
 */
function assegnaUtente(){
  $.ajax({
    type: "POST",
    url: "/module/azienda/ajax_services.php",
    data: {
      cmd: "assUtente",
      id_ute: $('#listaUtenti input:radio:checked').prop("id"),
      id_az: $("#id_azienda_assegna").val(),
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
 * funzione per andare in dietro di una pagina
 */
function precedentePagina(){
  var pag = getParam("pag");
  if(pag == 1 || pag == null){
    pag = 1;
  } else {
    pag = Number(pag) - Number("1"); 
  }
  changeParam("pag", pag);
}

/**
 * funzione per andare avanti di una pagina
 */
function prossimaPagina(){
  var pag = getParam("pag");
  pag = Number(pag) + Number("1"); 
  changeParam("pag", pag);
}
/**
 * funzione per cambiare pagina
 * 
 * @param obj   oggetto da passare per estrarre il valore
 */
function changePage(p_page){
  var page = $(p_page).val();
  changeParam("pag", page);
}