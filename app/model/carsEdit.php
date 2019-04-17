<?php
    $redirect = '';
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
            $redirect = '?page=cars';
        }
        if(!empty($con)) {
            mysqli_close($con);
        }
    }

    function updateCar($carData,$db) {

    }

    function createOrUpdateCar($carData,$db) {
        if(empty($carData['id'])) {
            createCar($carData,$db);
        } else {
            updateCar($carData,$db);
        }
    }

    if(isset($_POST)){
        createOrUpdateCar($_POST,$db);
    }

    if(!empty($redirect))
        header('location:'.$redirect);
?>