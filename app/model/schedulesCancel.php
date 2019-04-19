<?php
    function cancelSchedule($scheduleId,$db,$origin){
        $con = connectDB($db);
        $sql="update schedules set IsCanceled = 1 where Id=".$scheduleId;
        $result=mysqli_query($con,$sql);
        if (!$result)
        {
            echo("Error description: " . mysqli_error($con));
        }
        mysqli_close($con);
        $redirect = 'location:?page='.$origin;
        header($redirect);
    }  

    if(!empty(get("Id"))) {
        cancelSchedule(get("Id"),$db,get('origin'));  
    }
?>