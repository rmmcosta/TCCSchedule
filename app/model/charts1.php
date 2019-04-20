<?php
    $con = connectDB($db);
    $sql='SELECT count(1) total, CAST(start AS DATE) start FROM schedules where ifnull(IsCanceled,0) = 0 group by CAST(start AS DATE) ORDER BY start';
    $result=mysqli_query($con,$sql);
    if (!$result)
    {
        echo("Error description: " . mysqli_error($con));
    }
    $data1[]='';
    $count=0;
    while ($row = mysqli_fetch_array($result)) {
        extract($row);
        $utcStart = 'Date.UTC('.date('Y',strtotime($start)).','.date('m',strtotime($start)).','.date('d',strtotime($start)).')';
        $data1[] = (($count++!=0)?',':'')."[$utcStart, $total]";
    }
    mysqli_free_result($result);
    mysqli_close($con);
    return $data1;
?>