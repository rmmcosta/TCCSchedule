<?php
    //construct cars multiselect to use with ajax
    defined("APPLICATION_PATH") || define("APPLICATION_PATH",realpath(dirname('__FILE__')) . '/../app');
    const DS = DIRECTORY_SEPARATOR;

    //inclue config file
    require_once(APPLICATION_PATH.DS.'config'.DS.'config.php');
    require_once(APPLICATION_PATH.DS.'model'.DS.'home.php');

    echo getSchedulesCalendar($db);
?>