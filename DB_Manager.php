<?php
/*
States for challenge completion:
0 - Unchecked
1 - Not Accepted
2 - Accepted
*/

define("servername", 'localhost');
define("username", 'root');
define("password", 'n0m3l0s3');
define("dbname", 'IcpcQuest');
define("State_Unchecked", 0);
define("State_NotAccepted", 1);
define("State_Accepted", 2);


class DBManager{
	
	private $conn;


	public function __construct(){
		$this->conn = new mysqli(constant("servername"), 
			constant("username"), 
			constant("password"), 
			constant("dbname"));
		if( mysqli_connect_errno() ){
			throw new Exception('Failed to connect to database: ' . mysqli_connect_errno() );
		}
	}

	public function __destruct(){
		$this->conn->close();
	}

	public function sanitizeString($string){
		$string = strip_tags($string);
		$string = htmlspecialchars($string);
		$string = trim(rtrim(ltrim($string)));
		return $string;
	}

	public function addNewContestant($twitter_id, $name, $school, $password){
		$twitter_id = $this->sanitizeString($twitter_id);
		$name = $this->sanitizeString($name);
		$school = $this->sanitizeString($school);
		$password = $this->sanitizeString($password);

		$query = "INSERT INTO Contestant(twitter_id, name, school, password) VALUES(?,?,?,?)";
		$statement = $this->conn->prepare($query);
		$statement->bind_param("ssss", 
			$twitter_id,
			$name,
			$school,
			$password);
		$statement->execute();
		$statement->close();
	}

	public function addNewChallenge($name, $description, $hashtag, $score){
		$name = $this->sanitizeString($name);
		$description = $this->sanitizeString($description);
		$hashtag = $this->sanitizeString($hashtag);
		
		$query = "INSERT INTO Challenge(name, description, hashtag, score) VALUES(?,?,?,?)";
		$statement = $this->conn->prepare($query);
		$statement->bind_param("sssi", 
			$name, 
			$description, 
			$hashtag, 
			$score);
		$statement->execute();
		$statement->close();		
	}

	public function addNewChallengeCompletionTry($contestant_id, $challenge_id, $tweet_id){
		$tweet_id = $this->sanitizeString($tweet_id);
		$state = constant("State_Unchecked");

		$query = "INSERT INTO ContestantChallengeCompletion(contestant_id, challenge_id, tweet_id, state) VALUES(?,?,?,?)";
		$statement = $this->conn->prepare($query);
		$statement->bind_param("iisi", 
			$contestant_id, 
			$challenge_id, 
			$tweet_id, 
			$state);
		$statement->execute();
		$statement->close();
	}

	public function editContestantInformation($id, $twitter_id, $name, $school, $password){
		$twitter_id = $this->sanitizeString($twitter_id);
		$name = $this->sanitizeString($name);
		$school = $this->sanitizeString($school);
		$password = $this->sanitizeString($password);
		
		$query = "UPDATE Contestant SET twitter_id = ?, name  = ?, school  = ?, password = ? WHERE id = ?";
		$statement = $this->conn->prepare($query);
		$statement->bind_param("ssssi", 
			$twitter_id, 
			$name, 
			$school, 
			$password,
			$id);
		$statement->execute();
		$statement->close();
	}

	public function acceptChallengeCompletion($id){
		$this->setStateChallengeCompletion($id, constant("State_Accepted"));
	}

	public function unacceptChallengeCompletion($id){
		$this->setStateChallengeCompletion($id, constant("State_NotAccepted"));
	}

	public function setStateChallengeCompletion($id, $state){
		$query = "UPDATE ContestantChallengeCompletion SET state = ? WHERE id = ?";
		$statement = $this->conn->prepare($query);
		$statement->bind_param("ii", 
			$state,
			$id);
		$statement->execute();
		$statement->close();
	}

	public function editChallengeInformation($id, $name, $description, $hashtag, $score){
		$name = $this->sanitizeString($name);
		$description = $this->sanitizeString($description);
		$hashtag = $this->sanitizeString($hashtag);

		$query = "UPDATE Challenge SET name = ?, description = ?, hashtag = ?, score = ? WHERE id = ?";
		$statement = $this->conn->prepare($query);
		$statement->bind_param("sssii", 
			$name, 
			$description, 
			$hashtag, 
			$score,
			$id);
		$statement->execute();
		$statement->close();
	}

	public function deleteChallenge($id){
		$query = "DELETE FROM Challenge WHERE id = ?";
		$statement = $this->conn->prepare($query);
		$statement->bind_param("i", $id);
		$statement->execute();
		$statement->close();
	}

	public function getChallengesList(){
		$query = "SELECT id, name, hashtag, score FROM Challenge";
		$index = 0;
		$resultSet = array();
		if ($result = $this->conn->query($query)) {
			while ($row = $result->fetch_row()) {
				$resultSet[$index] = array("id" => $row[0],
					"name" => $row[1],
					"hashtag" => $row[2],
					"score" => $row[3]);
				$index++;
			}
			$result->close();
		}
		return $resultSet;
	}

	public function getChallengeInfomation($id){
		$query = "SELECT * FROM Challenge WHERE id = ?";
		$statement = $this->conn->prepare($query);
		$statement->bind_param("i", $id);
		$statement->execute();
		$statement->bind_result($id, $name, $description, $hashtag, $score);

		$challenge = array();
		while ($statement->fetch()) {
			$challenge = array("id" => $id,
				"name" => $name,
				"description" => $description,
				"hashtag" => $hashtag,
				"score" => $score
				);
		}
		$statement->close();
		return $challenge;
	}

	public function getContestantInformation($id){
		$query = "SELECT id, twitter_id, twitter_name, name, school FROM Contestant WHERE id = ?";
		$statement = $this->conn->prepare($query);
		$statement->bind_param("i", $id);
		$statement->execute();
		$statement->bind_result($id, $twitter_id, $twitter_name, $name, $school);

		$contestant = array();
		while ($statement->fetch()) {
			$contestant = array("id" => $id,
				"twitter_id" => $twitter_id,
				"twitter_name" => $twitter_name,
				"name" => $name,
				"school" => $school,
				);
		}
		$statement->close();
		return $contestant;
	}

	public function getChallengesTriedFromUser($id){
		$query = "SELECT 
			ContestantChallengeCompletion.id, 
			ContestantChallengeCompletion.tweet_id, 
			ContestantChallengeCompletion.state, 
			Challenge.id, 
			Challenge.name, 
			Challenge.hashtag, 
			Challenge.score FROM Challenge JOIN ContestantChallengeCompletion ON ContestantChallengeCompletion.challenge_id = Challenge.id WHERE ContestantChallengeCompletion.contestant_id = ?";
		$statement = $this->conn->prepare($query);
		$statement->bind_param("i", $id);
		$statement->execute();
		$statement->bind_result($completion_id, 
			$completion_tweet_id, 
			$completion_state, 
			$challenge_id, 
			$challenge_name, 
			$challenge_hashtag,
			$challenge_score);

		$challegesTried = array();
		$index = 0;
		while ($statement->fetch()) {
			$challegesTried[$index] = array("completion_id" => $completion_id,
				"completion_twitter_id" => $completion_tweet_id,
				"completion_state" => $completion_state,
				"challenge_id" => $challenge_id,
				"challenge_name" => $challenge_name,
				"challenge_hashtag" => $challenge_hashtag,
				"challenge_score" => $challenge_score
				);
			$index++;
		}
		$statement->close();
		return $challegesTried;
	}

}


?>