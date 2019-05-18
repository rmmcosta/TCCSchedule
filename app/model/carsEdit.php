<?php
    $redirect = '';
    $car='';
    function createCar($carData, $db){
        $con = connectDB($db);
        $query='';
        if(isset($carData) && !empty($carData)){
            $query = "insert into cars(maker,model,number,plate) values('"
            .$carData["maker"]."','"
            .$carData["model"]."',"
            .$carData["number"].",'"
            .$carData["plate"]."');";
        }
        if(!empty($query) && !empty($con)) {
            $execute = mysqli_query($con,$query);
            $feedbackmessage = 'Carro <strong>'.$carData["number"].'</strong> criado com <strong>sucesso</strong>';
            $redirect = 'location:?page=cars&message='.$feedbackmessage.'&type=success';
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        if(!empty($redirect)) {
           header($redirect);
        }
    }

    function updateCar($carData,$db) {
        $con = connectDB($db);
        $query='';
        if(isset($carData) && !empty($carData)){
            $query = "update cars set maker='"
            .$carData["maker"]."', model='"
            .$carData["model"]."', number="
            .$carData["number"].",plate='"
            .$carData["plate"]."' where id =".$carData["id"].";";
        }
        if(!empty($query) && !empty($con)) {
            $execute = mysqli_query($con,$query);
            $feedbackmessage = 'Carro <strong>'.$carData["number"].'</strong> atualizado com <strong>sucesso</strong>';
            $redirect = 'location:?page=cars&message='.$feedbackmessage.'&type=success';
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        if(!empty($redirect)) {
           header($redirect);
        }
    }

    function createOrUpdateCar($carData,$db) {
        if(empty($carData['id'])) {
            createCar($carData,$db);
        } else {
            updateCar($carData,$db);
        }
    }

    function getCar($id,$db) {
        $con = connectDB($db);
        $query='';
        if(isset($id) && !empty($id)){
            $query = "Select id, number, maker, model, plate from cars where id =".$id.";";
        }
        if(!empty($query) && !empty($con)) {
            $result = mysqli_query($con,$query);
            $row=mysqli_fetch_assoc($result);
            $car=$row;
            // Free result set
            mysqli_free_result($result);
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
        return $car;
    }

    if(isset($_POST)){
        createOrUpdateCar($_POST,$db);
    }

    if(!empty(get("Id"))) {
        $car=getCar(get("Id"),$db);
    }
?>