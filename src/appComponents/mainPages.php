<?php

    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig', array(
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name'])
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

    $app->get("/about", function() use ($app){
        return $app['twig']->render('about.html.twig', array(
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
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

    $app->get("/main_menu_select", function() use ($app){
      return $app['twig']->render('game_select.html.twig', array(
                'navbar' => array(
                        'userId' => $_SESSION['player_one']['id'],
                        'userName' => $_SESSION['player_one']['name']
                      ),
                'menu' => true
              ));
    });

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

?>
