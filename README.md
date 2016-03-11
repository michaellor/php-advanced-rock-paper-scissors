# _Rock Paper Scissors: Advanced_

#### _Advanced version of Paper Rock Scissors , 2016-03-10_

#### By _**Joe Karask, Michael Lor, Aundra Miller, Nic Netzel **_

## Description

_This application allows users to play a 7-option version of Rock Paper Scissors versus a Computer Opponent either in an unlimited 'free-play' mode or in a 'best of _ ' match mode. Users can create a login and have access to their cumulative statistics for both rounds and matches, as well as a breakdown of the frequency of their choices_

## Setup/Installation Requirements

* _Clone the Repository_
* _in your terminal, run "composer install"   to get silex and twig_
* _start your php server in the "web" folder_
* _unzip and install the database contained in 'rps.zip'_
* _once the database is installed check to make sure the 'players' table contains a record with id = 0, and name = 'Computer'. This is necessary in order to collect statistics for the computer opponent_



## Known Bugs


* _An entry for the 'computer' must be added to the database column players with an id equal to 0_
* _Multi-player Mode is not currently Supported_
* _Match Mode statistics treat an unfinished/early exited game as a loss for the player_
* _Entries into database (player name, player password), are not sanitized for characters that break SQL such as apostrophes



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

Original Idea for RPS-7 (c) 2003 **_David C. Lovelace_** [http://www.umop.com/rps7.htm]
