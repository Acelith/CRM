<?php

/**
 * login.php: Pagina di login
 *
 * @author Joël Moix  
 */

$msg = "";
# Controllo se c'è un parametro di errore nel GET
if (isset($_GET['err'])) {
	$cmd = $_GET['err'];
	$class = "error_login";
	switch ($cmd) {
		case "wrpwd":
			$msg = "<div class='$class'>
						Password o email errati
					</div>";
			break;

		case "err":
			$msg = "<div class='$class'>
					Errore, riprovare più tardi
				</div>";
			break;
		case "noauth":
			$msg = "<div class='$class'>
						Non hai accesso a questa risorsa 
					</div>";
			break;
	}
}
?>
<div class="login">
	<h1>Login</h1>
	<div class="img_login_he">
		<img class="img_login" src="/img/<?php echo impostazioni::getSetting("immagine_azienda") ?>">
	</div>
	<form>
		<label for="email">
			<i class="fas fa-user"></i>
		</label>
		<input type="text" name="email" placeholder="Email" id="email">
		<label for="password">
			<i class="fas fa-lock"></i>
		</label>
		<input type="password" name="password" placeholder="Password" id="password">
		<?php echo $msg ?>
		<input id="loginBtn" onclick="login();" value="Login">
	</form>
</div>