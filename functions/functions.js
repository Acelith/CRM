/**
 * functions.js: Funzioni javascript globali
 *
 * @author Joël Moix
 */

/**
 * 
 * Init function
 */
 $( document ).ready(function() {
   // Se è impostato un numero di pagina, lo metto nella casella apposita
  $("#numero_pagina").val(getParam("pag"));

  $("#" + getParam("submod")).removeClass("notloaded");
  $("#" + getParam("submod")).addClass("loaded");
})

/**
 * Chiamata Ajax per eseguire il logout
 */
function logout() {
  $.ajax({
    type: "POST",
    url: "/functions/ajax_services.php",
    data: {
      cmd: "logout",
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
 * Funzione per modificare i parametri Get del modulo
 *
 * @param p_id      id del modulo nuovo
 */
function changeModule(p_id) {
  changeParam("m", p_id);
}

/**
 * Cambia il valore di un parametro. Nel caso il parametro non esista lo aggiunge
 *
 * @param p_param_name   Nome del parametro da mettere nel GET per definirlo
 * @param p_param_value  valore da inserire nel get
 *
 */
function changeParam(p_param_name, p_param_value) {
  // Prendo l'url corrente
  var url = new URL(window.location.href);

  var params = url.searchParams;

  // Imposto il nuovo parametro nell'url, nel caso non esistesse lo aggiunge
  params.set(p_param_name, p_param_value);

  url.search = params.toString();

  var new_url = url.toString();
  // Ricarico la pagina con i parametri nuvoi
  location.assign(new_url);
}

/**
 * Cancella un parametro dall'URL
 *
 * @param p_param nome del parametro da eliminare
 */
function delParam(p_param) {
  var url = new URL(window.location.href);

  var params = url.searchParams;

  if (Array.isArray(p_param)) {
    p_param.forEach((element) => {
      params.delete(element);
      
    });
  } else {
    // Cancello il parametro dall'url
    params.delete(p_param);
  }
  url.search = params.toString();

  var new_url = url.toString();
  // Ricarico la pagina con i parametri nuovi
  location.assign(new_url);
}

/**
 * Cancella tutti i parametri dall'url
 */
function delParams() {
  var url = new URL(window.location.href);
  url.search = "";
  var new_url = url.toString();

  location.assign(new_url);
}

/**
 * Ritorna il parametro richiesto
 * @param p_param - Il parametro da richiedere
 * @returns Il valore del parametro
 */
function getParam(p_param) {
  // Prendo l'url corrente
  var url = new URL(window.location.href);

  var params = url.searchParams;

  var param = params.get(p_param);

  return param;
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

/**
 *  Funzione per cambiare il submenu
 */
 function subMenu(p_submenu){
  changeParam("submod", p_submenu);
}