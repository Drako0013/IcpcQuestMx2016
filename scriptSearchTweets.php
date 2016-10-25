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

$getfield = "?q=".$hashtag."&count=".$count."&since_id=".$lastTweetId;
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
	unset($contestantsList);

	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
	$string = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest(), $assoc = TRUE);
	/*
	if($string["errors"][0]["message"] !In this chapter we will teach you how to create and write to a file on the server.= "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
	*/
	$statuses = $string['statuses'];
	$i = 0;
	foreach ($statuses as $status) {
		$twitterUserInfo = $status["user"];
		$twitterID = $twitterUserInfo["id_str"];
		if( !isset($contestantsTwitterIDList[$twitterID]) ){
			echo 'Usuario desconocido ' . $twitterID . "\n";
			continue;
		}
		$contestantId = $contestantsTwitterIDList[$twitterID];
		
		$tweetId = $status["id_str"];

		$tweetEntities = $status["entities"];
		$hastagsInTweet = $tweetEntities["hashtags"];
		foreach($hashtagsInTweet as $hashtagInTweet){
			if( !isset($hashtagList[$hashtagInTweet]) ){
				echo 'No hay reto con el hashtag ' . $hashtagInTweet . "\n";
				continue;
			}
			$challengeId = $hashtagList[$hashtagInTweet];

			echo 'Insertar intento para usuario ' . $contestantId . 
				' para el reto ' . $challengeId . ' con el tweet ' . $tweetId . "\n";
			$db->addNewChallengeCompletionTry($contestantId, $challengeId, $tweetId);
		}

		$lastTweetId = max($lastTweetId, $tweetId);
		//print_r($status);
		/*
		echo $i++;
		echo "Created at: " . $status['created_at'] . "<br />";
		echo "Id: ". $status['user']['id_str']."<br />";
		echo "Screen name: ". $status['user']['screen_name']."<br />";
		echo "Text: " .$status['text']."<br />";
		foreach($status['entities']['hashtags'] as $hashtag_in_tweet){
			echo "----- ".$hashtag_in_tweet['text']."<br />";
		}
		foreach ($status['entities']['media'] as $image) {
			$image_url = $image['media_url'];
			echo "<img src='$image_url' /><br/>";
		}
		*/
	}
	unset($db);
	$cycle++;
	sleep(constant("waitTimeInSeconds"));
}

?>