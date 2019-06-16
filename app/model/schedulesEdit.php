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
            $query = "insert into schedules(start,end,address,endaddress,client,nif,phonenumber,ispaid,notes) values(STR_TO_DATE('"
            .$scheduleData["start"]."','%d/%m/%Y %H:%i'),STR_TO_DATE('"
            .$scheduleData["end"]."','%d/%m/%Y %H:%i'),'"
            .trim($scheduleData["address"])."','"
            .trim($scheduleData["endaddress"])."','"
            .trim($scheduleData["client"])."','"
            .trim($scheduleData["nif"])."','"
            .trim($scheduleData["phone"])."',"
            .($scheduleData["ispaid"]=='on'?1:0).",'"
            .trim($scheduleData["notes"])."');";
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
            $feedbackmessage = 'Mudança criada para <strong>'.$scheduleData["client"].'</strong> com <strong>sucesso</strong>';
            $redirect = 'location:?page=home&message='.$feedbackmessage.'&type=success';
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
            print_r($scheduleData["end"]);
            if($scheduleData["wasclosed"]!=1) {
                $scheduleData["end"] = date("d/m/Y H:i");
            }
            $query = "update schedules set start=STR_TO_DATE('"
            .$scheduleData["start"]."','%d/%m/%Y %H:%i'),end=STR_TO_DATE('"
            .$scheduleData["end"]."','%d/%m/%Y %H:%i'),address='"
            .trim($scheduleData["address"])."', notes='"
            .trim($scheduleData["notes"])."', nif='"
            .trim($scheduleData["nif"])."', phonenumber='"
            .trim($scheduleData["phone"])."', endaddress='"
            .trim($scheduleData["endaddress"])."', ispaid="
            .($scheduleData["ispaid"]=='on'?1:0).", client='"
            .trim($scheduleData["client"])."' where id =".$scheduleData["id"].";";
        }
        print_r($query);
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
            $feedbackmessage = 'Mudança de <strong>'.$scheduleData["client"].'</strong> atualizada com <strong>sucesso</strong>';
            $redirect = 'location:?page=home&message='.$feedbackmessage.'&type=success';
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        if(!empty($redirect)) {
           header($redirect);
        }
    }

    function createOrUpdateschedule($scheduleData,$db) {
        //calculates the end date time according to the start date and the duration
        if(!empty($scheduleData['start']) && !empty($scheduleData['duration'])) {
            //print_r($scheduleData['duration']);
            $scheduleData['duration']=round($scheduleData['duration']*3600,0);
            $startDate = date_create_from_format('d/m/Y H:i',$scheduleData['start']);
            $scheduleData['end'] = 
            date_add(
                date_create_from_format('d/m/Y H:i',$scheduleData['start']), 
                date_interval_create_from_date_string(
                    $scheduleData['duration'].' seconds'
                )
            )->format('d/m/Y H:i');
        }
        //print_r('identificador:'.$scheduleData['id']);
        
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
            $query = "Select id, start, end, address, notes, endaddress, client, nif, ispaid, phonenumber from schedules where id =".$id.";";
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

        //is the schedule closed?
        if(!empty($schedule['end'])) {
            $currdatetime = getCurrDatetime();
            if(differenceInSeconds($schedule['end'],$currdatetime)>0) {
                $schedule['isclosed'] = true;
            }
        }
        
        return $schedule;
    }

    function getScheduleCars($id,$db) {
        $con = connectDB($db);
        $query='';
        if(isset($id) && !empty($id)){
            $query = "Select CarId, number from scheduleCars inner join cars on cars.id = scheduleCars.carid where ScheduleId =".$id.";";
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
            $query = "Select WorkerId, name from scheduleWorkers inner join workers on workers.id = scheduleWorkers.workerid where ScheduleId =".$id.";";
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

    if(isset($_POST)&&!empty($_POST)){
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