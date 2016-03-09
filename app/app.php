<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Game.php";
    require_once __DIR__."/../src/Player.php";
    require_once __DIR__."/../src/Match.php";

    session_start();
    if(!empty($_SESSION['player_one']))
    {
        $_SESSION['player_one']= array("name"=>null, "id"=>null, "score"=>0);
    }

    if(!empty($_SESSION['player_two']))
    {
        $_SESSION['player_two']= array("name"=>null, "id"=>null, "score"=>0);
    }

    if(!empty($_SESSION['match']))
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
        $_SESSION['player_one']= array("name"=>null, "id"=>null, "score"=>0);
        $_SESSION['player_two']= array("name"=>null, "id"=>null, "score"=>0);
        $_SESSION['match']= array("match_type"=>null, "id"=>null);
        return $app['twig']->render('index.html.twig', array(
                'players' => Player::getAll(),
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                )
        ));
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
        $_SESSION['match']['match_type']= $_POST['format'];

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

        if($_SESSION['match']['match_type'] !== -1)
        {
            $match = new Match ($player1->getId(), null, $player2->getId(), null, null, null);
            $match->saveMatch();
            $_SESSION['match']['id'] = $match->getId();

        }

        return $app['twig']->render('game.html.twig', array(
                'player1' => $_SESSION['player_one'],
                'player2' => $_SESSION['player_two'],
                'match'=> $_SESSION['match']
        ));
    });

    $app->get("/data", function() use ($app){
      $player1 = Player::findById($_SESSION['player_one']['id']);
      $player1_data = $player1->getTotalHands();
      return $player1->barGraphData($player1_data);
    });

    $app->get("/showdata", function() use ($app){
      return $app['twig']->render('stats.html.twig', array());
    });

    $app->post("/play", function() use ($app){
        $player_one_id = $_POST['player_one_id'];
        $player_one_choice = $_POST['player_one_select'];
        $player_two_id = $_POST['player_two_id'];
        $player_two_choice = $_POST['player_two_select'];
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

        if($_SESSION['match']['match_type'] != null)
        {
            if ($_SESSION['player_one']['score'] == $_SESSION['match']['match_type'])
            {
                $p1_score = $_SESSION['player_one']['score'];
                $p2_score=$_SESSION['player_two']['score'];
                $winner = $_SESSION['player_one']['id'];
                $match = Match::findById($_SESSION['match']['id']);
                $match->update($p1_score, $p2_score, $winner);

            }
            elseif ($_SESSION['player_two']['score'] == $_SESSION['match']['match_type'])
            {
                $p1_score = $_SESSION['player_one']['score'];
                $p2_score=$_SESSION['player_two']['score'];
                $winner = $_SESSION['player_two']['id'];
                $match = Match::findById($_SESSION['match']['id']);
                $match->update($p1_score, $p2_score, $winner);

            }
        }
      return $app['twig']->render("game.html.twig", array('result'=> $result, 'player1'=>$_SESSION['player_one'], 'player2'=>$_SESSION['player_two'], 'match'=>$_SESSION['match'] ));
    });

    $app->patch("/match_results", function() use ($app){
      return $app['twig']->render("game.html.twig", array('result'=> $result, 'player1'=>$_SESSION['player_one'], 'player2'=>$_SESSION['player_two'], 'format'=>$_SESSION['match_type']));
    });
    return $app;
 ?>
