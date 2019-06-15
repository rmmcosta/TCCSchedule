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
?>