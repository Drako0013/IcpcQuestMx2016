<?php
require_once("header.php");
?>
        <header id="header" class="header-scoreboard">
            <h1><i class="fa fa-table" aria-hidden="true"></i> Marcador</h1>
        </header>
        <div id="content">
            <p>
                Premios y sorpresas le esperan a los ganadores del concurso, es muy fácil participar y mucho
                más juntar puntos. Además si completas ciertos retos puedes llevarte a casa souvenirs del concurso
                que no encontrarás en ningún otro lugar.
            </p>
            <table class="scoreboard pure-table pure-table-horizontal pure-table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Concursante</th>
                        <th class="hidden-sm">Escuela</th>
                        <th class="scoreboard-completed hidden-sm">Retos completados</th>
                        <th class="scoreboard-points">Puntos</th>
                    </tr>
                </thead>
                <?php
                    $db = new DBManager();
                    $leaderboard = $db->getLeaderboard();
                ?>
                <tbody>
                    <?php 
                        $index = 1;
                        foreach($leaderboard as $contestant){
                    ?>
                    <tr>
                        <td class="scoreboard-place">#<?php echo $index;?></td>
                        <td><a href="#">@<?php echo $contestant["twitter_name"]; ?></a></td>
                        <td class="hidden-sm"><?php echo $contestant["school"]; ?></td>
                        <td class="scoreboard-completed hidden-sm"> <?php echo $contestant["challenges_solved"]; ?> </td>
                        <td class="scoreboard-points"><?php echo $contestant["score_sum"]; ?></td>
                    </tr>
                    <?php
                            $index++; 
                        }
                    ?>
                </tbody>
            </table>
        </div>
<?php
include "footer.php";
?>