<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Registro</title>
	</head>
	<body>
		<form action="Core_RegisterUser.php" method="POST">
			Nombre de usuario en Twitter: @<input type="text" name="twitter_name" maxlength="15" required/> <br/>
			Nombre: <input type="text" name="name" maxlength="50" required/> <br/>
			Escuela: <input type="text" name="school" maxlength="50" required/><br/>
			Contraseña: <input type="password" name="password" maxlength="20" required pattern=".{6,}" /> <br/>
			<input type="submit" value="Registrar" >
		</form>
	</body>

</html>