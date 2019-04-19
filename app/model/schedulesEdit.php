<?php
    $redirect = '';
    $schedule='';
    $scheduleCars='';
    $scheduleWorkers='';
    function createScheduleCars($cars,$con,$scheduleId) {
        if(isset($cars) && !empty($cars)) {
            for($i=0;$i<sizeof($cars);$i++) {
                $query = "insert into scheduleCars (ScheduleId, CarId) values (".$scheduleId.','.$cars[$i].')';
                if(!empty($query) && !empty($con)) {
                    $execute = mysqli_query($con,$query);
                    if (!$execute)
                    {
                        echo("Error description: " . mysqli_error($con));
                    }
                }
            }     
        }
    }

    function createScheduleWorkers($workers,$con,$scheduleId) {
        if(isset($workers) && !empty($workers)){
            for($i=0;$i<sizeof($workers);$i++) {
                $query = 'insert into scheduleWorkers (ScheduleId, WorkerId) values ('.$scheduleId.','.$workers[$i].');';
                if(!empty($query) && !empty($con)) {
                    $execute = mysqli_query($con,$query);
                    if (!$execute)
                    {
                        echo("Error description: " . mysqli_error($con));
                    }
                }
            }  
        }
    }

    function deleteScheduleCars($scheduleId,$con) {
        $query = 'delete from scheduleCars where ScheduleId = '.$scheduleId;
        $execute = mysqli_query($con,$query);
        if (!$execute)
        {
            echo("Error description: " . mysqli_error($con));
        }
    }

    function deleteScheduleWorkers($scheduleId,$con) {
        $query = 'delete from scheduleWorkers where ScheduleId = '.$scheduleId;
        $execute = mysqli_query($con,$query);
    }

    function createschedule($scheduleData, $db){
        $con = connectDB($db);
        $query='';
        if(isset($scheduleData) && !empty($scheduleData)){
            $query = "insert into schedules(start,end,address,notes) values(STR_TO_DATE('"
            .$scheduleData["start"]."','%d/%m/%Y %H:%i'),STR_TO_DATE('"
            .$scheduleData["end"]."','%d/%m/%Y %H:%i'),'"
            .$scheduleData["address"]."','"
            .$scheduleData["notes"]."');";
        }
        if(!empty($query) && !empty($con)) {
            $execute = mysqli_query($con,$query);
            if (!$execute)
            {
                echo("Error description: " . mysqli_error($con));
            }
            $scheduleId = mysqli_insert_id($con);
            createScheduleCars($scheduleData['cars'],$con,$scheduleId);
            createScheduleWorkers($scheduleData['workers'],$con,$scheduleId);
            $redirect = 'location:?page=schedules';
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        if(!empty($redirect)) {
           header($redirect);
        }
    }

    function updateschedule($scheduleData,$db) {
        $con = connectDB($db);
        $query='';
        if(isset($scheduleData) && !empty($scheduleData)){
            $query = "update schedules set start=STR_TO_DATE('"
            .$scheduleData["start"]."','%d/%m/%Y %H:%i'),end=STR_TO_DATE('"
            .$scheduleData["end"]."','%d/%m/%Y %H:%i'),address='"
            .$scheduleData["address"]."', notes='"
            .$scheduleData["notes"]."' where id =".$scheduleData["id"].";";
        }
        if(!empty($query) && !empty($con)) {
            $execute = mysqli_query($con,$query);
            if (!$execute)
            {
                echo("Error description: " . mysqli_error($con));
            }
            deleteScheduleCars($scheduleData["id"],$con);
            deleteScheduleWorkers($scheduleData["id"],$con);
            createScheduleCars($scheduleData['cars'],$con,$scheduleData["id"]);
            createScheduleWorkers($scheduleData['workers'],$con,$scheduleData["id"]);
            $redirect = 'location:?page=schedules';
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        if(!empty($redirect)) {
           header($redirect);
        }
    }

    function createOrUpdateschedule($scheduleData,$db) {
        if(empty($scheduleData['id'])) {
            createschedule($scheduleData,$db);
        } else {
            updateschedule($scheduleData,$db);
        }
    }

    function getschedule($id,$db) {
        $con = connectDB($db);
        $query='';
        if(isset($id) && !empty($id)){
            $query = "Select id, start, end, address, notes from schedules where id =".$id.";";
        }
        if(!empty($query) && !empty($con)) {
            $result = mysqli_query($con,$query);
            if (!$result)
            {
                echo("Error description: " . mysqli_error($con));
            }
            $row=mysqli_fetch_assoc($result);
            $schedule=$row;
            // Free result set
            mysqli_free_result($result);
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        return $schedule;
    }

    function getScheduleCars($id,$db) {
        $con = connectDB($db);
        $query='';
        if(isset($id) && !empty($id)){
            $query = "Select CarId from scheduleCars where ScheduleId =".$id.";";
        }
        if(!empty($query) && !empty($con)) {
            $result = mysqli_query($con,$query);
            if (!$result)
            {
                echo("Error description: " . mysqli_error($con));
            }
            $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
            $scheduleCars=$allRows;
            // Free result set
            mysqli_free_result($result);
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        return $scheduleCars;
    }

    function getScheduleWorkers($id,$db) {
        $con = connectDB($db);
        $query='';
        if(isset($id) && !empty($id)){
            $query = "Select WorkerId from scheduleWorkers where ScheduleId =".$id.";";
        }
        if(!empty($query) && !empty($con)) {
            $result = mysqli_query($con,$query);
            if (!$result)
            {
                echo("Error description: " . mysqli_error($con));
            }
            $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
            $scheduleWorkers=$allRows;
            // Free result set
            mysqli_free_result($result);
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        return $scheduleWorkers;
    }

    function getCarsAvailable($db){
        $con = connectDB($db);
        $sql="SELECT * FROM cars ORDER BY number";
        $result=mysqli_query($con,$sql);
        if (!$result)
        {
            echo("Error description: " . mysqli_error($con));
        }
        // Associative arrays
        $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
        $cars=$allRows;
        // Free result set
        mysqli_free_result($result);

        mysqli_close($con);
        return $cars;
    }

    function getWorkersAvailable($db){
        $con = connectDB($db);
        $sql="SELECT * FROM workers ORDER BY name";
        $result=mysqli_query($con,$sql);
        if (!$result)
        {
            echo("Error description: " . mysqli_error($con));
        }
        // Associative arrays
        $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
        $workers=$allRows;
        // Free result set
        mysqli_free_result($result);

        mysqli_close($con);
        return $workers;
    }

    if(isset($_POST)){
        createOrUpdateschedule($_POST,$db);
    }

    if(!empty(get("Id"))) {
        $schedule=getschedule(get("Id"),$db);
        $scheduleCars=getscheduleCars(get("Id"),$db);
        $scheduleWorkers=getscheduleWorkers(get("Id"),$db);
    }
    $scheduleData = [
        "carsAvailable" => getCarsAvailable($db),
        "workersAvailable" => getWorkersAvailable($db),
        "schedule" => $schedule,
        "scheduleCars" => $scheduleCars,
        "scheduleWorkers" => $scheduleWorkers
    ];
    return $scheduleData;
?>