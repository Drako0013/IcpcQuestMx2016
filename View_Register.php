<?php
require_once("header.php");
require_once("Error_Codes.php");
require_once("Status_Codes.php");

if($sessionActive){
    header("location: index.php");
} else {
}
$errorCode = ValidationUtility::getErrorCode();
?>
        <header id="header" class="header-register">
            <h1><i class="fa fa-user-plus" aria-hidden="true"></i> Registro</h1>
        </header>
        <div id="content">
            <?php
                if($errorCode == "U_missingInformation" or $errorCode == "DB_Failure" or $errorCode == "Recaptcha_Failure"){
                    echo constant($errorCode);
                }
            ?>
            <form class="pure-form pure-form-aligned" action="Core_RegisterUser.php" method="POST" accept-charset="utf-8">
                <fieldset>
                    <div class="pure-control-group">
                        <label for="twitter_name">Nombre de usuario en Twitter: @</label>
                        <input type="text" name="twitter_name" maxlength="15" required/>
                        <?php
                            if( $errorCode == "U_twitterName" or 
                                $errorCode == "U_twitterNameLength" or 
                                $errorCode == "U_twitterNameNotExists"){
                                echo constant($errorCode);
                            }
                        ?>
                    </div>
                    <div class="pure-control-group">
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" maxlength="50" required/>
                        <?php
                            if( $errorCode == "U_name" or $errorCode == "U_nameLength" ){
                                echo constant($errorCode);
                            }
                        ?>
                    </div>

                    <div class="pure-control-group">
                        <label for="school">Escuela:</label>
                        <input type="text" name="school" maxlength="50" required/>
                        <?php
                            if( $errorCode == "U_school" or $errorCode == "U_schoolLength" ){
                                echo constant($errorCode);
                            }
                        ?>
                    </div>

                    <div class="pure-control-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" name="password" maxlength="20" required pattern=".{6,}" title="Mínimo 6 caracteres" /> <br/>
                        <?php
                            if( $errorCode == "U_passwordLength" or $errorCode == "U_passwordNotMatch" ){
                                echo constant($errorCode);
                            }
                        ?>
                    </div>
                    <div class="pure-control-group">
                        <label for="password_check">Reingresa tu contraseña:</label>
                        <input type="password" name="password_check" maxlength="20" required pattern=".{6,}" title="Mínimo 6 caracteres" /> <br/>
                    </div>

                    <div class="pure-control-group">
                        <div class="g-recaptcha" data-sitekey="6LfIhAkUAAAAAMCCOb6NOQaWw99T960Xegqyn70E"></div>
                    </div>

                    <div class="pure-controls">
                        <button type="submit" class="pure-button pure-button-primary">Registrarse</button>
                    </div>
                </fieldset>
            </form>
        </div>
<?php
include "footer.php";
?>