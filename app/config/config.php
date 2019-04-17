<?php
    $config = [
        "MODEL_PATH" => APPLICATION_PATH.DS.'model'.DS,
        "VIEW_PATH" => APPLICATION_PATH.DS.'view'.DS,
        "LIB_PATH" => APPLICATION_PATH.DS.'lib'.DS,
        "ICONS_PATH" => '..'.DS.'app'.DS.'icons'.DS,
    ];

    $db = [
        "host" => "localhost",
        "username" => "ricardo",
        "password" => "",
        "dbname" => "TCCSchedule",
        "port" => "3306",
        "socket" => ""
    ];

    require_once($config["LIB_PATH"].'functions.php');
?>