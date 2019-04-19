<?php
    $con = connectDB($db);
    $sql='SELECT count(1) total, start FROM schedules where IsCanceled = 1 group by start ORDER BY start';
    $result=mysqli_query($con,$sql);
    if (!$result)
    {
        echo("Error description: " . mysqli_error($con));
    }
    $data2[]='';
    $count=0;
    while ($row = mysqli_fetch_array($result)) {
        extract($row);
        $utcStart = 'Date.UTC('.date('Y',strtotime($start)).','.date('m',strtotime($start)).','.date('d',strtotime($start)).')';
        $data2[] = (($count++!=0)?',':'')."[$utcStart, $total]";
    }
    mysqli_free_result($result);
    mysqli_close($con);
    return $data2;
?>