<?php
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
?>