<?php
    $config = [
        "MODEL_PATH" => APPLICATION_PATH.DS.'model'.DS,
        "VIEW_PATH" => APPLICATION_PATH.DS.'view'.DS,
        "LIB_PATH" => APPLICATION_PATH.DS.'lib'.DS,
        "ICONS_PATH" => '..'.DS.'app'.DS.'icons'.DS,
    ];

    $db = [
        "host" => "localhost",
        "username" => "rmmcosta",
        "password" => "914423167",
        "dbname" => "TCCSchedule",
        "port" => "3306",
        "socket" => ""
    ];

    $tablelist = [
        "defaultpage"=>"0",
        "defaultlinecount"=>"5"
    ];

    date_default_timezone_set("Europe/Lisbon");

    require_once($config["LIB_PATH"].'functions.php');
?>