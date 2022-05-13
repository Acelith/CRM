/**
 * progetto.js file javascript per il modulo progetto
 *
 * @author Joël Moix  
 */
 
/**
 * Init function
 */
$(document).ready(function(){
  //$('#data_inizio').datetimepicker();
  $('#data_inizio').datepicker();
  $('#data_fine_target').datepicker();
  $('#data_fine_effettiva').datepicker();
});


/**
 * Apre la modal per la creazione del progetto
 */
 function openModalcreaProgetto() {
  $("#nome").val("");
  $("#data_inizio").val("");
  $("#data_fine_target").val("");
  $("#data_fine_effettiva").val("");
  $("#budget").val("");
  $("#budget_usato").val("");
  $("#progresso").val("");
  $("#descrizione").val("");
  $("#btn_modifica").hide();
  $("#btn_cancella").hide();
  $("#btn_aggiungi").show();
  $("#titolo_modal_progetto").html("Aggiungi progetto");
  $("#modal_progetto").modal({ keyboard: false });
}

/**
 * Funzione per la creazione di un'azienda
 */
function creaProgetto() {
  $.ajax({
    type: "POST",
    url: "/module/progetto/progetto/ajax_services.php",
    data: {
      cmd: "creaProgetto",
      nome: $("#nome").val(),
      data_inizio: $("#data_inizio").val(),
      data_fine_target: $("#data_fine_target").val(),
      data_fine_effettiva: $("#data_fine_effettiva").val(),
      budget_usato: $("#budget_usato").val(),
      budget: $("#budget").val(),
      descrizione: $("#descrizione").val(),
      progresso: $("#progresso").val(),
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
 * Apre la modal per la modifica di un progetto
 */
 function openModalModificaProgetto(p_id_progetto) {
  $.ajax({
    type: "POST",
    url: "/module/progetto/progetto/ajax_services.php",
    data: {
      cmd: "getDettagli",
      id: p_id_progetto,
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
          $("#data_inizio").val(objVal.data_inizio).prop("readOnly", false);
          $("#data_fine_target").val(objVal.data_fine_target).prop("readOnly", false);
          $("#data_fine_effettiva").val(objVal.data_fine_effettiva).prop("readOnly", true);
          $("#budget").val(objVal.budget).prop("readOnly", false);
          $("#budget_usato").val(objVal.budget_usato).prop("readOnly", false);
          $("#progresso").val(objVal.progresso).prop("readOnly", false);
          $("#azienda").val(objVal.azienda).prop("readOnly", false);
          $("#descrizione").val(objVal.descrizione).prop("readOnly", false);
          // Nascondo i bottoni
          $("#selAzienda").hide();
          $("#btn_cancella").show();
          $("#btn_modifica").show();
          $("#btn_aggiungi").hide();
          $("#titolo_modal_progetto").html("Modifica " + objVal.nome);
          $("#modal_progetto").modal({ keyboard: false });
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
 function showDettagli(p_id_contatto, p_readonly) {
  $.ajax({
    type: "POST",
    url: "/module/progetto/progetto/ajax_services.php",
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
          $("#nome").val(objVal.nome).prop("readOnly", true);
          $("#data_inizio").val(objVal.data_inizio).prop("readOnly", true);
          $("#data_fine_target").val(objVal.data_fine_target).prop("readOnly", true);
          $("#data_fine_effettiva").val(objVal.data_fine_effettiva).prop("readOnly", true);
          $("#budget").val(objVal.budget).prop("readOnly", true);
          $("#budget_usato").val(objVal.budget_usato).prop("readOnly", true);
          $("#progresso").val(objVal.progresso).prop("readOnly", true);
          $("#azienda").val(objVal.azienda).prop("readOnly", true);
          $("#descrizione").val(objVal.descrizione).prop("readOnly", true);
          // Nascondo i bottoni
          $("#selAzienda").hide();
          $("#btn_cancella").hide();
          $("#btn_modifica").hide();
          $("#btn_aggiungi").hide();
          $("#titolo_modal_progetto").html("Dettagli " + objVal.nome);
          $("#modal_progetto").modal({ keyboard: false });
        }
      } catch (error) {
        alert("Errore: " + error + " " + text);
      }
    },
  });
}



function openModalSelezionaAzienda(){
  $("#select_aziende").modal({ keyboard: false });
}

/**
 * Cancella i parametri di ricerca dall'url
 */
 function resetFlt(){
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

function selezioneAzienda(){
  var id = $('#selector_aziende input:radio:checked').prop("id");
  var nome = $('#selector_aziende input:radio:checked').data("nome");

  $("#azienda").val(nome);
  $("#id_azienda").val(id);
  $("#select_aziende").modal('toggle');
}
  