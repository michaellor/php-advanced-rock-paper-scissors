<?php

    //if using database
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Game.php";

    //if using database
    $server = 'mysql:host=localhost;dbname=rps_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);



    class  GameTest  extends PHPUnit_Framework_TestCase
    {
        function testGetPlayerOneId()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_choice = "rock";
            $player_two_id = 2;
            $player_two_choice = "scissors";
            $winner = 1;
            $id = 0;
            $test_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice, $winner, $id);

            //Act
            $result = $test_game->getPlayerOneId();

            //Assert
            $this->assertEquals(1, $result);
        }
        function testGetPlayerTwoId()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_choice = "rock";
            $player_two_id = 2;
            $player_two_choice = "scissors";
            $winner = 1;
            $id = 0;
            $test_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice, $winner, $id);

            //Act
            $result = $test_game->getPlayerTwoId();

            //Assert
            $this->assertEquals(2, $result);
        }
        function testGetPlayerOneChoice()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_choice = "rock";
            $player_two_id = 2;
            $player_two_choice = "scissors";
            $winner = 1;
            $id = 0;
            $test_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice, $winner, $id);

            //Act
            $result = $test_game->getPlayerOneChoice();

            //Assert
            $this->assertEquals("rock", $result);
        }
        function testGetPlayerTwoChoice()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_choice = "rock";
            $player_two_id = 2;
            $player_two_choice = "scissors";
            $winner = 1;
            $id = 0;
            $test_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice, $winner, $id);

            //Act
            $result = $test_game->getPlayerTwoChoice();

            //Assert
            $this->assertEquals("scissors", $result);
        }
        function testGetId()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_choice = "rock";
            $player_two_id = 2;
            $player_two_choice = "scissors";
            $winner = 1;
            $id = 0;
            $test_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice, $winner, $id);

            //Act
            $result = $test_game->getId();

            //Assert
            $this->assertEquals(0, $result);
        }
        function testPlayGameP1Wins()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_choice = "rock";
            $player_two_id = 2;
            $player_two_choice = "scissors";
            $winner = 1;
            $id = 0;
            $test_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice, $winner, $id);

            //Act
            $result = $test_game->playGame($player_one_id, $player_one_choice, $player_two_id, $player_two_choice);

            //Assert
            $this->assertEquals("Player 1", $result);
        }
        function testPlayGameP2Wins()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_choice = "water";
            $player_two_id = 2;
            $player_two_choice = "paper";
            $winner = 1;
            $id = 0;
            $test_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice, $winner, $id);

            //Act
            $result = $test_game->playGame($player_one_id, $player_one_choice, $player_two_id, $player_two_choice);

            //Assert
            $this->assertEquals("Player 2", $result);
        }
        function testPlayGameTie()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_choice = "water";
            $player_two_id = 2;
            $player_two_choice = "water";
            $winner = 1;
            $id = 0;
            $test_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice, $winner, $id);

            //Act
            $result = $test_game->playGame($player_one_id, $player_one_choice, $player_two_id, $player_two_choice);

            //Assert
            $this->assertEquals("Tie", $result);
        }

    }
?>
