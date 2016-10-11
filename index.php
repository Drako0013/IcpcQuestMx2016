<?php
session_start();
$sessionActive = isset($_SESSION["id"]);

require_once('DB_Manager.php');

define("ChallengesNumber", 5);

$db = new DBManager();
$challengesList = $db->getLastNChallenges(constant("ChallengesNumber"));  
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
                    <li class="pure-menu-item">
                        <a href="#" class="pure-menu-link"><i class="fa fa-table"></i> <span class="hidden-sm">Marcador</span></a>
                    </li>
                </ul>
                <?php if ($sessionActive): ?>
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <?php
                            echo '<a href="View_EditUserInformation.php?id='.$_SESSION["id"].'" class="pure-menu-link"><i class="fa fa-user"></i>';
                            echo $_SESSION["twitter_name"];
                            echo '</a>';
                        ?>
                    </li>
                </ul>
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <a href="#" class="pure-menu-link"><i class="fa fa-sign-out"></i> <span class="hidden-sm">Salir</span></a>
                    </li>
                </ul>
                <?php else: ?>
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <a href="View_Login.php" class="pure-menu-link"><i class="fa fa-sign-in"></i> <span class="hidden-sm">Entrar</span></a>
                    </li>
                </ul>
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <a href="#" class="pure-menu-link"><i class="fa fa-user-plus"></i> <span class="hidden-sm">Registro</span></a>
                    </li>
                </ul>
                <?php endif; ?>
            </nav>
        </div>
        <header id="header" class="header-home">
            <h1> Inicio</h1>
        </header>
        <div id="content">
            <p>
                Texto introductorio.
            </p>
            <?php if (!$sessionActive): ?>
            <p>
                Para poder participar, deberás <a href="#"><i class="fa fa-user-plus"></i> regístrate</a> primero.
                Si ya lo hiciste, puedes ver tus intentos
                <a href="View_Login.php"><i class="fa fa-sign-in"></i> iniciando sesión</a>.
            </p>
            <?php endif; ?>
            <div id="flex-container">
                <div class="flex-element">
                    <h2>Nuevos Retos</h2>
                    <div class="challenge-list">
                        <?php
                            foreach ($challengesList as $challenge) {
                                $challengeName = $challenge["name"];
                                $challengeHashtag = $challenge["hashtag"];
                                $challengeDescription = $challenge["description"];
                                echo '
                                    <div class="challenge-list-element">
                                        <div class="challenge-list-element-header">
                                            <h3 class="challenge-list-element-name">'.$challengeName.'</h3>
                                            <div class="challenge-list-element-hashtag">#'.$challengeHashtag.'</div>
                                        </div>
                                        <div class="challenge-list-element-description">'.$challengeDescription.'</div>
                                        <div class="challenge-list-element-more">
                                            <a href="#">Ver reto</a>
                                        </div>
                                    </div>';
                            }
                        ?>
                        <div class="challenge-list-element">
                            <div class="challenge-list-element-header">
                                <h3 class="challenge-list-element-name">
                                    Mi amuleto
                                </h3>
                                <div class="challenge-list-element-hashtag">
                                    #Quest16Amuleto
                                </div>
                            </div>
                            <div class="challenge-list-element-description">
                                Foto de un amuleto AYUDA MEDINU SOY MALO CON LOS TEXTOS :&lt;
                            </div>
                            <div class="challenge-list-element-more">
                                <a href="#">Ver reto</a>
                            </div>
                        </div>
                        <div class="challenge-list-element">
                            <div class="challenge-list-element-header">
                                <h3 class="challenge-list-element-name">
                                    Color a ferret
                                </h3>
                                <div class="challenge-list-element-hashtag">
                                    #Quest16Color
                                </div>
                            </div>
                            <div class="challenge-list-element-description">
                                Como colorear un dinosaurio, pero más shido. :3
                            </div>
                            <div class="challenge-list-element-more">
                                <a href="#">Ver reto</a>
                            </div>
                        </div>
                        <div class="challenge-list-more">
                            <a href="#">+ Ver más</a>
                        </div>
                    </div>
                </div>
                <div class="timeline-container">
                    <h2>
                        Reciente | <a href="https://twitter.com/hashtag/ICPC2016">#ICPC2016</a>
                    </h2>
                    <a
                        class="twitter-timeline"
                        href="https://twitter.com/hashtag/ICPC2016"
                        data-dnt="true"
                        data-widget-id="785553558712098817"
                        data-tweet-limit="5"
                        data-lang="es"
                        data-chrome="noheader"
                        data-aria-polite="assertive">
                        <i class="fa fa-twitter"></i> #ICPC2016
                    </a>
                    <script>
                        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
                    </script>
                </div>
            </div>
        </div>
        <footer>
            Un pie de página
        </footer>
    </body>
</html>