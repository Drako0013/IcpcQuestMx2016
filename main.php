<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('TAE.php');
require_once('DB_Manager.php');

$db = new DBManager();
//$db->addNewContestant('1111', 'hola', 'mundo', 'psw');
//$db->addNewChallenge('Challenge 1', 'Challenge de prueba', 'un hashtag', 1);
//$db->addNewChallengeCompletionTry(1, 1, "123456");
//$db->editContestantInformation(1, '  Twitter ID', 'Batman', 'ESCOM', 'psw');
//$db->acceptChallengeCompletion(1);
//$db->unacceptChallengeCompletion(2);
//$db->editChallengeInformation(1, 'Challenge chido', 'Este es un challenge chido', 'dos hashtag', 2);
//$db->deleteChallenge(4);
//$table = $db->getChallengesList();
/*
foreach($table as $row){
	print_r($row);
}
*/
$table = $db->getChallengeInfomation(1);
print_r($table);
$table = $db->getContestantInformation(1);
print_r($table);

$table = $db->getChallengesTriedFromUser(1);
foreach($table as $row){
	print_r($row);
}


/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
'oauth_access_token' => "159271907-kNHqlJjxZ1s42pGiSpjLl3afV287v3QmB16Fvg1w",
'oauth_access_token_secret' => "y9C4xMPeVICPkVbWuaWoaWo0PE5hRY4W8AdyW0Gx0NOfc",
'consumer_key' => "PCLDeWkX6G3n4d6WiVqLCR0sq",
'consumer_secret' => "O5n9al7V3Rt59kKgtIxJCC3Yimhx1ljtD3tA4dLlHxPCm3k55b"
);
$url = "https://api.twitter.com/1.1/search/tweets.json";
$requestMethod = "GET";
$hashtag = "%23hashtagDePrueba";
$count = 10;
$getfield = "?q=$hashtag&count=$count";
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
/*
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
*/
$statuses = $string['statuses'];
$i = 0;
foreach ($statuses as $status) {
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
}
/*
foreach($string as $items)
{
echo "Time and Date of Tweet: ".$items['created_at']."<br />";
echo "Tweet: ". $items['text']."<br />";
echo "Tweeted by: ". $items['user']['name']."<br />";
echo "Followers: ". $items['user']['followers_count']."<br />";
echo "Friends: ". $items['user']['friends_count']."<br />";
echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
}
*/
?>