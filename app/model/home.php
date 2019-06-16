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
        $events = array();

        foreach($schedules as $schedule) {
            $e = array();
            $e['id']=$schedule['id'];
            $e['title']='['.$schedule['cars'].'] '.$schedule['client'].' '.
                date_format(date_create_from_format('Y-m-d H:i:s',$schedule['start'])," H:i").
                date_format(date_create_from_format('Y-m-d H:i:s',$schedule['end'])," - H:i").
                ' ('.$schedule['workers'].' )';
            $e['description']='Cliente:'.$schedule['client'].' Funcionários:'.$schedule['workers'].' Carga: '.
                preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $schedule['Address']).
                ' Descarga: '.
                preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $schedule['EndAddress']).''.
                date_format(date_create_from_format('Y-m-d H:i:s',$schedule['start'])," H:i").
                date_format(date_create_from_format('Y-m-d H:i:s',$schedule['end'])," - H:i"); 
            $e['start']=$schedule['start']; 
            $e['end']=$schedule['end'];
            $e['url']='?page=schedulesEdit&Id='.$schedule['id'];
            $e['color']=getColor($schedule['start'],$schedule['end'],$schedule['iscanceled'],$schedule['IsPaid']);
            $e['editable']=getIsEditable($schedule['start'],$schedule['end'],$schedule['iscanceled']);
            array_push($events, $e);
        }
        return json_encode($events);
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
?>