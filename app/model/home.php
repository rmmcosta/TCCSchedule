<?php
    function getSchedulesCalendar($db) {
        $con = connectDB($db);
        $sql="SELECT id, client, start, iscanceled, end, Address, EndAddress FROM schedules";
        $result=mysqli_query($con,$sql);
        // Associative arrays
        $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
        $schedules=$allRows;
        // Free result set
        mysqli_free_result($result);

        mysqli_close($con);
        $events = "{}";

        foreach($schedules as $schedule) {
            $events.=",{id:'".$schedule['id']."',
                title:'".$schedule['client']."',
                description:'De:".preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $schedule['Address']).'\nPara:'.preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $schedule['EndAddress'])."', 
                start:'".$schedule['start']."',  
                end:'".$schedule['end']."', 
                url:'?page=schedulesEdit&Id=".$schedule['id']."',
                color: '".getColor($schedule['start'],$schedule['end'],$schedule['iscanceled'])."',
                editable:".getIsEditable($schedule['start'],$schedule['end'],$schedule['iscanceled'])."
            }";
        }
        return $events;
    }

    function getIsEditable($startDate, $endDate, $isCanceled) {
        if($isCanceled)
            return 'false';
        if($startDate>date('Y-m-d H:i:s'))
            return 'true';
        if($endDate>date('Y-m-d H:i:s'))
            return 'true';
        return 'false';
    }

    function getColor($startDate, $endDate, $isCanceled) {
        if($isCanceled)
            return 'gray';
        if($startDate>date('Y-m-d H:i:s'))
            return 'green';
        if($endDate>date('Y-m-d H:i:s'))
            return '#28a745';
        return '#356cc4';
    }
?>