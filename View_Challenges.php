<?php
session_start();
require_once("header.php");
require_once("Validation_Utility.php");
require_once("DB_Manager.php");

$db = new DBManager();
if($sessionActive){
    $contestant_id = (int)$_SESSION["id"];
    $unsolvedChallenges = $db->getUnsolvedChallenges($contestant_id);
    $solvedChallenges = $db->getSolvedChallenges($contestant_id);
} else {
    $allChallenges = $db->getChallengesList();
}
unset($db);
$table_header = '<table class="scoreboard pure-table pure-table-horizontal pure-table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Reto</th>
                            <th class="hidden-sm">Descripción</th>
                            <th class="scoreboard-completed hidden-sm">Hashtag</th>
                            <th class="scoreboard-points">Puntos</th>
                        </tr>
                    </thead>
                    <tbody>';
$table_footer = '</tbody></table>';
?>
        <header id="header" class="header-challenge">
            <h1><i class="fa fa-flag" aria-hidden="true"></i> Retos</h1>
        </header>
        <div id="content">
            <p>
                Completa retos, twittealos, y gana posiblememnte inexistentes premios :D.
            </p>

            <?php
                if($sessionActive){
                    if(ValidationUtility::arrayIsEmpty($unsolvedChallenges)){
                        echo '<h3>Eres un campeón, no hay más retos que puedas resolver por el momento.</h3>';
                    } else {
                        echo '<h3>Tus retos no completados</h3>';
                        echo $table_header;
                        $index = 1;
                        foreach($unsolvedChallenges as $challenge){
                            echo '<tr>';
                            echo '<td class="scoreboard-place">#'.$index.'</td>';
                            echo '<td><a href="View_ChallengeDetails.php?id='.$challenge["id"].'">'.$challenge["name"].'</a></td>';
                            echo '<td class="hidden-sm">'.$challenge["description"].'</td>';
                            echo '<td class="scoreboard-completed hidden-sm">#'.$challenge["hashtag"].'</td>';
                            echo '<td class="scoreboard-points">'.$challenge["score"].'</td>';
                            echo '</tr>';
                            $index++; 
                        }
                        echo $table_footer;
                    }
                    if(ValidationUtility::arrayIsEmpty($solvedChallenges)){
                        echo '<h3>No has completado algún reto aún :(</h3>';
                    } else {
                        echo '<h3>Tus retos completados</h3>';
                        echo $table_header;
                        $index = 1;
                        foreach($solvedChallenges as $challenge){
                            echo '<tr>';
                            echo '<td class="scoreboard-place">#'.$index.'</td>';
                            echo '<td><a href="View_ChallengeDetails.php?id='.$challenge["id"].'">'.$challenge["name"].'</a></td>';
                            echo '<td class="hidden-sm">'.$challenge["description"].'</td>';
                            echo '<td class="scoreboard-completed hidden-sm">#'.$challenge["hashtag"].'</td>';
                            echo '<td class="scoreboard-points">'.$challenge["score"].'</td>';
                            echo '</tr>';
                            $index++; 
                        }
                        echo $table_footer;
                    }
                } else {
                    //Session not exists, show all challenges
                    echo '<h3>Retos</h3>';
                    echo $table_header;
                    $index = 1;
                    foreach($allChallenges as $challenge){
                        echo '<tr>';
                        echo '<td class="scoreboard-place">#'.$index.'</td>';
                        echo '<td><a href="View_ChallengeDetails.php?id='.$challenge["id"].'">'.$challenge["name"].'</a></td>';
                        echo '<td class="hidden-sm">'.$challenge["description"].'</td>';
                        echo '<td class="scoreboard-completed hidden-sm">#'.$challenge["hashtag"].'</td>';
                        echo '<td class="scoreboard-points">'.$challenge["score"].'</td>';
                        echo '</tr>';
                        $index++; 
                    }
                    echo $table_footer;
                }
            ?>
        </div>
        <footer>
            Un pie de página
        </footer>
    </body>
</html>