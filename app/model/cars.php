<?php
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
?>