<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Game.php";
    require_once __DIR__."/../src/Computer.php";
    require_once __DIR__."/../src/Player.php";

    session_start();
    if(empty($_SESSION['player_one']))
    {
        $_SESSION['player_one']= array("name"=>"", "id"=>"", "score"=>0);
    }

    if(empty($_SESSION['player_two']))
    {
        $_SESSION['player_two']= array("name"=>"", "id"=>"", "score"=>0);
    }

    if(empty($_SESSION['match_type']))
    {
        $_SESSION['match_type']=array();
    }

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=rps';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));

    $app->get("/", function() use ($app){
        $_SESSION['player_one']= array("name"=>"", "id"=>"", "score"=>0);
        $_SESSION['player_two']= array("name"=>"", "id"=>"", "score"=>0);
        $_SESSION['match_type']=array();
        return $app['twig']->render('index.html.twig', array('players' => Player::getAll()));
    });

    $app->post("/new_player", function() use ($app){
        $name = $_POST['new_name'];
        $password = $_POST['new_password'];
        $new_player = new Player($name, $password);
        $new_player->save();
      return $app['twig']->render('index.html.twig', array('players'=>Player::getAll()));
    });

    $app->post("/start_game", function() use ($app){
        $player1_id = $_POST['selected_player_one'];
        $player2_id = $_POST['selected_player_two'];
        $player1 = Player::findById($player1_id);
        $_SESSION['player_one']['name'] = $player1->getName();
        $_SESSION['player_one']['id' ]= $player1->getId();
        if($player2_id == -1)
        {
            $computer = "Computer (HAL)";
            $password = null;
            $player2 = new Player($computer, $password, $player2_id);
        }
        else
        {
            $player2 = Player::findById($player2_id);
        }
        $_SESSION['player_two']['name']= $player2->getName();
        $_SESSION['player_two']['id']= $player2->getId();

        $_SESSION['match_type']= $_POST['format'];

        return $app['twig']->render('game.html.twig', array('player1' => $_SESSION['player_one'], 'player2' => $_SESSION['player_two'], 'format'=>$_SESSION['match_type']));
    });

    $app->get("/data", function() use ($app){
      $player1 = Player::findById($_SESSION['player_one']['id']);
      $player1_data = $player1->getTotalHands();
      var_dump($_SESSION);
      return $player1_data;
    });

    $app->get("/showdata", function() use ($app){
      return $app['twig']->render('stats.html.twig', array());
    });

    $app->post("/play", function() use ($app){
        $player_one_id = $_POST['player_one_id'];
        $player_one_choice = $_POST['player_one_select'];
        $player_two_id = $_POST['player_two_id'];
        $player_two_choice = $_POST['player_two_select'];

        $new_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice);

        $result = $new_game->playGame();
        if ($new_game->getWinner() == $player_one_id)
        {
            $_SESSION['player_one']['score'] = $_SESSION['player_one']['score'] + 1;
        }
        elseif ($new_game->getWinner() == $player_two_id) {
        $_SESSION['player_two']['score'] = $_SESSION['player_two']['score'] + 1;
        }
        else {
            $null = null;
        }
        
      return $app['twig']->render("game.html.twig", array('result'=> $result, 'player1'=>$_SESSION['player_one'], 'player2'=>$_SESSION['player_two'], 'format'=>$_SESSION['match_type']));
    });
    return $app;
 ?>
