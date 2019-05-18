<?php
    header('Content-Type: application/json');

    //construct cars multiselect to use with ajax
    defined("APPLICATION_PATH") || define("APPLICATION_PATH",realpath(dirname('__FILE__')) . '/../app');
    const DS = DIRECTORY_SEPARATOR;

    //inclue config file
    require(APPLICATION_PATH.DS.'config'.DS.'config.php');

    $aResult = array();

    if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

    if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

    if( !isset($aResult['error']) ) {

        switch($_POST['functionname']) {
            case 'updateEventEnd':
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $aResult['result'] = updateEventEnd($_POST['arguments'][0], $_POST['arguments'][1],$db);
               }
               break;
            case 'updateEvent':
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 3) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $aResult['result'] = updateEvent($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2],$db);
               }
               break;
            default:
               $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
               break;
        }

    }

    echo json_encode($aResult);

    function updateEventEnd($end, $id, $db) {
        $con = connectDB($db);
        $sql="update schedules set end = STR_TO_DATE('"
        .$end."','%Y-%m-%d %H:%i:%s') where id = $id";
        if(!empty($sql) && !empty($con)) {
            $execute = mysqli_query($con,$sql);
            if (!$execute)
            {
                return "Error description: " . mysqli_error($con);
            }
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        $_GET['message']="Mudança atualizada";
        $_GET['type']="success";
        return 'update succeed';
    }

    function updateEvent($start, $end, $id, $db) {
        $con = connectDB($db);
        $sql="update schedules set end = STR_TO_DATE('"
        .$end."','%Y-%m-%d %H:%i:%s'), start = STR_TO_DATE('"
        .$start."','%Y-%m-%d %H:%i:%s') where id = $id";
        if(!empty($sql) && !empty($con)) {
            $execute = mysqli_query($con,$sql);
            if (!$execute)
            {
                return "Error description: " . mysqli_error($con);
            }
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        $_GET['message']="Mudança atualizada";
        $_GET['type']="success";
        return 'update succeed';
    }
?>