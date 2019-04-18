<?php
    $con = connectDB($db);
    $sql="SELECT * FROM schedules ORDER BY start desc";
    $result=mysqli_query($con,$sql);
    // Associative arrays
    $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
    $schedules=$allRows;
    // Free result set
    mysqli_free_result($result);

    mysqli_close($con);
    return $schedules;
?>