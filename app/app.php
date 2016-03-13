<?php

// ===============================================
// Initiate App - Load dependencies, set up Silex,
//   establish Session variable, and connect to db
// ===============================================

    // Load dependencies
    require_once __DIR__."/../vendor/autoload.php";

    // Load classes
    require_once __DIR__."/../src/Game.php";
    require_once __DIR__."/../src/Player.php";
    require_once __DIR__."/../src/Match.php";

    // Setup $_SESSION if empty
    require_once __DIR__."/../src/appComponents/sessionSetUp.php";

    // Connect to SQL database
    require_once __DIR__."/../src/appComponents/databaseConnect.php";

    // Initiate Silex with needed components
    require_once __DIR__."/../src/appComponents/silex.php";


// ===============================================
//       Routes
// ===============================================

    // Routes to main static pages
    require_once __DIR__."/../src/appComponents/mainPages.php";

    // Account managment including sign in, signout, and create new player
    require_once __DIR__."/../src/appComponents/accountManagement.php";


    $app->get("/pVc_free_play", function() use ($app){

        $player1 = Player::findById($_SESSION['player_one']['id' ]);

        $_SESSION['player_two']['name'] = 'HAL (The Computer)';
        $_SESSION['player_two']['id' ]= 0;
        $_SESSION['player_one']['score' ]= 0;
        $_SESSION['player_two']['score' ]= 0;

        $_SESSION['match']['win_number'] = -1;
        $_SESSION['match']['id']= null;

        return $app['twig']->render('game.html.twig', array(
                'game' => 'Free Play',
                'message' => array(
                        'text' => 'Choose your hand!',
                        'color' => 'blue-grey'
                ),
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                ),
                'player1' => $_SESSION['player_one'],
                'player2' => $_SESSION['player_two'],
                'match'=> $_SESSION['match']
        ));
    });

    $app->get("/play_pVc/{choice}", function($choice) use ($app){
        $player_one_id = $_SESSION['player_one']['id'];
        $player_one_choice = $choice;
        $player_two_id = $_SESSION['player_two']['id'];
        $player_two_choice = '';
        $match_id = $_SESSION['match']['id'];
        $new_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice, null, null, $match_id);
        $result = $new_game->playGame();

        if ($new_game->getWinner() == $player_one_id)
        {
            $_SESSION['player_one']['score'] = $_SESSION['player_one']['score'] + 1;
        }
        elseif ($new_game->getWinner() == $player_two_id) {
            $_SESSION['player_two']['score'] = $_SESSION['player_two']['score'] + 1;
        }
        return $app['twig']->render('game.html.twig', array(
                'game' => 'Free Play',
                'message'=> $result,
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                ),
                'player1' => $_SESSION['player_one'],
                'player2' => $_SESSION['player_two'],
                'match'=> $_SESSION['match']
        ));
    });

    //MATCH PLAY VERSUS COMPUTER
    $app->get("/pVc_match", function() use ($app){

        $player1 = Player::findById($_SESSION['player_one']['id' ]);

        $_SESSION['player_two']['name'] = 'HAL (The Computer)';
        $_SESSION['player_two']['id' ]= 0;
        $_SESSION['player_one']['score' ]= 0;
        $_SESSION['player_two']['score' ]= 0;

        $_SESSION['match']['win_number'] = $_GET['win'];
        $game_number = $_GET['win'] + $_GET['win'] -1;
        if ($game_number == 1) {
          $game_title = 'All or Nothing';
        } else {
          $game_title = 'Best of ' . $game_number;
        }

        $_SESSION['match']['title'] = $game_title;

        $match = new Match ($_SESSION['player_one']['id' ], null, $_SESSION['player_two']['id'], null, null, null);
        $match->saveMatch();
        $_SESSION['match']['id'] = $match->getId();

        return $app['twig']->render('game.html.twig', array(
                'game' => $game_title,
                'message' => array(
                      'text' => 'Choose your hand!',
                      'color' => 'blue-grey'
                ),
                'navbar' => array(
                      'userId' => $_SESSION['player_one']['id'],
                      'userName' => $_SESSION['player_one']['name']
                ),
                'player1' => $_SESSION['player_one'],
                'player2' => $_SESSION['player_two'],
                'match'=> $_SESSION['match'],
                'matchType' => 'match/'
        ));
    });

    $app->get("/match/play_pVc/{choice}", function($choice) use ($app){
        $player_one_id = $_SESSION['player_one']['id'];
        $player_one_choice = $choice;
        $player_two_id = 0;
        $player_two_choice = '';
        $match_id = $_SESSION['match']['id'];

        $winner = $_SESSION['match']['win_number'];
        $game_name = 'Best of ' . ($winner * 2 - 1);

        $new_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice, null, null, $match_id);
        $result = $new_game->playGame();


            if ($new_game->getWinner() == $player_one_id)
            {
                $_SESSION['player_one']['score'] = $_SESSION['player_one']['score'] + 1;

                if(($winner > 0) && ($_SESSION['player_one']['score'] == $winner))
                {
                    $match = Match::findById($_SESSION['match']['id']);
                    $match->update($_SESSION['player_one']['score'], $_SESSION['player_two']['score'], $_SESSION['player_one']['id']);
                    return $app['twig']->render('game.html.twig', array(
                            'game' => $_SESSION['match']['title'],
                            'message'=> $result,
                            // 'matchOver' => $match_result,
                            'matchOver' => array(
                                    'color' => 'green',
                                    'text' => $_SESSION['player_one']['name'] . ' Wins the Match',
                                    'link1' => array(
                                            'link' => '/pVc_match?win=' . $winner,
                                            'text' => 'Play Again'
                                          ),
                                    'link2' => array(
                                            'link' => '/main_menu',
                                            'text' => 'Main Menu'
                                          )
                            ),
                            'navbar' => array(
                                    'userId' => $_SESSION['player_one']['id'],
                                    'userName' => $_SESSION['player_one']['name']
                            ),
                            'player1' => $_SESSION['player_one'],
                            'player2' => $_SESSION['player_two'],
                            'match'=> $_SESSION['match']
                    ));
                }
            }

            if ($new_game->getWinner() == $player_two_id)
            {
                $_SESSION['player_two']['score'] = $_SESSION['player_two']['score'] + 1;

                if(($winner > 0) && ($_SESSION['player_two']['score'] == $winner))
                    {
                        $match = Match::findById($_SESSION['match']['id']);
                        $match->update($_SESSION['player_one']['score'], $_SESSION['player_two']['score'], $_SESSION['player_two']['id']);

                        return $app['twig']->render('game.html.twig', array(
                                'game' => $_SESSION['match']['title'],
                                'message'=> $result,
                                'matchOver' => array(
                                        'color' => 'red',
                                        'text' => $_SESSION['player_two']['name'] . ' Wins the Match',
                                        'link1' => array(
                                                'link' => '/pVc_match?win=' . $winner,
                                                'text' => 'Play Again'
                                              ),
                                        'link2' => array(
                                                'link' => '/main_menu',
                                                'text' => 'Main Menu'
                                              )
                                ),
                                // 'matchOver' => $match_result,
                                'navbar' => array(
                                        'userId' => $_SESSION['player_one']['id'],
                                        'userName' => $_SESSION['player_one']['name']
                                ),
                                'player1' => $_SESSION['player_one'],
                                'player2' => $_SESSION['player_two'],
                                'match'=> $_SESSION['match']
                        ));
                    }
            }


                return $app['twig']->render('game.html.twig', array(
                        'game' => $_SESSION['match']['title'],
                        'message'=> $result,
                        'navbar' => array(
                                'userId' => $_SESSION['player_one']['id'],
                                'userName' => $_SESSION['player_one']['name']
                        ),
                        'player1' => $_SESSION['player_one'],
                        'player2' => $_SESSION['player_two'],
                        'match'=> $_SESSION['match']
                ));


    });

    $app->patch("/match_results", function() use ($app){
      return $app['twig']->render("game.html.twig", array(
                  'result'=> $result,
                  'player1'=>$_SESSION['player_one'],
                  'player2'=>$_SESSION['player_two'],
                  'format'=>$_SESSION['win_number']
                  ));
    });

    // Routes to stats page and data generation for pie Charts
    require_once __DIR__."/../src/appComponents/stats.php";

    return $app;
 ?>
