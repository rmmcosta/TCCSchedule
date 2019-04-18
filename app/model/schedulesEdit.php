<?php
    $redirect = '';
    $schedule='';
    function createschedule($scheduleData, $db){
        $con = connectDB($db);
        $query='';
        if(isset($scheduleData) && !empty($scheduleData)){
            $query = "insert into schedules(start,end,address,notes) values('"
            .$scheduleData["start"]."','"
            .$scheduleData["end"]."','"
            .$scheduleData["address"]."','"
            .$scheduleData["notes"]."');";
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

    if(isset($_POST)){
        createOrUpdateschedule($_POST,$db);
    }

    if(!empty(get("Id"))) {
        $schedule=getschedule(get("Id"),$db);
    }
?>