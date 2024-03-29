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
class Module
{

    /**
     * Si occupa di chiamare il modulo di default
     * 
     * @return array        array contenente gli script da caricare 
     */
    static function loadDefault()
    {
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
    static function loadModule($p_moduleId)
    {

        $sqlStmt = "SELECT * FROM modulo where id=:id";

        $parArr = array(
            ":id" => $p_moduleId
        );

        $sth = DB::doQueryParam($sqlStmt, $parArr); 

        $module = $sth->fetch(PDO::FETCH_OBJ);
        $cartellaModulo = $module->cartella;
        if (!$module->abilitato) {
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
        if (isset($_SESSION['loggato'])) {
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
    static function getNavBar($p_moduleId = null)
    {
        $sqlStmt = "SELECT * FROM modulo where id<>0 order by id asc";

        $sth = DB::doQuery($sqlStmt); 

        # mi faccio ritornare il modulo di default
        $menuItems = "";
        $adminItems = "";
        $defaultModule = Impostazioni::getDefaultModule();

        while ($row = $sth->fetch(PDO::FETCH_OBJ)) {

            # Controllo su quale modulo l'utente si trova così lo "evidenzio" nella navbar
            if ($p_moduleId == $row->id) {
                $status = "loaded";
            } else {
                $status = "notloaded";
            }

            # Controllo se il modulo è abilitato
            if ($row->abilitato == 1) {
                if ($row->admin == 1) {
                    if (utente::isAdmin() == 0) {
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
    static function loadLogin()
    {
        $ret = self::loadModule(0);
        return $ret;
    }
}


/**
 * classe per il caricamento di sottomoduli
 */
class subModule
{

    private $module;

    function __construct($p_modulo)
    {
        $this->module = $p_modulo;
    }
    /**
     * loadSubMenu():   ritorna un submenu per la navigazione dei sottomoduli
     * 
     * @param   array   $p_elements     array di menu da inserire nella navigazione
     * @param   string  $p_module       nome del modulo "padre"
     * @param   string  $p_default      sotto modulo di default
     * 
     * @return array   ritorna il submenu con il file da caricare
     */
    function loadSubmenu($p_elements, $p_default)
    {
        $module = $this->module;
        $navbarMenu = "";
        $to_import = array();
        # Costruisco il menu della navbar
        foreach ($p_elements as $nome => $cartella) {
            $to_check = MODULE_PATH . $module . DIRECTORY_SEPARATOR . $cartella . DIRECTORY_SEPARATOR . $cartella . ".php";
            if (file_exists($to_check)) {
                $navbarMenu .= "<a class='nav-item nav-link selectable notloaded' id='$cartella' onclick='subMenu(\"$cartella\")'>$nome</a>";
                $to_import[$cartella] = $cartella;
            }
        }

        # Richiedo la navbar
        $navBar = subModule::getSubNavBar($navbarMenu);

        $modulo_to_load = "";
        # file da caricare nel caso il sottomodulo non venga trovato
        $default = $modulo_to_load = MODULE_PATH . $module . DIRECTORY_SEPARATOR . $p_default . DIRECTORY_SEPARATOR . $p_default . ".php";

        if (isset($_GET['submod'])) {
            if (key_exists($_GET['submod'], $to_import)) {
                $modulo_to_load = MODULE_PATH . $module . DIRECTORY_SEPARATOR . $_GET['submod'] . DIRECTORY_SEPARATOR . $_GET['submod'] . ".php";
            } else {
                $modulo_to_load = $default;
            }
        } else {
            $modulo_to_load = $default;
        }

        $ret = array(
            "subNav" => $navBar,
            "file" => $modulo_to_load
        );

        return $ret;
    }
    /**
     * getSubNavBar():   ritorna la navbar con il menu compilato
     *
     * @param   string  $nav_items     elementi da inserire nel menu
     * 
     * @return string   ritorna la navbar
     */
    static function getSubNavBar($p_nav_items)
    {
        $subNav = "<nav class='navbar navbar-expand-lg navbar-light bg-light sub-navbar'>
                        <div class='collapse navbar-collapse' id='navbarNavAltMarkup'>
                            <div class='navbar-nav'>
                               $p_nav_items 
                            </div>
                        </div>
                    </nav><br>";

        return $subNav;
    }
}
