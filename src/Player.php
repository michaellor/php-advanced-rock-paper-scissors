<?php
	 class Player
		{
            private $id;
			private $name;
			private $password;

			function __construct($name, $password, $id=NULL)
			{
				$this->name = $name;
				$this->password = $password;
				$this->id = $id;

			}

			function setName($name)
			{
				$this->name = $name;
			}

			function getName()
			{
				return $this->name;
			}

			function setPassword($password)
			{
				$this->password = $password;
			}

			function getPassword()
			{
				return $this->password;
			}

			function getId()
			{
				return $this->id;
			}

			function save()
			{
				$GLOBALS['DB']->exec("INSERT INTO players (name, password) VALUES ('{$this->getName()}', '{$this->getPassword()}');");
				$this->id = $GLOBALS['DB']->lastInsertId();
			}

			function getTotalGames()
			{
				$query = $GLOBALS['DB']->query("SELECT * FROM rounds WHERE player_one_id = {$this->getId()};");
				$rounds = $query->fetchAll(PDO::FETCH_ASSOC);
				$query = $GLOBALS['DB']->query("SELECT * FROM rounds WHERE player_two_id = {$this->getId()};");
				$rounds2 = $query->fetchAll(PDO::FETCH_ASSOC);
				return count($rounds) + count($rounds2);
			}

			function getTotalWins()
			{
				$query = $GLOBALS['DB']->query("SELECT * FROM rounds WHERE winner_id = {$this->getId()};");
				$wins = $query->fetchAll(PDO::FETCH_ASSOC);
				return count($wins);
			}

			static function getAll()
			{
				$returned_players = $GLOBALS['DB']->query("SELECT * FROM players;");
	            $players = array();
	            foreach($returned_players as $player) {
	                $name = $player['name'];
	                $password = $player['password'];
	                $id = $player['id'];
	                $new_player = new Player($name, $password, $id);
	                array_push($players, $new_player);
	            }
	            return $players;
			}

			static function findById($search_id)
			{
				$found_player = null;
				$players = Player::getAll();
				foreach($players as $player) {
					$player_id = $player->getId();
					if ($player_id == $search_id) {
					  $found_player = $player;
					}
				}
				return $found_player;
			}

			static function findByName($search_name)
			{
				$found_player = null;
				$players = Player::getAll();
				foreach($players as $player) {
					$player_name = $player->getName();
					if ($player_name == $search_name) {
					  $found_player = $player;
					}
				}
				return $found_player;
			}

			static function deleteAll()
	        {
	            $GLOBALS['DB']->exec('DELETE FROM players;');
	        }

	}
 ?>
