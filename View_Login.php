<?php
require_once("header.php");

if($sessionActive){
    header("location: index.php");
} else {

}
?>

<header id="header" class="header-register">
            <h1><i class="fa fa-user-plus" aria-hidden="true"></i> Iniciar sesión</h1>
        </header>
        <div id="content">
            <form class="pure-form pure-form-aligned" action="Core_ValidateLogin.php" method="POST">
                <fieldset>
                    <div class="pure-control-group">
                        <label for="twitter_name">Nombre de usuario en Twitter: @</label>
                        <input type="text" name="twitter_name" maxlength="15" required/>
                    </div>
                    <div class="pure-control-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" name="password" maxlength="20" required pattern=".{6,}" title="Mínimo 6 caracteres" /> <br/>
                    </div>
                    <div class="pure-controls">
                        <button type="submit" class="pure-button pure-button-primary">Registrarse</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <footer>
            Un pie de página
        </footer>
    </body>
</html>