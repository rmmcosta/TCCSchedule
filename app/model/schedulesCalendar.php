<?php
    function getSchedulesCalendar($db) {
        $con = connectDB($db);
        $sql="SELECT id, client, start, end FROM schedules";
        $result=mysqli_query($con,$sql);
        // Associative arrays
        $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
        $schedules=$allRows;
        // Free result set
        mysqli_free_result($result);

        mysqli_close($con);
        $events = "{title:'Nova Marcação', start:'".date("Y-m-d")."', url:'?page=schedulesEdit'}";

        foreach($schedules as $schedule) {
            $events.=",{title:'".$schedule['client']."', 
                start:'".$schedule['start']."',  
                end:'".$schedule['end']."', 
                url:'?page=schedulesEdit&Id=".$schedule['id']."'}";
        }
        return $events;
    }
?>