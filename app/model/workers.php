<?php
    $listpage = (empty($_GET['listpage'])?$tablelist['defaultpage']:$_GET['listpage']);
    $linecount = (empty($_GET['linecount'])?$tablelist['defaultlinecount']:$_GET['linecount']);
    $search = $_POST['search'];
    $con = connectDB($db);
    $sql="SELECT * FROM workers 
            where name like '%".$search."%'
            or phone like '%".$search."%'
            or email like '%".$search."%'
            ORDER BY name 
            limit $linecount offset ".$listpage*$linecount.";";
    $result=mysqli_query($con,$sql);
    // Associative arrays
    $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
    $list=$allRows;
    // Free result set
    mysqli_free_result($result);
    $sql="SELECT count(1) 
            FROM workers
             where name like '%".$search."%'
             or phone like '%".$search."%'
             or email like '%".$search."%'
            ;";
    $result=mysqli_query($con,$sql);
    $count = mysqli_fetch_row($result)[0];
    mysqli_free_result($result);
    mysqli_close($con);

    $workers = [
        "list"=>$list,
        "count"=>$count
    ];
    return $workers;
?>