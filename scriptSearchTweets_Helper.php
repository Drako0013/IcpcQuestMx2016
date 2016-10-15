<?php

class ST_Helper{

	//El hashtag array solo tiene como llave el hashtag y como dato el id del challenge
	public static function transformToHashtagArray($challenges){
		$hashtags = array();
		foreach($challenges as $challenge){
			$hashtags[$challenge["hashtag"]] = $challenge["id"];
		}
		return $hashtags;
	}

	public static function transformToTwitterUserArray($contestants){
		$users = array();
		foreach ($contestants as $contestant) {
			$users[$contestant["twitter_name"]] = $contestant["id"];
		}
		return $users;
	}

}

?>