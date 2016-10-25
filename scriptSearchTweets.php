<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("TAE.php");
require_once("DB_Manager.php");
require_once('API_Constants.php');
require_once("scriptSearchTweets_Helper.php");

define("waitTimeInSeconds", 120);
define("startingLastTweet", "786974048148258817");
define("maxTweetsPerSearch", 100);

$settings = array(
'oauth_access_token' => constant('twitter_oauth_access_token'),
'oauth_access_token_secret' => constant('twitter_oauth_access_token_secret'),
'consumer_key' => constant('twitter_consumer_key'),
'consumer_secret' => constant('twitter_consumer_secret')
);
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$requestMethod = "GET";

$hashtag = "%23" . constant("hashtagToSearch");
$count = constant("maxTweetsPerSearch");
$lastTweetId = constant("startingLastTweet");

$twitter = new TwitterAPIExchange($settings);

//$db = new DBManager();
//si no vamos a agregar challenges durante el concurso
$cycle = 1;

while( true ){
	echo $cycle . "\n"; 

	$db = new DBManager();

	$challengesList = $db->getChallengesList();
	$hashtagList = ST_Helper::transformToHashtagArray($challengesList);
	unset($challengesList);

	$contestantsList = $db->getContestantsList();
	$contestantsTwitterIDList = ST_Helper::transformToTwitterUserArray($contestantsList);

	//print_r($contestantsTwitterIDList);

	unset($contestantsList);

	$getfield = "?q=".$hashtag."&count=".$count."&since_id=".$lastTweetId;
	$string = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest(), $assoc = TRUE);
	/*
	if($string["errors"][0]["message"] !In this chapter we will teach you how to create and write to a file on the server.= "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
	*/
	$statuses = $string['statuses'];
	$i = 0;

	echo $string;

	foreach ($statuses as $status) {
		$knownUser = true;

		$twitterUserInfo = $status["user"];
		$twitterID = $twitterUserInfo["id_str"];
		if( !isset($contestantsTwitterIDList[$twitterID]) ){
			echo 'Usuario desconocido ' . $twitterID . "\n";
			$knownUser = false;
		}
		$tweetId = $status["id_str"];

		if( $knownUser ){
			$contestantId = $contestantsTwitterIDList[$twitterID];
			$tweetEntities = $status["entities"];
			$hashtagsInTweet = $tweetEntities["hashtags"];
			foreach($hashtagsInTweet as $hashtagInTweet){
				//print_r($hashtagInTweet);
				$hashtagText = $hashtagInTweet["text"];

				if( !isset($hashtagList[$hashtagText]) ){
					echo 'No hay reto con el hashtag ' . $hashtagText . "\n";
					continue;
				}
				$challengeId = $hashtagList[$hashtagText];

				echo 'Insertar intento para usuario ' . $contestantId . 
					' para el reto ' . $challengeId . ' con el tweet ' . $tweetId . "\n";
				$db->addNewChallengeCompletionTry($contestantId, $challengeId, $tweetId);
			}
		}

		$lastTweetId = max($lastTweetId, $tweetId);
		echo $lastTweetId . "\n";
	}
	unset($db);
	$cycle++;
	sleep(constant("waitTimeInSeconds"));
}

?>