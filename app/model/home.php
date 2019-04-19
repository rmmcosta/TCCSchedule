<?php
    date_default_timezone_set('Europe/Lisbon');
    $con = connectDB($db);
    $sql='SELECT * FROM schedules where end>'.time().' and ifnull(IsCanceled,0) = 0 ORDER BY start desc';
    $result=mysqli_query($con,$sql);
    if (!$result)
    {
        echo("Error description: " . mysqli_error($con));
    }
    // Associative arrays
    $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
    $schedulesFuture=$allRows;
    // Free result set
    mysqli_free_result($result);

    $sql='SELECT * FROM schedules where start<='.time().' and end>='.time().' and ifnull(IsCanceled,0) = 0 ORDER BY start desc';
    $result=mysqli_query($con,$sql);
    if (!$result)
    {
        echo("Error description: " . mysqli_error($con));
    }
    // Associative arrays
    $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
    $schedulesOnGoing=$allRows;
    // Free result set
    mysqli_free_result($result);

    mysqli_close($con);
    $schedules = [
        "future" => $schedulesFuture,
        "ongoing" => $schedulesOnGoing
    ];
    return $schedules;
?>