
<form action="logica_AgregarRetillo.php" method="POST">
	Nombre: <input type="text" name="name" maxlength="50" required> <br />
	Descripcion: <textarea name="description" cols="100" rows="10" maxlength="2000" required> </textarea><br />
	Hashtag: #<input type="text" name="hashtag" maxlength="40" required> <br />
	Puntaje: <input type="number" name="score" required> <br />
	<input type="Submit" value="Agregar reto" />
</form>