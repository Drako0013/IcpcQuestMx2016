<?php
$sessionActive = false;
if(session_id()){
    session_start();
    $sessionActive = true;
    header("location index.php");
} else {

}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ICPC Quest Mexico</title>
        <script
            src="https://code.jquery.com/jquery-3.1.0.min.js"
            integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
            crossorigin="anonymous">
        </script>
        <!--<script src="./script/main.js"></script>-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i&subset=latin-ext" rel="stylesheet">
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
        <link rel="stylesheet" href="./style/main.css">
        <link rel="stylesheet" href="./style/font-awesome/css/font-awesome.min.css">
    </head>
    <body>
        <div id="home-menu" class="pure-menu pure-menu-horizontal pure-menu-fixed">
            <a class="pure-menu-heading" href="#">
                ICPC Quest Mexico
            </a>
            <nav id="home-menu-nav">
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <a href="#" class="pure-menu-link"><i class="fa fa-flag"></i> <span class="hidden-sm">Retos</span></a>
                    </li>
                </ul>
                <ul class="pure-menu-list">
                    <li class="pure-menu-item pure-menu-selected">
                        <a href="#" class="pure-menu-link"><i class="fa fa-table"></i> <span class="hidden-sm">Marcador</span></a>
                    </li>
                </ul>
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <a href="#" class="pure-menu-link"><i class="fa fa-user"></i> Usuario</a>
                    </li>
                </ul>
            </nav>
        </div>
        <header id="header" class="header-register">
            <h1><i class="fa fa-user-plus" aria-hidden="true"></i> Registro</h1>
        </header>
        <div id="content">
            <form class="pure-form pure-form-aligned" action="Core_RegisterUser.php" method="POST">
                <fieldset>
                    <div class="pure-control-group">
                        <label for="twitter_name">Nombre de usuario en Twitter: @</label>
                        <input type="text" name="twitter_name" maxlength="15" required/>
                    </div>
                    <div class="pure-control-group">
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" maxlength="50" required/>
                    </div>

                    <div class="pure-control-group">
                        <label for="school">Escuela:</label>
                        <input type="text" name="school" maxlength="50" required/>
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