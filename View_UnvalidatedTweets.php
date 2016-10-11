<?php

require_once("DB_Manager.php");

$db = new DBManager();
$tweets = $db->getUnvalidatedTweetsList();
?>

<table>
	<?php
		foreach ($tweets as $tweet) {
			echo '<tr>';
			echo '<td> <a href="http://www.twitter.com/statuses/'.$tweet["tweet_id"].'">Tweet</a>';
			echo '<td> <a href="Core_ValidateTweet.php?id='.$tweet["id"].'&result=yes">Valido</a>';
			echo '<td> <a href="Core_ValidateTweet.php?id='.$tweet["id"].'&result=no">No valido</a>';
			echo '</tr>';
		}
	?>
</table>