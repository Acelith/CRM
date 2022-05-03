<?php
/**
 * admin.php: gestione delle componenti amministrative 
 *
 * @author Joël Moix  
 */

 if(!utente::isLogged()){
    die();
}

 ?>
        <nav class='navbar navbar-expand-lg navbar-dark bg-info'>
            <div class='container-fluid'>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarColor02' aria-controls='navbarColor02' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarColor02'>
                    <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                        <li>Utenti</li>
                    </ul>
                </div>
            </div>
      </nav>