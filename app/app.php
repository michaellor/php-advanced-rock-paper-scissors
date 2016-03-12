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


    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig', array(
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name'])
        ));
    });

    $app->get("/about", function() use ($app){
        return $app['twig']->render('about.html.twig', array(
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                )
        ));
    });

    $app->get("/rules", function() use ($app){
        return $app['twig']->render('rules.html.twig', array(
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                )
        ));
    });

    // // Account managment including sign in, signout, and create new player
    // require_once __DIR__."/../src/appComponents/accountManagement.php";

    $app->get("/sign_out", function() use ($app){
        $_SESSION['player_one']= array("name"=>null, "id"=>null, "score"=>0);
        $_SESSION['player_two']= array("name"=>null, "id"=>null, "score"=>0);
        $_SESSION['match']= array("win_number"=>null, "id"=>null);
        return $app['twig']->render('index.html.twig', array(
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']),
                'message' => array(
                        'title' => 'Player Signed Out!',
                        'text' => 'You have been signed out. Sign in or create a new account to play.'
                        )
        ));
    });

    $app->get('/sign_in', function() use ($app) {
        return $app['twig']->render('sign_in.html.twig', array(
                'players' => Player::getAllRealPlayers(),
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name'])
        ));
    });

    $app->post("/player_sign_in", function() use ($app) {
        $player_name = $_POST['player_name'];
        $password = $_POST['password'];
        $all_players = Player::getAllRealPlayers();
        foreach ($all_players as $player) {
            if ($player_name == $player->getName() && $password == $player->getPassword()) {
                $_SESSION['player_one']['name'] = $player->getName();
                $_SESSION['player_one']['id'] = $player->getId();
                return $app['twig']->render('index.html.twig', array(
                        'navbar' => array(
                                'userId' => $_SESSION['player_one']['id'],
                                'userName' => $_SESSION['player_one']['name']
                        ),
                        'message' => array(
                                'title' => 'Welcome, ' . $player->getName() . '!',
                                'text' => 'You are now signed in. Enjoy the game, good luck, and check out the stats page after you play a few rounds.'
                        )
                ));
            }
        }
        return $app['twig']->render('index.html.twig', array(
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                        ),
                'message' => array(
                        'title' => 'Uh Oh! Login failed.',
                        'text' => 'Your username or password were incorrect. Try again or create a new player.',
                        'link1' => array(
                            'link' => '/sign_in',
                            'text' => 'Try Again'
                        ),
                        'link2' => array(
                            'link' => '/sign_in',
                            'text' => 'Create New Player'
                        )
                )
        ));
    });

    $app->post("/new_player", function() use ($app){
        $name = $_POST['new_name'];
        $password = $_POST['new_password'];
        $all_players = Player::getAll();
        foreach($all_players as $player) {
            if ($name == $player->getName()) {
                return $app['twig']->render('index.html.twig', array(
                        'navbar' => array(
                                'userId' => $_SESSION['player_one']['id'],
                                'userName' => $_SESSION['player_one']['name']
                                ),
                        'message' => array(
                                'title' => 'Player Creation Failed.',
                                'text' => 'That player already exists. Please use a different player name besides ' . $name,
                                'link1' => array(
                                    'link' => '/sign_in',
                                    'text' => 'Try Again'
                                )
                        )
                ));
            }
        }
        $new_player = new Player($name, $password);
        $new_player->save();
        $_SESSION['player_one']['name'] = $new_player->getName();
        $_SESSION['player_one']['id' ]= $new_player->getId();
        return $app['twig']->render('index.html.twig', array(
                'navbar' => array(
                        'userId' => $new_player->getId(),
                        'userName' => $new_player->getName()
                ),
                'message' => array(
                        'title' => 'New Player Created!',
                        'text' => $name . ' has been created and signed in. Enjoy the game, good luck, and check out the stats page after you play a few rounds.',
                        'link1' => array(
                            'link' => '/main_menu',
                            'text' => 'Start'
                        )
                )
            ));
        });

    $app->get("/main_menu", function() use ($app){
      return $app['twig']->render('index.html.twig', array(
              'navbar' => array(
                      'userId' => $_SESSION['player_one']['id'],
                      'userName' => $_SESSION['player_one']['name']
              ),
              'menu' => true
      ));
    });

    $app->get("/main_menu_select", function() use ($app){
      return $app['twig']->render('game_select.html.twig', array(
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                      ),
                'menu' => true
              ));
    });

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
      return $app['twig']->render("game.html.twig", array('result'=> $result, 'player1'=>$_SESSION['player_one'], 'player2'=>$_SESSION['player_two'], 'format'=>$_SESSION['win_number']));
    });

    // $app->get("/data/{id}", function($id) use ($app){
    //     $player1 = Player::findById($id);
    //     $player1_data = $player1->getTotalHands();
    //     return $player1->barGraphData($player1_data);
    // });
    //
    // $app->get("/showdata", function() use ($app){
    //
    //     $user = Player::findById($_SESSION['player_one']['id']);
    //     $user_stats = array(
    //             'ties' => $user->getTotalGames() - $user->getTotalWins() - $user->getTotalLosses(),
    //             'wins' => $user->getTotalWins(),
    //             'losses' => $user->getTotalLosses(),
    //             'total' => $user->getTotalGames()
    //     );
    //     $user_matches = array(
    //             'wins' => $user->getMatchWins(),
    //             'losses' => $user->getMatchLosses(),
    //             'total' => $user->getTotalMatches()
    //     );
    //     $computer = Player::findById(0);
    //     $computer_stats = array(
    //             'ties' => $computer->getTotalGames() - $computer->getTotalWins() - $computer->getTotalLosses(),
    //             'wins' => $computer->getTotalWins(),
    //             'losses' => $computer->getTotalLosses(),
    //             'total' => $computer->getTotalGames()
    //     );
    //     $computer_match = array(
    //             'wins' => $computer->getMatchWins(),
    //             'losses' => $computer->getMatchLosses(),
    //             'total' => $computer->getTotalMatches()
    //     );
    //     return $app['twig']->render('stats.html.twig', array(
    //             'userStats' => $user_stats,
    //             'userMatches'=> $user_matches,
    //             'computerStats' => $computer_stats,
    //             'computerMatches' => $computer_match,
    //             'chart' => array(
    //                     'id' => $_SESSION['player_one']['id'],
    //                     'target' => 'chart_div_player'
    //             ),
    //             'chart2' => array(
    //                     'id' => 0,
    //                     'target' => 'chart_div_computer'
    //             ),
    //             'player1' => $_SESSION['player_one'],
    //             'navbar' => array(
    //                     'userId' => $_SESSION['player_one']['id'],
    //                     'userName' => $_SESSION['player_one']['name']
    //             )
    //     ));
    // });

    $app->get("/leaderboard", function() use ($app){
        $top_ten = Player::getTop10Wins();
        $all_players = Player::getPlayerRecords();
        $ten_matches = Player::getTop10Matches();
        $game_percent = Player::getTop10Percentage();
        $match_percent = Player::getTop10MatchPercentage();

        return $app['twig']->render('leaderboard.html.twig', array(
                'allplayers'=> $all_players,
                'top10'=>$top_ten,
                'top_match'=>$ten_matches,
                'win_percent'=>$game_percent, 'match_percent'=>$match_percent,
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name'])));
    });

    return $app;
 ?>
