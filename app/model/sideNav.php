<?php
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
        id, name FROM workers order by name;";
        //print_r($sql);
        $result=mysqli_query($con,$sql);
        // Associative arrays
        $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
        $sideworkers=$allRows;
        // Free result set
        mysqli_free_result($result);

        mysqli_close($con);

        return $sideworkers;
    }

    function getAvailableSchedules($workerId,$db) {
        $con = connectDB($db);
        $sql="
            SELECT  schedules.id,
                    client,
                    start,
                    end,
                    address,
                    endaddress
            from    schedules
            where   not exists (Select  1 
                            from    scheduleWorkers 
                            where   workerid = $workerId
                                    and scheduleid = schedules.id
                        )
                    and ifnull(schedules.iscanceled,0) = 0
            order by
                    start
        ;";
        //print_r($sql);
        $result=mysqli_query($con,$sql);
        // Associative arrays
        $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
        $availableschedules=$allRows;
        // Free result set
        mysqli_free_result($result);

        mysqli_close($con);

        return $availableschedules;
    }

    function deleteScheduleworker($workerId,$scheduleId,$db) {
        $con = connectDB($db);
        $sql="
            delete from 
                    scheduleWorkers
            where   workerid = $workerId
                    and scheduleid = $scheduleId
        ;";
        //print_r($sql);
        $execute=mysqli_query($con,$sql);
        if (!$execute)
        {
            echo("Error description: " . mysqli_error($con));
        }
        // Free result set
        mysqli_free_result($execute);

        mysqli_close($con);
    }

    function insertScheduleworker($workerId,$scheduleId,$db) {
        $con = connectDB($db);
        $sql="
            insert into
                    scheduleWorkers
                    (
                        scheduleid,
                        workerid
                    )
            values  (
                        $scheduleId,
                        $workerId
                    )
        ;";
        //print_r($sql);
        $execute=mysqli_query($con,$sql);
        if (!$execute)
        {
            echo("Error description: " . mysqli_error($con));
        }
        // Free result set
        mysqli_free_result($execute);

        mysqli_close($con);
    }
?>