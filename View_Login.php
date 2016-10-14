<?php
require_once("header.php");
require_once("Status_Codes.php");
require_once("Error_Codes.php");
require_once("Validation_Utility.php");

if($sessionActive){
    header("location: index.php");
    exit;
} else {

}
$errorCode = ValidationUtility::getErrorCode();
?>

<header id="header" class="header-register">
            <h1><i class="fa fa-user-plus" aria-hidden="true"></i> Iniciar sesión</h1>
        </header>
        <div id="content">
            <?php
                if($errorCode == "U_missingInformation" or $errorCode == "DB_Failure" or $errorCode == "U_loginFailure"){
                    echo constant($errorCode);
                }
            ?>
            <form class="pure-form pure-form-aligned" action="Core_ValidateLogin.php" method="POST">
                <fieldset>
                    <div class="pure-control-group">
                        <label for="twitter_name">Nombre de usuario en Twitter: @</label>
                        <input type="text" name="twitter_name" maxlength="15" required/>
                        <?php 
                            if( $errorCode == "U_twitterName" or $errorCode == "U_twitterNameLength" ){
                                echo constant($errorCode);
                            }
                        ?>
                    </div>
                    <div class="pure-control-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" name="password" maxlength="20" required pattern=".{6,}" title="Mínimo 6 caracteres" /> <br/>
                        <?php
                            if( $errorCode == "U_passwordLength" ){
                                echo constant($errorCode);
                            }
                        ?>
                    </div>
                    <div class="pure-controls">
                        <button type="submit" class="pure-button pure-button-primary">Iniciar sesión</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <footer>
            Un pie de página
        </footer>
    </body>
</html>