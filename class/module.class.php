<?php
/**
 * module.class.php: gestione dei moduli
 *
 * @author Joël Moix  
 */

# importo i file necessari
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";;

/**
 * classe per la gestione dei moduli
 */
class Module {

    /**
     * Si occupa di chiamare il modulo di default
     * 
     * @return array        array contenente gli script da caricare 
     */
    static function loadDefault() {
        $settings = Impostazioni::GetSetting('default_modulo');
        $ret = self::loadMOdule($settings);
        return $ret; 
    }

    /**
     * loadmodule:          carica il modulo richiesto
     *
     * @param string        $p_moduleId   id del modulo richiesto
     * 
     * @return array        array contenente gli script da caricare 
     */
    static function loadModule($p_moduleId) {

        $sqlStmt = "SELECT * FROM modulo where id=:id";

        $parArr = array(
            ":id" => $p_moduleId
        );
        
        try {
            # faccio la connessione al databse
            $dbConnect = DB::connect();
            $sth = $dbConnect->prepare($sqlStmt);
            # Eseguo la query;
            $sth->execute($parArr);
        } catch (PDOException $e) {
            return "errore query: " . $e;
        }

        $module = $sth->fetch(PDO::FETCH_OBJ);
        $cartellaModulo = $module->cartella;
        if(! $module->abilitato){
            die();
        }
        
        # Definisco l'array con i file da importare, all'interno gli metto quelli di default
        $ret = array(
            "css" => "<link href='layout/layout.css' rel='stylesheet' type='text/css'>",
            "js" => "<script src='functions/functions.js'></script>",
            "php" => "",
            "navbar" => ""
        );
        # Ritorno la navbar se l'utente è loggato
        if(isset($_SESSION['loggato'])){
            $ret['navbar'] = self::getNavBar($p_moduleId);
        }

        # Controllo se esiste il file php
        
        if (file_exists(MODULE_PATH . $cartellaModulo . DIRECTORY_SEPARATOR . $cartellaModulo . ".php")) {
            $ret['php'] = MODULE_PATH . $cartellaModulo . DIRECTORY_SEPARATOR . $cartellaModulo . '.php';
        } else {
            $ret['php'] = ROOT_PATH . "module" . DIRECTORY_SEPARATOR . 'default.php';
            return $ret;
        }

        # Controllo se esiste il file javascript
        if (file_exists(MODULE_PATH . $cartellaModulo .  DIRECTORY_SEPARATOR . $cartellaModulo . ".js")) {
            $ret['js'] .= " <script type='text/javascript' src='" . DIRECTORY_SEPARATOR . "module" . DIRECTORY_SEPARATOR . $cartellaModulo .  DIRECTORY_SEPARATOR . $cartellaModulo . ".js'></script>";

        }

        # Controllo se esiste il file css
        if (file_exists(MODULE_PATH . $cartellaModulo .  DIRECTORY_SEPARATOR . $cartellaModulo . ".css")) {
            $ret['css'] .= "<link href='" . DIRECTORY_SEPARATOR . "module" . DIRECTORY_SEPARATOR . $cartellaModulo .  DIRECTORY_SEPARATOR . $cartellaModulo . ".css' rel='stylesheet' type='text/css'>";
        }

       
        return $ret;
    }

    /**
     * getNavBar()         Disegna la barra di navigazione popolandola con i moduli abilitati nel DB
     *
     * @param int          $p_moduleid   ID del modulo corrente
     * 
     * @return string      Contiene la navbar per la navigazione
     */
    static function getNavBar($p_moduleId = null) {
        $sqlStmt = "SELECT * FROM modulo where id<>0 order by id asc";

        try {
            # faccio la connessione al databse
            $dbConnect = DB::connect();
            $sth = $dbConnect->prepare($sqlStmt);
            # Eseguo la query;
            $sth->execute();
        } catch (PDOException $e) {
            return "errore query: " . $e;
        }
        
        # mi faccio ritornare il modulo di default
        $menuItems = "";
        $adminItems = "";
        $defaultModule = Impostazioni::getDefaultModule();

        while ($row = $sth->fetch(PDO::FETCH_OBJ)) {

            # Controllo su quale modulo l'utente si trova così lo "evidenzio" nella navbar
            if($p_moduleId == $row->id){
                $status = "loaded";
            } else{
                $status = "notloaded";
            }

            # Controllo se il modulo è abilitato
            if($row->abilitato == 1 ){
                if($row->admin == 1){
                    if(utente::isAdmin() == 0){
                        continue;
                    } else {
                        $adminItems .= "
                        <li class='nav-item'>
                            <a class='nav-link selectable $status' onclick='changeModule($row->id);'><span class='$row->icona'></span>&nbsp;&nbsp;&nbsp;$row->nome</a>
                        </li> ";
                        continue;
                    }
                }
                # Controllo quale modulo è di defualt
                if ($row->id == $defaultModule) {
                    $firstItem = "
                        <li class='nav-item'>
                            <a class='nav-link selectable $status' onclick='changeModule($row->id);'><span class='$row->icona'></span>&nbsp;&nbsp;&nbsp;$row->nome</a>
                        </li> ";
                } else {
                    $menuItems .= "
                        <li class='nav-item'>
                            <a class='nav-link selectable $status' onclick='changeModule($row->id);'><span class='$row->icona'></span>&nbsp;&nbsp;&nbsp;$row->nome</a>
                        </li> ";
                }
           }
        }

        $buff = "
        <nav class='nav-bar navbar navbar-expand-sm navbar-dark bg-primary sticky-top'>
            <div class='container-fluid'>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarColor02' aria-controls='navbarColor02' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarColor02'>
                    <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                    " . $firstItem . $menuItems . "
                    </ul>
                </div>
                <div class='navbar-collapse collapse w-100 order-3 dual-collapse2'>
                <ul class='navbar-nav ml-auto'>
                " . $adminItems . "
                    <li class='nav-item'>
                            <a class='nav-link active selectable' onclick='logout();'><i class='bi bi-box-arrow-right'>&nbsp;</i>Logout</a>
                    </li>
                </ul>
                </div>
            </div>
      </nav>";

        return $buff;
    }

    /**
     * loadLogin()     Carica il modulo di login 
     * 
     * @return array        array contenente gli script da caricare 
     */
    static function loadLogin(){
        $ret = self::loadModule(0);
        return $ret; 
    }
}