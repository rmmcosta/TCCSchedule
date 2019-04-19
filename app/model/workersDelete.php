<?php
    function cancelSchedule($workerId,$db,$origin){
        $con = connectDB($db);
        $sql="delete from workers where Id=".$workerId;
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