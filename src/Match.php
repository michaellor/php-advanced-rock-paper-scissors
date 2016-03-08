<?php
    class  Match
    {

        private $player_one_id;
        private $player_one_score;
        private $player_two_id;
        private $player_two_score;
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
        function getPlayerOneScore()
        {
          return $this->player_one_score;
        }
        function setPlayerOneScore($new_score)
        {
          $this->player_one_score = $new_score;
        }

        function getPlayerTwoId()
        {
          return $this->player_two_id;
        }
        function setPlayerTwoId($new_id)
        {
          $this->player_two_id = $new_id;
        }
        function getPlayerTwoScore()
        {
            return $this->player_two_score;
        }
        function setPlayerTwoScore($new_score)
        {
          $this->player_two_score = $new_score;
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
        function __construct($player_one_id, $player_one_score = null,  $player_two_id, $player_two_score =null , $winner = null, $id = null)
        {
            $this->player_one_id = (int)$player_one_id;
            $this->player_one_score = (int)$player_one_score;
            $this->player_two_id = (int)$player_two_id;
            $this->player_two_score = (int)$player_two_score;
            $this->winner = (int)$winner;
            $this->id = $id;
        }



        function saveMatch()
        {
            $GLOBALS['DB']->exec("INSERT INTO matches (player_one_id, player_one_score, player_two_id, player_two_score, winner_id) VALUES ({$this->getPlayerOneId()}, '{$this->getPlayerOneScore()}',{$this->getPlayerTwoId()}, '{$this->getPlayerTwoScore()}', {$this->getWinner()});");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $matching_matches = $GLOBALS['DB']->query("SELECT * FROM matches");
            $matches = array();

            foreach($matching_matches as $match)
            {
                $p_1_id = $match['player_one_id'];
                $p_1_score = $match['player_one_score'];
                $p_2_id = $match['player_two_id'];
                $p_2_score = $match ['player_two_score'];
                $winner = $match['winner_id'];
                $id = $match['id'];
                $new_match = new Match($p_1_id, $p_1_score, $p_2_id, $p_2_score, $winner, $id);
                array_push($matches, $new_match);
            }
            return $matches;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM matches");
        }

        static function findById($id)
        {
            $all_matches = Match::getAll();
            $found_match = null;
            foreach($all_matches as $match) {
                $match_id = $match->getId();
                if ($match_id == $id) {
                    $found_match = $match;
                }
            }
            return $found_match;
        }

        function update($new_p1_score, $new_p2_score, $new_winner)
        {
            $GLOBALS['DB']->exec("UPDATE matches SET player_one_score = {$new_p1_score}, player_two_score = {$new_p2_score}, winner_id = {$new_winner} WHERE id = {$this->getId()};");
            $this->setPlayerOneScore($new_p1_score);
            $this->setPlayerTwoScore($new_p2_score);
            $this->setWinner($new_winner);
        }
    }
?>
