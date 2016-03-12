<?php

// ===============================================
// Account management - allows users to create new
// player, sign in, and sign out
// ===============================================


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
