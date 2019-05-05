<?php
    function getSchedulesCalendar($db) {
        $con = connectDB($db);
        $sql="SELECT id, client, start, iscanceled, end FROM schedules";
        $result=mysqli_query($con,$sql);
        // Associative arrays
        $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
        $schedules=$allRows;
        // Free result set
        mysqli_free_result($result);

        mysqli_close($con);
        $events = "{title:'Nova Marcação', start:'".date("Y-m-d")."', url:'?page=schedulesEdit', color:'#AB67E8', editable:false}";

        foreach($schedules as $schedule) {
            $events.=",{id:'".$schedule['id']."',
                title:'".$schedule['client']."', 
                start:'".$schedule['start']."',  
                end:'".$schedule['end']."', 
                url:'?page=schedulesEdit&Id=".$schedule['id']."',
                color: '".($schedule['iscanceled']?'gray':($schedule['start']>date('Y-m-d H:i:s')?'green':'#356cc4'))."',
                editable:".($schedule['iscanceled']?'false':($schedule['start']>date('Y-m-d H:i:s')?'true':'false'))."
            }";
        }
        return $events;
    }
?>