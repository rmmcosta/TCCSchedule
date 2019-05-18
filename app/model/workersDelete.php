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
        $feedbackmessage = 'Funcionário <strong>eliminado</strong>';
        $redirect = 'location:?page='.$origin.'&message='.$feedbackmessage.'&type=success';
        header($redirect);
    }  

    if(!empty(get("Id"))) {
        cancelSchedule(get("Id"),$db,get('origin'));  
    }
?>