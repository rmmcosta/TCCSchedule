<?php
    $redirect = '';
    $schedule='';

    function createScheduleCars($cars,$con,$scheduleId) {
        if(isset($cars) && !empty($cars)){
            $query = "insert into scheduleCars (ScheduleId, CarId)";
            for($i=0;$i<sizeof($cars);$i++) {
                $query .= (($i!=0)?",":"")." values (".$scheduleId.','.$car.')';
            } 
            $query.=';';
            if(!empty($query) && !empty($con)) {
                echo $query;
                $execute = mysqli_query($con,$query);
            }     
        }
    }

    function createScheduleWorkers($workers,$con,$scheduleId) {
        if(isset($workers) && !empty($workers)){
            $query = "insert into scheduleWorkers (ScheduleId, WorkerId)";
            for($i=0;$i<sizeof($cars);$i++) {
                $query .= (($i!=0)?",":"")." values (".$scheduleId.','.$worker.')';
            }  
            $query.=';';
            if(!empty($query) && !empty($con)) {
                echo $query;
                $execute = mysqli_query($con,$query);
            }   
        }
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
            $scheduleId = mysqli_insert_id($con);
            createScheduleCars($scheduleData['cars'],$con,$scheduleId);
            createScheduleWorkers($scheduleData['workers'],$con,$scheduleId);
            //$redirect = 'location:?page=schedules';
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
            $query = "update schedules set start='"
            .$scheduleData["start"]."', end='"
            .$scheduleData["end"]."', address='"
            .$scheduleData["address"]."', notes='"
            .$scheduleData["notes"]."' where id =".$scheduleData["id"].";";
        }
        if(!empty($query) && !empty($con)) {
            $execute = mysqli_query($con,$query);
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
            $query = "Select id, start, end, addres, notes from schedules where id =".$id.";";
        }
        if(!empty($query) && !empty($con)) {
            $result = mysqli_query($con,$query);
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

    function getCarsAvailable($db){
        $con = connectDB($db);
        $sql="SELECT * FROM cars ORDER BY number";
        $result=mysqli_query($con,$sql);
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
    }
    $dropDowns = [
        "carsAvailable" => getCarsAvailable($db),
        "workersAvailable" => getWorkersAvailable($db)
    ];
    return $dropDowns;
?>