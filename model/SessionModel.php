<?php

class SessionModel
{
	public $pdo;

	public $queries = [];
	
	function __construct(PDO $pdo)
	{
		$this->pdo = $pdo; 

	}

	public function migrate()
	{
		foreach ($this->queries as  $sql) {
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
		}
	}

	public function sessions($table = 'sessions')
	{
		$this->queries[] = "CREATE TABLE ".$table." (
			sid VARCHAR(40)  PRIMARY KEY,
			expiry INT(10) UNSIGNED NOT NULL,
			data TEXT NOT NULL
		)";

		return $this;
	}

	public function autologin($table = 'autologin')
	{
		$this->queries[] = "CREATE TABLE ".$table." (
			user_key VARCHAR(8)  NOT NULL,
			token VARCHAR(32)  NOT NULL,
			data TEXT NOT NULL,
			expiry INT(10) UNSIGNED NOT NULL,
			used  BOOLEAN DEFAULT 0,
			created_at TIMESTAMP,
			CONSTRAINT PRIMARY KEY (user_key,token)
		)";

		return $this;
	}

	public function users($table = 'users')
	{
		$this->queries[] = "CREATE TABLE ".$table." (
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			user_key VARCHAR(8)  NOT NULL  UNIQUE,
			username VARCHAR(255)  NOT NULL UNIQUE,
			password VARCHAR(128)  NOT NULL
		)";

		return $this;
	}

	public function rollback(array $tables = [])
	{
		foreach ($tables as $table) {
			$stmt = $this->pdo->prepare("DROP TABLE ".$table."");
			$stmt->execute();
		}
	}
}