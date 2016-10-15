<?php
require_once("header.php");
require_once("TAE.php");

define("lastOwnTriesCount", 5);
define("lastTriesCount", 10);
define("Status_Unchecked", 0);
define("Status_NotAccepted", 1);
define("Status_Accepted", 2);

if($sessionActive){
	$contestant_id = (int)$_SESSION["id"];
}

if( isset($_GET["id"]) ){
	$id = (int)$_GET["id"];
	$db = new DBManager();
	$challengeInfo = $db->getChallengeInformation($id);

	$name = $challengeInfo["name"];
	$description = $challengeInfo["description"];
	$hashtag = $challengeInfo["hashtag"];
	$score = $challengeInfo["score"];

	$settings = array(
					'oauth_access_token' => "159271907-kNHqlJjxZ1s42pGiSpjLl3afV287v3QmB16Fvg1w",
					'oauth_access_token_secret' => "y9C4xMPeVICPkVbWuaWoaWo0PE5hRY4W8AdyW0Gx0NOfc",
					'consumer_key' => "PCLDeWkX6G3n4d6WiVqLCR0sq",
					'consumer_secret' => "O5n9al7V3Rt59kKgtIxJCC3Yimhx1ljtD3tA4dLlHxPCm3k55b"
					);
	$url = "https://api.twitter.com/1.1/statuses/oembed.json";
	$requestMethod = "GET";	
	$twitter = new TwitterAPIExchange($settings);
} else {
	header("location: index.php");
	exit;
}
?>
        <header id="header" class="header-challenge">
            <h1><i class="fa fa-flag" aria-hidden="true"></i> Retos</h1>
        </header>
        <div id="content">
            <p>
                Retos retos retos
            </p>
            <h2 class="challenge-title">
                <?php echo $name;?>
            </h2>
            <div class="challenge-hashtag">
                <div class="challenge-hashtag-line">#<?php echo $hashtag;?></div>
                <a
                    href="https://twitter.com/intent/tweet?button_hashtag=<?php echo $hashtag;?>"
                    class="twitter-hashtag-button"
                    data-lang="es"
                    data-show-count="false">
                    Tweet #<?php echo $hashtag;?>
                </a>
            </div>
            <?php
            	if($sessionActive){
            		if( $db->challengeWasSolvedByUser($contestant_id, $id) ){
            			echo '<div class="challenge-points challenge-points-accepted">';
            		} else {
            			echo '<div class="challenge-points">';
            		}
            	} else {
            		echo '<div class="challenge-points">';
            	}
            	echo $score . ' puntos';
            	echo '</div>;'
            ?>
            <p class="challenge-description">
            	<?php echo $description;?>
            </p>

            <?php 
            	if($sessionActive) {
            		echo '<h3>Tus intentos</h3>';
	            	$lastOwnTries  = $db->getLastNChallengeTriesFromUser($contestant_id, $id, constant("lastOwnTriesCount"));
	            	
	            	if( !ValidationUtility::arrayIsEmpty($lastOwnTries) ){
	            		echo '<div class="challenge-try-list">';
			            foreach ($lastOwnTries as $try) {
			            	$tweet_id = $try["tweet_id"];
			            	$state = $try["state"];
			            	$getfield = "?id=$tweet_id&align=center";
							$string = json_decode($twitter->setGetfield($getfield)
							->buildOauth($url, $requestMethod)
							->performRequest(),$assoc = TRUE);
							echo '<div class="challenge-try">';
							if( $state == constant("Status_Unchecked") ){
								echo '<div class="challenge-try-status challenge-try-status-pending">
	                        			<i class="fa fa-question-circle"></i> Pendiente...
	                    			</div>';
							} else {
								if( $state == constant("Status_NotAccepted") ){
									echo '<div class="challenge-try-status challenge-try-status-denied">
	                        				<i class="fa fa-times-circle"></i> Rechazado
	                    				</div>';
								} else {
									if( $state == constant("Status_Accepted") ){
										echo '<div class="challenge-try-status challenge-try-status-accepted">
		                        				<i class="fa fa-check-circle"></i> ¡Completado!
		                    				</div>';
									} else {
										//De fuq, no deberia llegar aqui
										echo 'Madre mia willy';
									}
								}
							}
							$htmlCodeTweet = $string["html"];
							echo $htmlCodeTweet;
							echo '</div>';
		            	}
			        	echo '</div>';
	            	} else {
	            		//No tiene intentos
	            		echo "<h3>No tienes intentos todavia</h3>";
	            	}
            	} else {
            		//Sesion no iniciada
            		echo '<h3>Debes iniciar sesión para ver tus intentos</h3>';
            	}
            ?>


            <?php
            	echo '<h3>Todos los intentos</h3>'; 
	            $lastTries  = $db->getLastNNonRejectedChallengeTries($id, constant("lastTriesCount"));
	            	
	            if( !ValidationUtility::arrayIsEmpty($lastTries) ){
	            	echo '<div class="challenge-try-list">';
			        foreach ($lastTries as $try) {
			        	$tweet_id = $try["tweet_id"];
			        	$state = $try["state"];
			            $getfield = "?id=$tweet_id&align=center";
						$string = json_decode($twitter->setGetfield($getfield)
						->buildOauth($url, $requestMethod)
						->performRequest(),$assoc = TRUE);
						echo '<div class="challenge-try">';
						if( $state == constant("Status_Unchecked") ){
							echo '<div class="challenge-try-status challenge-try-status-pending">
	                        		<i class="fa fa-question-circle"></i> Pendiente...
	                    		</div>';
						} else {
							if( $state == constant("Status_NotAccepted") ){
								echo '<div class="challenge-try-status challenge-try-status-denied">
	                        			<i class="fa fa-times-circle"></i> Rechazado
	                    			</div>';
							} else {
								if( $state == constant("Status_Accepted") ){
									echo '<div class="challenge-try-status challenge-try-status-accepted">
		                        			<i class="fa fa-check-circle"></i> ¡Completado!
		                    			</div>';
								} else {
									//De fuq, no deberia llegar aqui
									echo 'Madre mia willy';
								}
							}
						}
						$htmlCodeTweet = $string["html"];
						echo $htmlCodeTweet;
						echo '</div>';
		            }
			        echo '</div>';
	            } else {
	            	//No tiene intentos
	            	echo "<h3>Vaya, nadie ha intentado este reto, puedes ser el primero</h3>";
	            }
            ?>
        </div>
        <footer>
            Un pie de página
        </footer>
    </body>
</html>