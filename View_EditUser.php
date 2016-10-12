<?php
require_once("DB_Manager.php");
require_once("Validation_Utility.php");

$sessionActive = ValidationUtility::sessionExists();
if( $sessionActive ){

	$id = (int)$_SESSION["id"];
	$db = new DBManager();
	$contestantInformation = $db->getContestantInformation($id);
	//print_r($contestantInformation);
	$twitter_name = $contestantInformation["twitter_name"];
	$name = $contestantInformation["name"];
	$school = $contestantInformation["school"];

	if( !(ValidationUtility::arrayIsEmpty($contestantInformation)) ){
?>
			<form class="pure-form pure-form-aligned" action="Core_EditUser.php" method="POST">
                <fieldset>
                    <div class="pure-control-group">
                        <label for="twitter_name">Nombre de usuario en Twitter: @</label>
                        <input type="text" name="twitter_name" value="<?php echo $twitter_name;?>" maxlength="15" required/>
                    </div>
                    <div class="pure-control-group">
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" value="<?php echo $name;?>" maxlength="50" required/>
                    </div>

                    <div class="pure-control-group">
                        <label for="school">Escuela:</label>
                        <input type="text" name="school" value="<?php echo $school;?>" maxlength="50" required/>
                    </div>

                    <div class="pure-control-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" name="password" maxlength="20" required pattern=".{6,}" title="Mínimo 6 caracteres" /> <br/>
                    </div>
                    <div class="pure-control-group">
                        <label for="password">Nueva contraseña:</label>
                        <input type="password" name="new_password" maxlength="20" pattern=".{0}|.{6,}" title="Mínimo 6 caracteres" /> <br/>
                    </div>
                    <div class="pure-control-group">
                        <label for="password">Confirmar nueva contraseña:</label>
                        <input type="password" name="new_password_check" maxlength="20" pattern=".{0}|.{6,}" title="Mínimo 6 caracteres" /> <br/>
                    </div>

                    <div class="pure-controls">
                        <button type="submit" class="pure-button pure-button-primary">Registrarse</button>
                    </div>
                </fieldset>
            </form>
<?php
	} else {
		header("location: index.php");
	}
} else {
	header("location: index.php");
}
?>