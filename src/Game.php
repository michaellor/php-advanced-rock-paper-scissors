<?php
    class  Game
    {

        private $player_one_id;
        private $player_one_choice;
        private $player_two_id;
        private $player_two_choice;
        private $winner;
        private $id;

        function getPlayerOneId()
        {
          return $this->player_one_id;
        }
        function setPlayerOneId($new_id)
        {
          $this->player_one_id = $new_id;
        }
        function getPlayerOneChoice()
        {
          return $this->player_one_choice;
        }
        function setPlayerOneChoice($new_choice)
        {
          $this->player_one_choice = $new_choice;
        }

        function getPlayerTwoId()
        {
          return $this->player_two_id;
        }
        function setPlayerTwoId($new_id)
        {
          $this->player_two_id = $new_id;
        }
        function getPlayerTwoChoice()
        {
            return $this->player_two_choice;
        }
        function setPlayerTwoChoice($new_choice)
        {
          $this->player_two_choice = $new_choice;
        }

        function getWinner()
        {
          return $this->winner;
        }
        function setWinner($new_winner)
        {
           $this->winner = $new_winner;
        }
        function getId()
        {
          return $this->id;
        }
        function __construct($player_one_id, $player_one_choice,  $player_two_id, $player_two_choice, $winner, $id=null)
        {
            $this->player_one_id = $player_one_id;
            $this->player_one_choice = $player_one_choice;
            $this->player_two_id = $player_two_id;
            $this->player_two_choice = $player_two_choice;
            $this->winner = $winner;
            $this->id = $id;
        }

        function playGame()
        {
            if ($this->getPlayerOneChoice() == "rock" && ($this->getPlayerTwoChoice() == "fire" ||
            $this->getPlayerTwoChoice()== "scissors" || $this->getPlayerTwoChoice() == "sponge") ||
//Fire beats
            $this->getPlayerOneChoice() == "fire" && ($this->getPlayerTwoChoice() == "scissors" ||
            $this->getPlayerTwoChoice()== "sponge" || $this->getPlayerTwoChoice() == "paper") ||
//scissors beats
            $this->getPlayerOneChoice() == "scissors" && ($this->getPlayerTwoChoice() == "sponge" ||
            $this->getPlayerTwoChoice()== "paper" || $this->getPlayerTwoChoice() == "air") ||
//sponge beats
            $this->getPlayerOneChoice() == "sponge" && ($this->getPlayerTwoChoice() == "paper" ||
            $this->getPlayerTwoChoice()== "air" || $this->getPlayerTwoChoice() == "water") ||
//paper beats
            $this->getPlayerOneChoice() == "paper" && ($this->getPlayerTwoChoice() == "air" ||
            $this->getPlayerTwoChoice()== "water" || $this->getPlayerTwoChoice() == "rock") ||
//air beats
            $this->getPlayerOneChoice() == "air" && ($this->getPlayerTwoChoice() == "water" ||
            $this->getPlayerTwoChoice()== "rock" || $this->getPlayerTwoChoice() == "fire") ||
//water beats
            $this->getPlayerOneChoice() == "water" && ($this->getPlayerTwoChoice() == "rock" ||
            $this->getPlayerTwoChoice()== "fire" || $this->getPlayerTwoChoice() == "scissors"))
 			{
                //$this->setWinner($this->player_one_id)
                return "Player 1";
 			}
			elseif ($this->getPlayerOneChoice() == $this->getPlayerTwoChoice())
			{
                //$this->setWinner(0);
                return "Tie";
			}
			else
			{
                //$this->setWinner($this->player_two_id)
				return "Player 2";
			}
        }

        function saveRound()
        {
            $GLOBALS['DB']->exec("INSERT INTO rounds (player_one_id, player_one_choice, player_two_id, player_two_choice, winner_id) VALUES ({$this->getPlayerOneId()}, '{$this->getPlayerOneChoice()}',{$this->getPlayerTwoId()}, '{$this->getPlayerTwoChoice()}', {$this->getWinner()});");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $matching_games = $GLOBALS['DB']->query("SELECT * FROM rounds");
            $games = array();

            foreach($matching_games as $game)
            {
                $p_1_id = $game['player_one_id'];
                $p_1_choice = $game['player_one_choice'];
                $p_2_id = $game['player_two_id'];
                $p_2_choice = $game ['player_two_choice'];
                $winner = $game['winner_id'];
                $id = $game['id'];
                $new_game = new Game($p_1_id, $p_1_choice, $p_2_id, $p_2_choice, $winner, $id);
                array_push($games, $new_game);
            }
            return $games;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM rounds");
        }
    }
?>
