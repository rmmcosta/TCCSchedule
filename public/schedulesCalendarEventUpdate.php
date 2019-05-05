<?php
    header('Content-Type: application/json');

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
                   $aResult['result'] = updateEventEnd($_POST['arguments'][0], $_POST['arguments'][1]);
               }
               break;
            case 'updateEvent':
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 3) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $aResult['result'] = updateEvent($_POST['arguments'][0], $_POST['arguments'][1], $_POST['arguments'][2]);
               }
               break;
            default:
               $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
               break;
        }

    }

    echo json_encode($aResult);

    function updateEventEnd($end, $id) {
        $con = connectDB($db);
        $sql="update schedules set end = STR_TO_DATE('"
        .$end."','%d/%m/%Y %H:%i') where id = $id";
        $result=mysqli_query($con,$sql);
        mysqli_free_result($result);
        mysqli_close($con);
        return 'update succeed';
    }

    function updateEvent($end, $start, $id) {
        $con = connectDB($db);
        $sql="update schedules set end = STR_TO_DATE('"
        .$end."','%d/%m/%Y %H:%i'), start = STR_TO_DATE('"
        .$start."','%d/%m/%Y %H:%i') where id = $id";
        $result=mysqli_query($con,$sql);
        mysqli_free_result($result);
        mysqli_close($con);
        return 'update succeed';
    }
?>