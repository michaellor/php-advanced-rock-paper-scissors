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
				$query = $GLOBALS['DB']->query("SELECT *
						FROM rounds
						WHERE winner_id = {$this->getId()};");
				$wins = $query->fetchAll(PDO::FETCH_ASSOC);
				return count($wins);
			}

			function getTotalLosses()
			{
				$query = $GLOBALS['DB']->query("SELECT *
						FROM rounds
						WHERE (player_one_id = {$this->getId()}
						OR player_two_id = {$this->getId()})
						AND (winner_id != {$this->getId()}
						AND winner_id != -1);");
				$wins = $query->fetchAll(PDO::FETCH_ASSOC);
				return count($wins);
			}
			function getTotalTies()
			{
				$query = $GLOBALS['DB']->query("SELECT *
						FROM rounds
						WHERE (player_one_id = {$this->getId()}
						OR player_two_id = {$this->getId()})
						AND winner_id = -1;");
				$ties = $query->fetchAll(PDO::FETCH_ASSOC);
				return count($ties);
			}

			function getTotalMatches()
			{
				$query = $GLOBALS['DB']->query("SELECT *
						FROM matches
						WHERE player_one_id = {$this->getId()}
						OR player_two_id = {$this->getId()};");
				$matches = $query->fetchAll(PDO::FETCH_ASSOC);
				return count($matches);
			}
			function getMatchWins()
			{
				$query = $GLOBALS['DB']->query("SELECT *
						FROM matches
						WHERE winner_id = {$this->getId()};");
				$wins = $query->fetchAll(PDO::FETCH_ASSOC);
				return count($wins);
			}
			function getMatchLosses()
			{
				$query = $GLOBALS['DB']->query("SELECT *
						FROM matches
						WHERE (player_one_id = {$this->getId()}
						OR player_two_id = {$this->getId()})
						AND (winner_id != {$this->getId()}
						AND winner_id != -1);");
				$losses = $query->fetchAll(PDO::FETCH_ASSOC);
				return count($losses);
			}

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

			function getWinningHands($types = ['rock', 'paper', 'scissors', 'fire', 'air', 'water', 'sponge'])
			{
				$query = $GLOBALS['DB']->query("SELECT *
						FROM rounds
						WHERE player_one_id = {$this->getId()}
						OR player_two_id = {$this->getId()};");
				$player_rounds = $query->fetchAll(PDO::FETCH_ASSOC);
				$results = array();
				foreach($types as $type) {
					$count = 0;
					foreach($player_rounds as $player_round) {
						if ($player_round['player_one_id'] == $this->getId() && $player_round['player_one_choice'] == $type && $player_round['winner_id'] == $this->getId()) {
							$count++;
						}
						if ($player_round['player_two_id'] == $this->getId() && $player_round['player_two_choice'] == $type && $player_round['winner_id'] == $this->getId()) {
							$count++;
						}
					}
					$results[$type] = $count;
				}
				// var_dump($results);
				return $results;
			}

			function barGraphData($hand_data)
			{
					$result = '';
					foreach ($hand_data as $key => $value) {
						$result .= '{"c":[{"v":"' . $key . '","f":null},{"v":' . $value . ',"f":null}]},';
					}
					$data_string_mid = '{
								"cols": [
									{"id":"","label":"","pattern":"","type":"string"},
									{"id":"","label":"Framework","pattern":"","type":"number"}
								],
								"rows": [' . $result;
					$data_string_mid_trimmed = rtrim($data_string_mid, ',');
					$data_string_mid_trimmed .= ']}';
					return $data_string_mid_trimmed;
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

			static function getAllRealPlayers()
			{
				$returned_players = $GLOBALS['DB']->query("SELECT * FROM players WHERE players.id != 0 ORDER BY players.name ASC;");
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
	            $GLOBALS['DB']->exec('DELETE FROM players WHERE id != 0;');
	        }

			static function deleteAllRounds()
	        {
	            $GLOBALS['DB']->exec('DELETE FROM rounds;');
	        }

			static function getPlayerRecords ()
			{
				$all_players = Player::getAllRealPlayers();
		        $player_records = array();
				// function percentMatch($number)
				// { return $number * 100 ;
				// };
				// function percentWin($number)
				// { return $number * 100 ;
				// };

		        foreach($all_players as $player)
		        {

					if($player->getTotalGames() >= 15)
					{

						$game_win_percent = round(100 * ($player->getTotalWins()/$player->getTotalGames()));
					}else {
						$game_win_percent = 0;
					}

					if($player->getTotalMatches() >= 3)
					{

						$match_win_percent = round(100 * ($player->getMatchWins()/$player->getTotalMatches()));
					}else {
						$match_win_percent = 0;
					}


					$player_record = array(
						'id'=>$player->getId(),
						'name'=>$player->getName(),
		                'games'=> $player->getTotalGames(),
		                'match_wins'=>$player->getMatchWins(),
		                'match_losses'=>$player->getMatchLosses(),
		                'wins'=> $player->getTotalWins(),
		                'losses'=> $player->getTotalLosses(),
		                'ties'=>$player->getTotalTies(),
		                'matches'=>$player->getTotalMatches(),
						'game_percent'=>$game_win_percent,
						'match_percent'=>$match_win_percent

		            );


		            array_push($player_records, $player_record);
		        }
				return $player_records;
			}

			static function getTop10Wins(){
				$all_players = Player::getPlayerRecords();

				function cmp_function($a, $b){
					if ($a['wins'] == $b['wins']) return 0;
					return($a['wins'] > $b['wins']) ? -1 :1;
				}
				uasort($all_players, "cmp_function");

				$top_10_wins = array();
				$i =0;

				foreach($all_players as $player)
				{
					if( $i< 10 && ($player['wins'] > 0)){
						$rank = $player['name'] . ": " . $player['wins'];
						array_push($top_10_wins, $rank);
						$i++;
					}
				}


				return $top_10_wins;
			}

			static function getTop10Matches(){
				$all_players = Player::getPlayerRecords();

				function cmp_function2($a, $b){
					if ($a['match_wins'] == $b['match_wins']) return 0;
					return($a['match_wins'] > $b['match_wins']) ? -1 :1;
				}
				uasort($all_players, "cmp_function2");

				$top_10_match_wins = array();
				$i =0;

				foreach($all_players as $player)
				{
					if( $i< 10 && ($player['match_wins'] > 0)){
						$rank = $player['name'] . ": " . $player['match_wins'];
						array_push($top_10_match_wins, $rank);
						$i++;
					}
				}


				return $top_10_match_wins;
			}

			static function getTop10Percentage(){
				$all_players = Player::getPlayerRecords();

				function cmp_function3($a, $b){
					if ($a['game_percent'] == $b['game_percent']) return 0;
					return($a['game_percent'] > $b['game_percent']) ? -1 :1;
				}
				uasort($all_players, "cmp_function3");

				$top_10_game_percent = array();
				$i =0;

				foreach($all_players as $player)
				{
					if( $i< 10 && ($player['game_percent'] > 0)){
						$rank = $player['name'] . ": " . $player['game_percent'] . "%";
						array_push($top_10_game_percent, $rank);
						$i++;
					}
				}


				return $top_10_game_percent;
			}
			static function getTop10MatchPercentage(){
				$all_players = Player::getPlayerRecords();

				function cmp_function4($a, $b){
					if ($a['match_percent'] == $b['match_percent']) return 0;
					return($a['match_percent'] > $b['match_percent']) ? -1 :1;
				}
				uasort($all_players, "cmp_function4");

				$top_10_match_percent = array();
				$i =0;

				foreach($all_players as $player)
				{
					if( $i< 10 && ($player['match_percent'] > 0)){
						$rank = $player['name'] . ": " . $player['match_percent'] . "%";
						array_push($top_10_match_percent, $rank);
						$i++;
					}
				}


				return $top_10_match_percent;
			}
	}
 ?>
