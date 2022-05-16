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
 * apre la modal per la selezione dell'azienda
 */
function openModalSelezionaAzienda() {
  $("#select_aziende").modal({ keyboard: false });
}

/**
 * Cancella i parametri di ricerca dall'url
 */
function resetFlt() {
  var params = ["usr", "src"];
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
