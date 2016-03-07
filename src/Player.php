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
				$query = $GLOBALS['DB']->query("SELECT *
						FROM rounds
						WHERE player_one_id = {$this->getId()}
						OR player_two_id = {$this->getId()};");
				$rounds = $query->fetchAll(PDO::FETCH_ASSOC);
				return count($rounds);
			}

			function getTotalWins()
			{
				$query = $GLOBALS['DB']->query("SELECT * FROM rounds WHERE winner_id = {$this->getId()};");
				$wins = $query->fetchAll(PDO::FETCH_ASSOC);
				return count($wins);
			}

			function getTotalLosses()
			{
				return $this->getTotalGames() - $this->getTotalWins();
			}

			// $types comes in as an array of the potential hand types i.e. ['rock','paper','scissors']
			// getHands($types) will return an associative array with data for given player, i.e. ['rock' => 1, 'paper' => 8, 'scissors' => 5]
			// default array is set to the whole range of options, currently 7 different types
			function getTotalHands($types = ['rock', 'paper', 'scissors', 'fire', 'air', 'water', 'sponge'])
			{
				$query = $GLOBALS['DB']->query("SELECT *
						FROM rounds
						WHERE player_one_id = {$this->getId()}
						OR player_two_id = {$this->getId()};");
				$player_rounds = $query->fetchAll(PDO::FETCH_ASSOC);
				$results = array();
				foreach ($types as $type) {
					$count = 0;
					foreach ($player_rounds as $player_round) {
						if ($player_round['player_one_id'] == $this->getId() && $player_round['player_one_choice'] == $type) {
							$count++;
						}
						if ($player_round['player_two_id'] == $this->getId() && $player_round['player_two_choice'] == $type) {
							$count++;
						}
					}
					$results[$type] = $count;
				}
				return $results;
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
