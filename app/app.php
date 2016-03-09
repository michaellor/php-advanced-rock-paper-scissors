<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Game.php";
    require_once __DIR__."/../src/Player.php";
    require_once __DIR__."/../src/Match.php";

    session_start();
    if(empty($_SESSION['player_one']))
    {
        $_SESSION['player_one']= array("name"=>null, "id"=>null, "score"=>0);
    }

    if(empty($_SESSION['player_two']))
    {
        $_SESSION['player_two']= array("name"=>null, "id"=>null, "score"=>0);
    }

    if(empty($_SESSION['match']))
    {
        $_SESSION['match']=array("match_type"=> null, "id"=>null);
    }

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=rps';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    // $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));
    use Symfony\Component\HttpFoundation\Request;
          Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig', array(
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                )
        ));
    });

    $app->get("/sign_out", function() use ($app){
        $_SESSION['player_one']= array("name"=>null, "id"=>null, "score"=>0);
        $_SESSION['player_two']= array("name"=>null, "id"=>null, "score"=>0);
        $_SESSION['match']= array("match_type"=>null, "id"=>null);
        return $app['twig']->render('index.html.twig', array(
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                        ),
                'message' => array(
                        'title' => 'Player Signed Out!',
                        'text' => 'You have been signed out. Sign in or create a new account to play.',
                        'link1' => array(
                                'link' => '/sign_in',
                                'text' => 'Start'
                                )
                        )
        ));
    });

    $app->get('/sign_in', function() use ($app) {
        return $app['twig']->render('sign_in.html.twig', array(
                'players' => Player::getAll(),
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                )
        ));
    });

    $app->post("/player_sign_in", function() use ($app) {

        $player_id = $_POST['selected_player_one'];
        $password = $_POST['password'];
        $player = Player::findbyId($player_id);
        if ($password == $player->getPassword()) {
            $_SESSION['player_one']['name'] = $player->getName();
            $_SESSION['player_one']['id'] = $player->getId();

            return $app['twig']->render('index.html.twig', array(
                    'navbar' => array(
                            'userId' => $_SESSION['player_one']['id'],
                            'userName' => $_SESSION['player_one']['name']
                    ),
                    'message' => array(
                            'title' => 'Welcome, ' . $player->getName() . '!',
                            'text' => 'You are now signed in. Enjoy the game, good luck, and check out the stats page after you play a few rounds.',
                            'link1' => array(
                                'link' => '/main_menu',
                                'text' => 'Start'
                            )
                    )
            ));

        } else {
            return $app['twig']->render('index.html.twig', array(
                    'navbar' => array(
                            'userId' => $_SESSION['player_one']['id'],
                            'userName' => $_SESSION['player_one']['name']
                            ),
                    'message' => array(
                            'title' => 'Uh Oh! Login failed.',
                            'text' => 'That password is incorrect. Try again or create a new player.',
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
        }
    });

    $app->post("/new_player", function() use ($app){
        // add if statement, check for name already existing, then skip creation, sign in, and message a fail statement
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


    $app->get("/start_game_pVc", function() use ($app){

        $player1 = Player::findById($_SESSION['player_one']['id' ]);

        $_SESSION['player_two']['name'] = 'HAL (The Computer)';
        $_SESSION['player_two']['id' ]= 0;
        $_SESSION['player_one']['score' ]= 0;
        $_SESSION['player_two']['score' ]= 0;

        $_SESSION['match']['match_type'] = -1;

        return $app['twig']->render('game.html.twig', array(
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


    // $app->post("/start_game", function() use ($app){
    //
    //     $player1_id = $_POST['selected_player_one'];
    //     $player2_id = $_POST['selected_player_two'];
    //     $player1 = Player::findById($player1_id);
    //
    //     $_SESSION['player_one']['name'] = $player1->getName();
    //     $_SESSION['player_one']['id' ]= $player1->getId();
    //
    //     defaulting to best of 5
    //     $_SESSION['match']['match_type'] = -1;
    //     $_SESSION['match']['match_type'] = $_POST['format'];
    //
    //     if($player2_id == -1)
    //     {
    //         $computer = "Computer (HAL)";
    //         $password = null;
    //         $player2 = new Player($computer, $password, $player2_id);
    //     }
    //     else
    //     {
    //         $player2 = Player::findById($player2_id);
    //     }
    //     $_SESSION['player_two']['name']= $player2->getName();
    //     $_SESSION['player_two']['id']= $player2->getId();
    //
    //     if($_SESSION['match']['match_type'] !== -1)
    //     {
    //         $match = new Match ($player1->getId(), null, $player2->getId(), null, null, null);
    //         $match->saveMatch();
    //         $_SESSION['match']['id'] = $match->getId();
    //
    //     }
    //
    //     return $app['twig']->render('game.html.twig', array(
    //             'player1' => $_SESSION['player_one'],
    //             'player2' => $_SESSION['player_two'],
    //             'match'=> $_SESSION['match']
    //     ));
    // });

    // $app->post("/play", function() use ($app){
    //     $player_one_id = $_POST['player_one_id'];
    //     $player_one_choice = $_POST['player_one_select'];
    //     $player_two_id = $_POST['player_two_id'];
    //     $player_two_choice = $_POST['player_two_select'];
    //     $match_id = $_SESSION['match']['id'];
    //
    //
    //     $new_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice, null, null, $match_id);
    //
    //
    //     $result = $new_game->playGame();
    //     if ($new_game->getWinner() == $player_one_id)
    //     {
    //         $_SESSION['player_one']['score'] = $_SESSION['player_one']['score'] + 1;
    //     }
    //     elseif ($new_game->getWinner() == $player_two_id) {
    //     $_SESSION['player_two']['score'] = $_SESSION['player_two']['score'] + 1;
    //     }
    //
    //     if($_SESSION['match']['match_type'] != null)
    //     {
    //         if ($_SESSION['player_one']['score'] == $_SESSION['match']['match_type'])
    //         {
    //             $p1_score = $_SESSION['player_one']['score'];
    //             $p2_score=$_SESSION['player_two']['score'];
    //             $winner = $_SESSION['player_one']['id'];
    //             $match = Match::findById($_SESSION['match']['id']);
    //             $match->update($p1_score, $p2_score, $winner);
    //
    //         }
    //         elseif ($_SESSION['player_two']['score'] == $_SESSION['match']['match_type'])
    //         {
    //             $p1_score = $_SESSION['player_one']['score'];
    //             $p2_score=$_SESSION['player_two']['score'];
    //             $winner = $_SESSION['player_two']['id'];
    //             $match = Match::findById($_SESSION['match']['id']);
    //             $match->update($p1_score, $p2_score, $winner);
    //
    //         }
    //     }
    //   return $app['twig']->render("game.html.twig", array('result'=> $result, 'player1'=>$_SESSION['player_one'], 'player2'=>$_SESSION['player_two'], 'match'=>$_SESSION['match'] ));
    // });

    $app->patch("/match_results", function() use ($app){
      return $app['twig']->render("game.html.twig", array('result'=> $result, 'player1'=>$_SESSION['player_one'], 'player2'=>$_SESSION['player_two'], 'format'=>$_SESSION['match_type']));
    });

    $app->get("/data/{id}", function($id) use ($app){
        $player1 = Player::findById($id);
        $player1_data = $player1->getTotalHands();
        return $player1->barGraphData($player1_data);
    });

    $app->get("/showdata", function() use ($app){

        $user = Player::findById($_SESSION['player_one']['id']);
        $user_stats = array(
                'ties' => $user->getTotalGames() - $user->getTotalWins() - $user->getTotalLosses(),
                'wins' => $user->getTotalWins(),
                'losses' => $user->getTotalLosses(),
                'total' => $user->getTotalGames()
        );

        return $app['twig']->render('stats.html.twig', array(
                'userStats' => $user_stats,
                'chart' => array(
                        'id' => $_SESSION['player_one']['id'],
                        'target' => 'chart_div_player'
                ),
                'chart2' => array(
                        'id' => 0,
                        'target' => 'chart_div_computer'
                ),
                'player1' => $_SESSION['player_one'],
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                )
        ));
    });

    return $app;
 ?>
