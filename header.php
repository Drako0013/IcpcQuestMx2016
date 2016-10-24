<?php
require_once("Validation_Utility.php");
require_once("DB_Manager.php");
require_once("Error_Codes.php");

$sessionActive = ValidationUtility::sessionExists();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Huron Quest</title>
        <script
            src="https://code.jquery.com/jquery-3.1.0.min.js"
            integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
            crossorigin="anonymous">
        </script>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        <!--<script src="./script/main.js"></script>-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i&subset=latin-ext" rel="stylesheet">
        <link rel="stylesheet" href="./style/pure/pure-min.css">
        <link rel="stylesheet" href="./style/pure/grids-responsive-min.css">
        <link rel="stylesheet" href="./style/main.css">
        <link rel="stylesheet" href="./style/font-awesome/css/font-awesome.min.css">
       <script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
    </head>
    <body>
        <div id="home-menu" class="pure-menu pure-menu-horizontal pure-menu-fixed">
            <a class="pure-menu-heading" href="./">
                ICPC Quest Mexico
            </a>
            <nav id="home-menu-nav">
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <a href="View_Challenges.php" class="pure-menu-link"><i class="fa fa-flag"></i> <span class="hidden-sm">Retos</span></a>
                    </li>
                </ul>
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <a href="View_Scoreboard.php" class="pure-menu-link"><i class="fa fa-table"></i> <span class="hidden-sm">Marcador</span></a>
                    </li>
                </ul>
                <?php if ($sessionActive): ?>

                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <?php
                            echo '<a href="View_EditUser.php" class="pure-menu-link"><i class="fa fa-user"></i>';
                            echo $_SESSION["twitter_name"];
                            echo '</a>';
                        ?>
                    </li>
                </ul>
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <a href="Core_Logout.php" class="pure-menu-link"><i class="fa fa-sign-out"></i> <span class="hidden-sm">Salir</span></a>
                    </li>
                </ul>

                <?php else: ?>
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <a href="View_Register.php" class="pure-menu-link"><i class="fa fa-user-plus"></i> <span class="hidden-sm">Registro</span></a>
                    </li>
                </ul>
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <a href="View_Login.php" class="pure-menu-link"><i class="fa fa-sign-in"></i> <span class="hidden-sm">Entrar</span></a>
                    </li>
                </ul>

                <?php endif; ?>
            </nav>
        </div>