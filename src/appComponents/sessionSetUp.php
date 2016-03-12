<?php

    // If cookie is empty, will build basic data structure with empty values
    
    session_start();
    if(empty($_SESSION['player_one']))
    {
        $_SESSION['player_one']= array("name"=>null, "id"=>null, "choice"=>null, "score"=>0);
    }
    if(empty($_SESSION['player_two']))
    {
        $_SESSION['player_two']= array("name"=>null, "id"=>null, "choice"=>null, "score"=>0);
    }
    if(empty($_SESSION['match']))
    {
        $_SESSION['match']=array("win_number"=> null, "id"=>null);
    }
