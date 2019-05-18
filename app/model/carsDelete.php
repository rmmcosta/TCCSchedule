<?php
    function cancelSchedule($carId,$db,$origin){
        $con = connectDB($db);
        $sql="delete from cars where Id=".$carId;
        $result=mysqli_query($con,$sql);
        if (!$result)
        {
            echo("Error description: " . mysqli_error($con));
        }
        mysqli_close($con);
        $feedbackmessage = 'Carro <strong>eliminado</strong>';
        $redirect = 'location:?page='.$origin.'&message='.$feedbackmessage.'&type=success';
        header($redirect);
    }  

    if(!empty(get("Id"))) {
        cancelSchedule(get("Id"),$db,get('origin'));  
    }
?>