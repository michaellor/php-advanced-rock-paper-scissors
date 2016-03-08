<?php

    //if using database
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Match.php";

    //if using database
    $server = 'mysql:host=localhost;dbname=rps_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);



    class  MatchTest  extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Match::deleteAll();
        }
        function testGetPlayerOneId()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_score = null;
            $player_two_id = 2;
            $player_two_score = null;
            $winner = 1;
            $id = 0;
            $test_match = new Match ($player_one_id, $player_one_score, $player_two_id, $player_two_score, $winner, $id);

            //Act
            $result = $test_match->getPlayerOneId();

            //Assert
            $this->assertEquals(1, $result);
        }
        function testGetPlayerTwoId()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_score = null;
            $player_two_id = 2;
            $player_two_score = null;
            $winner = 1;
            $id = 0;
            $test_match = new Match ($player_one_id, $player_one_score, $player_two_id, $player_two_score, $winner, $id);

            //Act
            $result = $test_match->getPlayerTwoId();

            //Assert
            $this->assertEquals(2, $result);
        }
        function testGetPlayerOneScore()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_score = 3;
            $player_two_id = 2;
            $player_two_score = 2;
            $winner = 1;
            $id = 0;
            $test_match = new Match ($player_one_id, $player_one_score, $player_two_id, $player_two_score, $winner, $id);

            //Act
            $result = $test_match->getPlayerOneScore();

            //Assert
            $this->assertEquals(3, $result);
        }
        function testGetPlayerTwoScore()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_score = 3;
            $player_two_id = 2;
            $player_two_score = 2;
            $winner = 1;
            $id = 0;
            $test_match = new Match ($player_one_id, $player_one_score, $player_two_id, $player_two_score, $winner, $id);

            //Act
            $result = $test_match->getPlayerTwoScore();

            //Assert
            $this->assertEquals(2, $result);
        }
        function testGetId()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_score = null;
            $player_two_id = 2;
            $player_two_score = null;
            $winner = 1;
            $id = 0;
            $test_match = new Match ($player_one_id, $player_one_score, $player_two_id, $player_two_score, $winner, $id);

            //Act
            $result = $test_match->getId();

            //Assert
            $this->assertEquals(0, $result);
        }

        function testSaveMatch()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_score = null;
            $player_two_id = 2;
            $player_two_score = null;
            $winner = 1;
            $id = 0;
            $test_match = new Match ($player_one_id, $player_one_score, $player_two_id, $player_two_score, $winner, $id);

            //Act
            $test_match->saveMatch();
            $result = Match::getAll();

            //Assert
            $this->assertEquals([$test_match], $result);
        }

        function testGetAll()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_score = 2;
            $player_two_id = 2;
            $player_two_score = 1;
            $winner = 0;
            $id = 0;
            $test_match = new Match ($player_one_id, $player_one_score, $player_two_id, $player_two_score, $winner, $id);
            $test_match->saveMatch();

            $player_one_id2 = 1;
            $player_one_score2 = null;
            $player_two_id2 = 2;
            $player_two_score2 = null;
            $winner2 = 1;
            $id2 = 0;
            $test_match2 = new Match ($player_one_id2, $player_one_score2, $player_two_id2, $player_two_score2, $winner2, $id2);
            $test_match2->saveMatch();
            //Act

            $result = Match::getAll();

            //Assert
            $this->assertEquals([$test_match, $test_match2], $result);
        }

        function testFindById()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_score = 2;
            $player_two_id = 2;
            $player_two_score = 1;
            $winner = 0;
            $id = 0;
            $test_match = new Match ($player_one_id, $player_one_score, $player_two_id, $player_two_score, $winner, $id);
            $test_match->saveMatch();

            $player_one_id2 = 1;
            $player_one_score2 = null;
            $player_two_id2 = 2;
            $player_two_score2 = null;
            $winner2 = 1;
            $id2 = 0;
            $test_match2 = new Match ($player_one_id2, $player_one_score2, $player_two_id2, $player_two_score2, $winner2, $id2);
            $test_match2->saveMatch();

            //Act
            $found_match = Match::findById($test_match->getId());

            //Assert
            $this->assertEquals($found_match, $test_match);

        }

        function testUpdate()
        {
            //Arrange
            $player_one_id = 1;
            $player_one_score = null;
            $player_two_id = 2;
            $player_two_score = null;
            $winner = null;
            $id = 0;
            $test_match = new Match ($player_one_id, $player_one_score, $player_two_id, $player_two_score, $winner, $id);
            $test_match->saveMatch();

            $new_p1_score = 4;
            $new_p2_score = 2;
            $new_winner = $player_one_id;

            //act
            $test_match->update($new_p1_score, $new_p2_score, $new_winner);
            $result = Match::findById($test_match->getId());

            //assert
            $this->assertEquals($new_p1_score, $result->getPlayerOneScore());
            $this->assertEquals($new_p2_score, $result->getPlayerTwoScore());
            $this->assertEquals($new_winner, $result->getWinner());
        }


    }
?>
