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

    // Game play routes for both free play and match play
    require_once __DIR__."/../src/appComponents/gamePlay.php";

    // Routes to stats page and data generation for pie Charts
    require_once __DIR__."/../src/appComponents/stats.php";

    return $app;
 ?>
