<?php
require_once("header.php");
require_once("Status_Codes.php");
define("ChallengesNumber", 5);
$db = new DBManager();
$challengesList = $db->getLastNChallenges(constant("ChallengesNumber"));  
?>
        <header id="header" class="header-home">
            <h1> Inicio</h1>
        </header>
        <div id="content">
            <p>
                <?php 
                    $statusCode = ValidationUtility::getStatusCode();
                    if ( !empty($statusCode) ){
                        echo constant($statusCode);
                    }
                ?>
            </p>
            <?php if (!$sessionActive): ?>
            <p>
                Para poder participar, deberás <a href="View_Register.php"><i class="fa fa-user-plus"></i> regístrate</a> primero.
                Si ya lo hiciste, puedes ver tus intentos
                <a href="View_Login.php"><i class="fa fa-sign-in"></i> iniciando sesión</a>.
            </p>
            <?php endif; ?>

            <h2>¿Cómo participar?</h2>
            <p>
            	Para poder completar los retos debes subir un tweet con el hashtag #HuronQuest además de los hashtags de los
            	retos que quieras completar, si cumples con los requisitos del reto entonces los administradores validarán
            	tu tweet y obtendrás los puntos de los retos. Ganará el concursante que tenga la mayor cantidad de puntos 
            	al final del concurso.
            </p>

            <div id="flex-container">
                <div class="flex-element">
                    <h2>Nuevos Retos</h2>
                    <div class="challenge-list">
                        <?php
                            foreach ($challengesList as $challenge) {
                                $challengeId = $challenge["id"];
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
                                            <a href="View_ChallengeDetails.php?id='.$challengeId.'">Ver reto</a>
                                        </div>
                                    </div>';
                            }
                        ?>
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
        <?php include_once("footer.php");?>
    </body>
</html>