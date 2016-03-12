<?php

    // Returns the data for a player's pie chart with given id, id of 0 will return the computer information
    $app->get("/data/{id}", function($id) use ($app){
        $player1 = Player::findById($id);
        $player1_data = $player1->getTotalHands();
        return $player1->barGraphData($player1_data);
    });

    // Gathers record of win, tie, losses and generates stats page
    $app->get("/showdata", function() use ($app){
        $user = Player::findById($_SESSION['player_one']['id']);
        $user_stats = array(
                'ties' => $user->getTotalGames() - $user->getTotalWins() - $user->getTotalLosses(),
                'wins' => $user->getTotalWins(),
                'losses' => $user->getTotalLosses(),
                'total' => $user->getTotalGames()
        );
        $user_matches = array(
                'wins' => $user->getMatchWins(),
                'losses' => $user->getMatchLosses(),
                'total' => $user->getTotalMatches()
        );
        $computer = Player::findById(0);
        $computer_stats = array(
                'ties' => $computer->getTotalGames() - $computer->getTotalWins() - $computer->getTotalLosses(),
                'wins' => $computer->getTotalWins(),
                'losses' => $computer->getTotalLosses(),
                'total' => $computer->getTotalGames()
        );
        $computer_match = array(
                'wins' => $computer->getMatchWins(),
                'losses' => $computer->getMatchLosses(),
                'total' => $computer->getTotalMatches()
        );
        return $app['twig']->render('stats.html.twig', array(
                'userStats' => $user_stats,
                'userMatches'=> $user_matches,
                'computerStats' => $computer_stats,
                'computerMatches' => $computer_match,
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
