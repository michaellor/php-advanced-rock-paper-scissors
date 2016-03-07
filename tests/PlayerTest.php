<?php

    // //if using database
    // /**
    // * @backupGlobals disabled
    // * @backupStaticAttributes disabled
    // */

    require_once "src/Player.php";

    // //if using database
    // $server = 'mysql:host=localhost;dbname=~~~~~~~~~';
    // $username = 'root';
    // $password = 'root';
    // $DB = new PDO($server, $username, $password);



    class  PlayerTest  extends PHPUnit_Framework_TestCase
    {
        function test_getNamePasswordId()
        {
            //Arrange
            $test_name = "Aundra";
            $test_password = '1234';
            $test_id = 1;
            $test_player = new Player($test_name, $test_password, $test_id);

            //Act
            $result_name = $test_player->getName();
            $result_password = $test_player->getPassword();
            $result_id = $test_player->getId();

            //Assert
            $this->assertEquals($test_name, $result_name);
            $this->assertEquals($test_password, $result_password);
            $this->assertEquals($test_id, $result_id);
        }

        function test_setNamePassword()
        {
            //Arrange
            $test_name = "Aundra";
            $test_password = '1234';
            $test_id = 1;
            $test_player = new Player($test_name, $test_password, $test_id);

            //Act
            $test_player->setName('Joseph');
            $test_player->setPassword('4567');

            $result_name = $test_player->getName();
            $result_password = $test_player->getPassword();
            $result_id = $test_player->getId();

            //Assert
            $this->assertEquals('Joseph', $result_name);
            $this->assertEquals('4567', $result_password);
            $this->assertEquals($test_id, $result_id);
        }

    }
?>
