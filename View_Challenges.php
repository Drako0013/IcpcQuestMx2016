<?php
require_once("header.php");
?>
        <header id="header" class="header-challenge">
            <h1><i class="fa fa-flag" aria-hidden="true"></i> Retos</h1>
        </header>
        <div id="content">
            <p>
                Inserte texto genérico para incentivar participantes aquí.
            </p>
            <table class="scoreboard pure-table pure-table-horizontal pure-table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reto</th>
                        <th class="hidden-sm">Descripción</th>
                        <th class="scoreboard-completed hidden-sm">Hashtag</th>
                        <th class="scoreboard-points">Puntos</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $db = new DBManager();
                    if( $sessionActive ){
                        $contestant_id = (int)$_SESSION["id"];
                        $unsolvedChallenges = $db->getUnsolvedChallenges($contestant_id);
                        if(!ValidationUtility::arrayIsEmpty($unsolvedChallenges)){
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
                        } else {
                            echo 'Eres un campeón, no hay más retos que puedas resolver por el momento.';
                        }
                    } else {
                        $allChallenges = $db->getChallengesList();
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
                    }
                ?>
                </tbody>
            </table>

            <?php 
            if($sessionActive){ 
                $contestant_id = (int)$_SESSION["id"];
                $solvedChallenges = $db->getSolvedChallenges($contestant_id);
                echo '<h3>Retos resueltos</h3>';
                if(!ValidationUtility::arrayIsEmpty($solvedChallenges)){
            ?>
                <table class="scoreboard pure-table pure-table-horizontal pure-table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Reto</th>
                            <th class="hidden-sm">Descripción</th>
                            <th class="scoreboard-completed hidden-sm">Hashtag</th>
                            <th class="scoreboard-points">Puntos</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
<<<<<<< Updated upstream
                        $contestant_id = (int)$_SESSION["id"];
                        $solvedChallenges = $db->getSolvedChallenges($contestant_id);
                        if(!ValidationUtility::arrayIsEmpty($solvedChallenges)){
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
                        } else {
                            echo 'Todavia no has resuelto algún reto';
=======
                        $index = 1;
                        foreach($solvedChallenges as $challenge){
                            echo '<tr>';
                            echo '<td class="scoreboard-place">#'.$index.'</td>';
                            echo '<td><a href="View_ChallengeDetails.php?id='.$challenge["id"].'">'.$challenge["name"].'</a></td>';
                            echo '<td>'.$challenge["description"].'</td>';
                            echo '<td  class="scoreboard-completed hidden-sm">#'.$challenge["hashtag"].'</td>';
                            echo '<td class="scoreboard-points">'.$challenge["score"].'</td>';
                            echo '</tr>';
                            $index++; 
>>>>>>> Stashed changes
                        } 
                ?>
                    </tbody>
                </table>
            <?php 
                } else {
                    echo 'Todavia no has resuelto algún reto';
                } 
            }
            ?>


        </div>
        <footer>
            Un pie de página
        </footer>
    </body>
</html>