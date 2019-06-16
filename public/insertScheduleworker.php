<?php
    //construct cars multiselect to use with ajax
    defined("APPLICATION_PATH") || define("APPLICATION_PATH",realpath(dirname('__FILE__')) . '/../app');
    const DS = DIRECTORY_SEPARATOR;

    //inclue config file
    require_once(APPLICATION_PATH.DS.'config'.DS.'config.php');
    
    $workerid = $_GET['workerid'];
    $scheduleid = $_GET['scheduleid'];

    $con = connectDB($db);
    $sql="
            insert into
                    scheduleWorkers
                    (
                        scheduleid,
                        workerid
                    )
            values  (
                        $scheduleid,
                        $workerid
                    )
        ;";
    echo $sql;
    if(!empty($workerid) && !empty($scheduleid)) {
        $execute=mysqli_query($con,$sql);
        mysqli_free_result($execute);
        echo 'inserted record with success!';  
    }
    mysqli_close($con);
?>