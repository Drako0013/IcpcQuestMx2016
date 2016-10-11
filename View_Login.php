<?php
	if(session_id()){
		header("location: index.php");
	}
?>

<form method="POST" action="Core_ValidateLogin.php">
	Nombre de usuario en Twitter: @<input type="text" name="twitter_name" maxlength="15" /> <br/>
	Contraseña: <input type="password" name="password" maxlength="20" /> <br/>
	<input type="submit" value="Login" />
</form>