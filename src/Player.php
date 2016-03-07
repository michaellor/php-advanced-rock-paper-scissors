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
