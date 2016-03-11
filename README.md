# _Rock Paper Scissors 7_

#### _Advanced version of Paper Rock Scissors , 2016-03-10_

#### By _** Joe Karasek, Michael Lor, Aundra Miller, Nic Netzel **_

## Description

**Rock Paper Scissors 7** _is an PHP/Silex based web-app game developed by a team of 4 developers over the course of one week. This application allows users to play a version of Rock, Paper, Scissors that has 7 instead of 3 choices: 'Air', 'Water', 'Fire', and 'Sponge' are added to the classic mix of 'Rock', 'Paper', and 'Scissors'. Game modes include Freeplay, Best of 1, Best of 3, Best of 5, Best of 7, and Best of 73. Users can create an account, sign-in, and sign-out. Game statistics are stored and players can see their stats, compare their stats to the computer, and view a leaderboard of all players' results._

_This application was built by a team of four junior developers at the culmination of the level 2 PHP course at [Epicodus](http://www.epicodus.com/). To build this web-app, we applied our newly gained knowledge of PHP, the Silex framework, phpUnit, and mySQL. We also used a range of css frameworks and the Google Charts API._

_To see our latest work, please checkout our personal portfolios..._

* Joe Karasek [GitHub](https://joekarasek.github.io/)
* Michael Lor [GitHub](https://michaellor.github.io/)
* Aundra Miller [GitHub](https://milleraundra.github.io/)
* Nic Netzel [GitHub](https://netzeln.github.io/)

## Setup/Installation Requirements

1. The dependencies for this project are managed using [Composer](https://getcomposer.org/). In terminal run the following command to install project dependencies:
        composer install
2. You will need to run a local server to host the site. From the project root, run the following terminal commands:

        cd web
        php -s localhost:8000

3. Open the directory http://localhost:8000 in any standard web browser.

### SQL commands

A SQL database is included with the repo. However, you use the following mySQL commands to setup your own version of the database:

    CREATE DATABASE rps;
    USE rps;
    CREATE TABLE rounds (id serial PRIMARY KEY, player_one_id INT, player_one_choice VARCHAR(255), player_two_id INT, player_two_choice VARCHAR(255), winner_id INT, match_id INT);
    CREATE TABLE players (id serial PRIMARY KEY, name VARCHAR(255), password VARCHAR(255));
    CREATE TABLE matches (id serial PRIMARY KEY, player_one_id INT, player_one_score VARCHAR(255), player_two_id INT, player_two_score VARCHAR(255), winner_id INT);

* To run phpUnit, you will need to create a test database called 'rps_test' with the same structure as the 'rps' database.
* The 'players' table in the database will need an entry for 'computer' with an id of 0 for the program to function correctly. This is included in the repo database, but if you make your own database you will need to add this entry before the program works.

### phpUnit

PHPUnit is included with the dependencies for this project. To run phpunit, use the following commands in terminal (from the project root directory):

    export PATH=$PATH:./vendor/bin
    phpunit tests

## Known Bugs

* _An entry for the 'computer' must be added to the database column players with an id equal to 0. This should be validated by the application._
* _Multi-player Mode is not currently Supported_
* _Match Mode statistics treat an unfinished/early exited game as a loss for the player_
* _Entries into database (player name, player password), are not sanitized for characters that break SQL such as apostrophes._

## Technologies Used


* _Composer_
* _Twig_
* _Silex_
* _PHP_
* _PHPUnit_
* _mySQL_
* _Google Charts API_


### License

*{an MIT licesnse (unless someone has a better option)}*

Copyright (c) 2016 **_Joe Karasek, Michael Lor, Aundra Miller, Nic Netzel_**

Graphics Copyright (c) 2016 **_Michael Lor_**

Original Idea for RPS-7 (c) 2003 [**_David C. Lovelace_**](http://www.umop.com/rps7.htm)
