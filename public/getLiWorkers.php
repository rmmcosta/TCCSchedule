<?php
    //construct cars multiselect to use with ajax
    defined("APPLICATION_PATH") || define("APPLICATION_PATH",realpath(dirname('__FILE__')) . '/../app');
    const DS = DIRECTORY_SEPARATOR;

    //inclue config file
    require_once(APPLICATION_PATH.DS.'config'.DS.'config.php');
    require_once(APPLICATION_PATH.DS.'model'.DS.'sideNav.php');

    $displayLiWorkers = '';
    $sideworkers = getWorkersAndScheduleCars(date('d/m/Y'),$db);
    foreach($sideworkers as $sideworker){
      $displayLiWorkers.= '<li onclick="refreshWorkerId('.$sideworker['id'].',\''.$sideworker['name'].'\')" data-toggle="modal" data-target="#workersModal">'.$sideworker['name'].''.(empty($sideworker['cars'])?'':'<ul><li>'.$sideworker['cars'].'</li></ul>').'</li>';
    }

    echo $displayLiWorkers;
?>