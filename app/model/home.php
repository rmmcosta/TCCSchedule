<?php
    function getSchedulesCalendar($db) {
        $con = connectDB($db);
        $sql="SELECT 
        (SELECT GROUP_CONCAT(number order by number SEPARATOR ', ')
        FROM    scheduleCars
                inner join cars
                on cars.id = scheduleCars.CarId
        where scheduleCars.scheduleid=schedules.id) as cars, 
        (SELECT GROUP_CONCAT(name order by name SEPARATOR ', ')
        FROM    scheduleWorkers
                inner join workers
                on workers.id = scheduleWorkers.WorkerId
        where scheduleWorkers.scheduleid=schedules.id) as workers, 
        id, client, start, iscanceled, end, Address, EndAddress, IsPaid FROM schedules";
        //print_r($sql);
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
                title:'[ ".$schedule['cars'].' ] '.$schedule['client'].
                date_format(date_create_from_format('Y-m-d H:i:s',$schedule['start'])," H:i").
                date_format(date_create_from_format('Y-m-d H:i:s',$schedule['end'])," - H:i").
                ' ('.$schedule['workers'].' )'.
                "',
                description:'Cliente:".$schedule['client'].'\nFuncionários:'.$schedule['workers'].'\nCarga: '.
                preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $schedule['Address']).
                '\nDescarga: '.
                preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $schedule['EndAddress']).'\n'.
                date_format(date_create_from_format('Y-m-d H:i:s',$schedule['start'])," H:i").
                date_format(date_create_from_format('Y-m-d H:i:s',$schedule['end'])," - H:i").
                "', 
                start:'".$schedule['start']."',  
                end:'".$schedule['end']."', 
                url:'?page=schedulesEdit&Id=".$schedule['id']."',
                color: '".getColor($schedule['start'],$schedule['end'],$schedule['iscanceled'],$schedule['IsPaid'])."',
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

    function getColor($startDate, $endDate, $isCanceled, $isPaid) {
        if($isCanceled)
            return 'gray';
        if($startDate>date('Y-m-d H:i:s'))
            return '#0077ff';
        if($endDate>date('Y-m-d H:i:s'))
            return '#095ab7';
        if(!$isPaid)
            return '#5c0a0a';
        return 'green';
    }

    function getWorkersAndScheduleCars($date,$db) {
        $con = connectDB($db);
        $sql="SELECT 
        (   SELECT  GROUP_CONCAT(distinct number order by number SEPARATOR ', ')
            FROM    scheduleWorkers
                    inner join scheduleCars
                    on scheduleCars.scheduleid = scheduleWorkers.scheduleid
                    inner join cars
                    on cars.id = scheduleCars.CarId
                    inner join schedules
                    on schedules.id = scheduleWorkers.scheduleid
            where   scheduleWorkers.workerid = workers.id
                    and DATE_FORMAT(schedules.start, '%d/%m/%Y') = DATE_FORMAT(str_to_date('$date','%d/%m/%Y'), '%d/%m/%Y')
            ) as cars,
        id, name FROM workers;";
        //print_r($sql);
        $result=mysqli_query($con,$sql);
        // Associative arrays
        $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
        $workers=$allRows;
        // Free result set
        mysqli_free_result($result);

        mysqli_close($con);

        return $workers;
    }
?>