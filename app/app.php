<?php
    require_once __DIR__."/../vendor/autoload.php";
    // require_once __DIR__."/../src/Game.php";
    // require_once __DIR__."/../src/Computer.php";
    // require_once __DIR__."/../src/Player.php";

    // session_start();

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=rps';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));

    $app->get("/", function() use ($app){
        // return $app['twig']->render('index.html.twig', array('players' => Player::getAll()));
        return $app['twig']->render('stats.html.twig');
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
        $player2 = Player::findById($player2_id);
        return $app['twig']->render('game.html.twig', array('player1' => $player1, 'player2' => $player2));
    });

    $app->get("/data", function() use ($app){
      $string = '{
        "cols": [
              {"id":"","label":"","pattern":"","type":"string"},
              {"id":"","label":"Framework","pattern":"","type":"number"}
            ],
        "rows": [
              {"c":[{"v":"Laravel","f":null},{"v":2112,"f":null}]},
              {"c":[{"v":"Symfony2","f":null},{"v":1005,"f":null}]},
              {"c":[{"v":"Nette","f":null},{"v":703,"f":null}]},
              {"c":[{"v":"Yii 2","f":null},{"v":620,"f":null}]},
              {"c":[{"v":"CodeIgniter","f":null},{"v":482,"f":null}]},
              {"c":[{"v":"PHPixie","f":null},{"v":420,"f":null}]},
              {"c":[{"v":"Zend 2","f":null},{"v":346,"f":null}]},
              {"c":[{"v":"No Framework","f":null},{"v":306,"f":null}]},
              {"c":[{"v":"Yii 1","f":null},{"v":293,"f":null}]},
              {"c":[{"v":"Phalcon","f":null},{"v":231,"f":null}]}
          ]
      }';

      return $string;
    });

    return $app;
 ?>
