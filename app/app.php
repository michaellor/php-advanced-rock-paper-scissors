<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Game.php";
    require_once __DIR__."/../src/Computer.php";
    require_once __DIR__."/../src/Player.php";

    // session_start();

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=rps';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));

    $app->get("/", function() use ($app){
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
        return $app['twig']->render('game.html.twig', array('player1' => $player1, 'player2' => $player2));
    });

    $app->post("/play", function() use ($app){
        $player_one_id = $_POST['player_one_id'];
        $player_one_choice = $_POST['player_one_select'];
        $player_two_id = $_POST['player_two_id'];
        $player_two_choice = $_POST['player_two_select'];

        $new_game = new Game ($player_one_id, $player_one_choice, $player_two_id, $player_two_choice);

        $result = $new_game->playGame();

      return $app['twig']->render("game.html.twig", array('result'=> $result));
    });
    return $app;
 ?>
