CREATE DATABASE IcpcQuest;
USE IcpcQuest;
CREATE TABLE Contestant(
	id INTEGER PRIMARY KEY AUTO_INCREMENT UNIQUE NOT NULL,
	twitter_id VARCHAR (15),
	twitter_name VARCHAR(15) UNIQUE,
	name VARCHAR(40),
	school VARCHAR(50),
	password VARCHAR(64) 
);

CREATE TABLE Challenge(
	id INTEGER PRIMARY KEY AUTO_INCREMENT UNIQUE NOT NULL,
	name VARCHAR(50),
	description VARCHAR(2000),
	hashtag VARCHAR(40),
	score INTEGER
);

CREATE TABLE ContestantChallengeCompletion(
	id INTEGER PRIMARY KEY AUTO_INCREMENT UNIQUE NOT NULL,
	contestant_id INTEGER NOT NULL,
	FOREIGN KEY(contestant_id) REFERENCES Contestant(id),
	challenge_id INTEGER NOT NULL,
	FOREIGN KEY(challenge_id) REFERENCES Challenge(id),
	tweet_id VARCHAR(40) NOT NULL,
	state SMALLINT NOT NULL DEFAULT 0
);

<<<<<<< Updated upstream
ALTER DATABASE IcpcQuest CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE Contestant CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE Challenge CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE ContestantChallengeCompletion CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
=======
ALTER DATABASE IcpcQuest CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE Contestant CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE Challenge CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE ContestantChallengeCompletion CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
>>>>>>> Stashed changes
