<?php
    $redirect = '';
    $worker='';
    function createworker($workerData, $db){
        $con = connectDB($db);
        $query='';
        if(isset($workerData) && !empty($workerData)){
            $query = "insert into workers(name,phone,email) values('"
            .$workerData["name"]."','"
            .$workerData["phone"]."','"
            .$workerData["email"]."');";
        }
        if(!empty($query) && !empty($con)) {
            $execute = mysqli_query($con,$query);
            $feedbackmessage = 'Funcionário <strong>'.$workerData["name"].'</strong> criado com <strong>sucesso</strong>';
            $redirect = 'location:?page=workers&message='.$feedbackmessage.'&type=success';
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        if(!empty($redirect)) {
           header($redirect);
        }
    }

    function updateworker($workerData,$db) {
        $con = connectDB($db);
        $query='';
        if(isset($workerData) && !empty($workerData)){
            $query = "update workers set name='"
            .$workerData["name"]."', phone='"
            .$workerData["phone"]."', email='"
            .$workerData["email"]."' where id =".$workerData["id"].";";
        }
        if(!empty($query) && !empty($con)) {
            $execute = mysqli_query($con,$query);
            $feedbackmessage = 'Funcionário <strong>'.$workerData["name"].'</strong> atualizado com <strong>sucesso</strong>';
            $redirect = 'location:?page=workers&message='.$feedbackmessage.'&type=success';
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        if(!empty($redirect)) {
           header($redirect);
        }
    }

    function createOrUpdateworker($workerData,$db) {
        if(empty($workerData['id'])) {
            createworker($workerData,$db);
        } else {
            updateworker($workerData,$db);
        }
    }

    function getworker($id,$db) {
        $con = connectDB($db);
        $query='';
        if(isset($id) && !empty($id)){
            $query = "Select id, name, phone, email from workers where id =".$id.";";
        }
        if(!empty($query) && !empty($con)) {
            $result = mysqli_query($con,$query);
            $row=mysqli_fetch_assoc($result);
            $worker=$row;
            // Free result set
            mysqli_free_result($result);
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        return $worker;
    }

    if(isset($_POST)){
        createOrUpdateworker($_POST,$db);
    }

    if(!empty(get("Id"))) {
        $worker=getworker(get("Id"),$db);
    }
?>