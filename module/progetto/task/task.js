/**
 * task.js file javascript per il sottomodulo task
 *
 * @author Joël Moix
 */

/**
 * Init function
 */
$(document).ready(function () {
  //$('#data_inizio').datetimepicker();
  $("#data_inizio").datepicker();
  $("#data_fine").datepicker();
});

/**
 * Funzione per la cancellazione di un task
 */
function deleteTask() {
  bootbox.confirm({
    title: "Cancello il task?",
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
          url: "/module/progetto/task/ajax_services.php",
          data: {
            cmd: "delTask",
            id_task: $("#id_task").val(),
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
 * Funzione per la creazione di un task
 */
function creaTask() {
  $.ajax({
    type: "POST",
    url: "/module/progetto/task/ajax_services.php",
    data: {
      cmd: "creaTask",
      nome: $("#nome").val(),
      data_inizio: $("#data_inizio").val(),
      data_fine: $("#data_fine").val(),
      ore: $("#ore").val(),
      progresso: $("#progresso").val(),
      id_progetto: $("#id_progetto").val(),
      descrizione: $("#descrizione").val(),
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
 * Apre la modal per la creazione dei task
 */
function openModalCreaTask() {
  $("#nome").val("");
  $("#data_inizio").val("");
  $("#data_fine").val("");
  $("#ore").val("");
  $("#progresso").val("");
  $("#descrizione").val("");
  $("#sel_progetto_input").val("");
  $("#btn_sel_task").show();
  $("#btn_modifica").hide();
  $("#btn_cancella").hide();
  $("#btn_aggiungi").show();
  $("#titolo_modal_task").html("Aggiungi Task");
  $("#modal_task").modal({ keyboard: false });
}
/**
 * Modifica un task
 */
function modificaTask() {
  $.ajax({
    type: "POST",
    url: "/module/progetto/task/ajax_services.php",
    data: {
      cmd: "modTask",
      id_task: $("#id_task").val(),
      nome: $("#nome").val(),
      data_inizio: $("#data_inizio").val(),
      data_fine: $("#data_fine").val(),
      ore: $("#ore").val(),
      progresso: $("#progresso").val(),
      descrizione: $("#descrizione").val(),
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
 * Apre la modal per la modifica dei task
 *
 * @param p_od_task   id del task da modificare
 */
function openModalModificaTask(p_id_task) {
  $.ajax({
    type: "POST",
    url: "/module/progetto/task/ajax_services.php",
    data: {
      cmd: "getTask",
      id_task: p_id_task,
    },
    success: function (text) {
      try {
        var objVal;

        objVal = JSON.parse(text);
        if (objVal.ajax_result !== "ok") {
          alert(objVal.ajax_result + " " + objVal.error);
          return false;
        } else {
          $("#nome").val(objVal.nome);
          $("#data_inizio").val(objVal.data_inizio);
          $("#data_fine").val(objVal.data_fine);
          $("#ore").val(objVal.ore);
          $("#progresso").val(objVal.progresso);
          $("#descrizione").val(objVal.descrizione);
          $("#sel_progetto_input").val(objVal.progetto);
          $("#id_task").val(objVal.id_task), $("#btn_modifica").show();
          $("#btn_cancella").show();
          $("#btn_aggiungi").hide();
          $("#btn_sel_task").hide();
          $("#titolo_modal_task").html("Modifica Task");
          $("#modal_task").modal({ keyboard: false });
        }
      } catch (error) {
        alert("Errore: " + error + " " + text);
      }
    },
  });
}

/**
 * Apre la modal per la selezione del progetto
 */
function openModalSelezionaProgetto() {
  $("#select_progetto").modal({ keyboard: false });
}

/**
 * Seleziona il progetto e inserisce gli identificatori nei campi della modal dei task.
 */
function selezionaProgetto() {
  var id = $("#lista_progetto input:radio:checked").prop("id");
  var nome = $("#lista_progetto input:radio:checked").data("nome");

  $("#sel_progetto_input").val(nome);
  $("#id_progetto").val(id);
  $("#select_progetto").modal("toggle");
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
 * Cancella i parametri di ricerca dall'url
 */
function resetFlt() {
  var params = ["usr", "src"];
  delParam(params);
}
