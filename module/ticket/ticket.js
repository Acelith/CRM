/**
 * ticket.js file javascript per il modulo ticket
 *
 * @author Joël Moix
 */

/**
 * Init function
 */
$(document).ready(function () {
  $("#data_inizio").datepicker();
});

/**
 * Apre la modal per la creazione del ticket
 */
function openModalcreaTicket() {
  $("#titolo").val("");
  $("#data_inizio").val("");
  $("#ore").val("");
  $("#fatturare").val("");
  $("#azienda").val("");
  $("#operatore").val("");
  $("#azienda").val("");
  $("#descrizione").val("");
  $("#soluzione").val("");
  $("#btn_modifica").hide();
  $("#btn_cancella").hide();
  $("#btn_aggiungi").show();
  $("#titolo_modal_ticket").html("Aggiungi ticket");
  $("#modal_ticket").modal({ keyboard: false });
}

/**
 * Funzione per la creazione di un ticket
 */
function creaTicket() {
  $.ajax({
    type: "POST",
    url: "/module/ticket/ajax_services.php",
    data: {
      cmd: "creaTicket",
      titolo: $("#titolo").val(),
      data_inizio: $("#data_inizio").val(),
      ore: $("#ore").val(),
      fatturare: $("#fatturare").is(":checked"),
      azienda: $("#id_azienda").val(),
      operatore: $("#id_operatore").val(),
      descrizione: $("#descrizione").val(),
      soluzione: $("#soluzione").val(),
      stato: $("#selStato option:selected").val(),
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
 * Apre la modal per la modifica di un ticket
 * 
 * @param p_id_ticket id del ticket da far vedere
 */
 function openModalModificaTicket(p_id_ticket) {
  $.ajax({
    type: "POST",
    url: "/module/ticket/ajax_services.php",
    data: {
      cmd: "getDettagli",
      id: p_id_ticket,
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
          $("#titolo").val(objVal.titolo).prop("readOnly", false);
          $("#data_inizio").val(objVal.orario_inizio).prop("readOnly", false);
          $("#ore").val(objVal.ore).prop("readOnly", false);
          if(objVal.fatturare == "1") {
            $("#fatturare").prop('checked', true).prop("readOnly", false);
          } else {
            $("#fatturare").prop('checked', false).prop("readOnly", false);
          }
          $("#selStato").val(objVal.stato).change();
          $("#azienda").val(objVal.azienda).prop("readOnly", false);
          $("#operatore").val(objVal.operatore).prop("readOnly", false);
          $("#descrizione").val(objVal.descrizione).prop("readOnly", false);
          $("#soluzione").val(objVal.soluzione).prop("readOnly", false);
          $("#id_azienda").val(objVal.id_azienda);
          $("#id_ticket").val(p_id_ticket);
          $("#id_operatore").val(objVal.id_operatore);
           
          // Nascondo i bottoni
          $("#selAzienda").show();
          $("#btn_cancella").show();
          $("#btn_modifica").show();
          $("#btn_aggiungi").hide();
          $("#titolo_modal_progetto").html("Modifica " + objVal.nome);
          $("#modal_ticket").modal({ keyboard: false });
        }
      } catch (error) {
        alert("Errore: " + error + " " + text);
      }
    },
  });
}

/**
 * Modifica un ticket
 */
function modificaTicket(){
  $.ajax({
    type: "POST",
    url: "/module/ticket/ajax_services.php",
    data: {
      cmd: "modificaTicket",
      id: $("#id_ticket").val(),
      titolo: $("#titolo").val(),
      data_inizio: $("#data_inizio").val(),
      ore: $("#ore").val(),
      fatturare: $("#fatturare").is(":checked"),
      azienda: $("#id_azienda").val(),
      operatore: $("#id_operatore").val(),
      descrizione: $("#descrizione").val(),
      soluzione: $("#soluzione").val(),
      stato: $("#selStato option:selected").val(),
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
 * Apre la modal con i dettagli del ticket
 * 
 * @param p_id_ticket id del ticket da visualizzare
 */
function showDettagli(p_id_ticket){
  $.ajax({
    type: "POST",
    url: "/module/ticket/ajax_services.php",
    data: {
      cmd: "getDettagli",
      id: p_id_ticket,
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
          $("#titolo").val(objVal.titolo).prop("readOnly", true);
          $("#data_inizio").val(objVal.orario_inizio).prop("readOnly", true);
          $("#ore").val(objVal.ore).prop("readOnly", true);
          if(objVal.fatturare == "1") {
            $("#fatturare").prop('checked', true).prop("readOnly", true);
          } else {
            $("#fatturare").prop('checked', false).prop("readOnly", true);
          }
          $("#selStato").val(objVal.stato).change().prop("readOnly", true);
          $("#azienda").val(objVal.azienda).prop("readOnly", true);
          $("#operatore").val(objVal.operatore).prop("readOnly", true);
          $("#descrizione").val(objVal.descrizione).prop("readOnly", true);
          $("#soluzione").val(objVal.soluzione).prop("readOnly", true);
          $("#id_azienda").val(objVal.id_azienda);
          $("#id_ticket").val(p_id_ticket);
          $("#id_operatore").val(objVal.id_operatore);
           
          // Nascondo i bottoni
          $("#selOperatore").hide();
          $("#selAzienda").hide();
          $("#btn_cancella").hide();
          $("#btn_modifica").hide();
          $("#btn_aggiungi").hide();
          $("#titolo_modal_progetto").html("Modifica " + objVal.nome);
          $("#modal_ticket").modal({ keyboard: false });
        }
      } catch (error) {
        alert("Errore: " + error + " " + text);
      }
    },
  });
}

/**
 * apre la modal per la selezione dell'azienda
 */
function openModalSelezionaAzienda() {
  $("#select_aziende").modal({ keyboard: false });
}

function delTicket(){
  bootbox.confirm({
    title: "Cancello il ticket?",
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
          url: "/module/ticket/ajax_services.php",
          data: {
            cmd: "delTicket",
            id: $("#id_ticket").val(),
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
    },
  });
}

/**
 * Cancella i parametri di ricerca dall'url
 */
function resetFlt() {
  var params = ["usr", "src", "stat", "pag"];
  delParam(params);
}

/**
 * Imposta l'utenet di ricerca per la query
 * @param p_val - l'ID dell'utente da cercare
 */
function setUsr(p_val) {
  var id = $(p_val).attr("id");
  changeParam("usr", id);
}

/**
 * Imposta lo stato di ricerca
 * @param p_val - l'ID dello stato
 */
 function setStato(p_val) {
  var id = $(p_val).attr("id");
  changeParam("stat", id);
}

/**
 * seleziona un'azienda  e la sinerisce in alcuni campi della modal
 */
function selezioneAzienda() {
  var id = $("#selector_aziende input:radio:checked").prop("id");
  var nome = $("#selector_aziende input:radio:checked").data("nome");

  $("#azienda").val(nome);
  $("#id_azienda").val(id);
  $("#select_aziende").modal("toggle");
}

/**
 * Apre la modal per selezionare l'operatore
 */
function openModalSelOperatore() {
  $("#modal_utente").modal({ keyboard: false });
}

/**
 * seleziona un operatore  e la sinerisce in alcuni campi della modal
 */
function selezioneOperatore() {
  var id = $("#listaUtenti input:radio:checked").prop("id");
  var nome = $("#listaUtenti input:radio:checked").data("nome");

  $("#operatore").val(nome);
  $("#id_operatore").val(id);
  $("#modal_utente").modal("toggle");
}
