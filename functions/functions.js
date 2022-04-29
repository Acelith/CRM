/**
 * functions.js: Funzioni javascript globali 
 *
 * @author Joël Moix  
 */

/**
 * Chiamata Ajax per eseguire il logout
 */
function logout(){
        $.ajax({
            type: "POST",
            url: "/functions/ajax_services.php",
            data: {
                cmd: "logout",
            },
            success: function (text) {
              try{
                var objVal;
                
                objVal = JSON.parse(text);
                if (objVal.ajax_result !== "ok") {
                    alert(objVal.ajax_result + " " +objVal.error);
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
function changeModule(p_id){
    changeParam('m', p_id);
}

/**
* Cambia il valore di un parametro. Nel caso il parametro non esista lo aggiunge 
*
* @param p_param_name   Nome del parametro da mettere nel GET per definirlo
* @param p_param_value  valore da inserire nel get
*
*/
function changeParam(p_param_name, p_param_value){
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
 * Cancella tutti i parametri dall'url
 */
function delParams(){
    var url = new URL(window.location.href);
    url.search = '';    
    var new_url = url.toString();
       
    location.assign(new_url);
}
