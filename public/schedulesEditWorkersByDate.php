<?php
    //construct cars multiselect to use with ajax
    defined("APPLICATION_PATH") || define("APPLICATION_PATH",realpath(dirname('__FILE__')) . '/../app');
    const DS = DIRECTORY_SEPARATOR;

    //inclue config file
    require(APPLICATION_PATH.DS.'config'.DS.'config.php');

    $datetimeStart = $_GET['datetimeStart'];
    $datetimeEnd = $_GET['datetimeEnd'];
    if(empty($datetimeStart) || empty($datetimeEnd)) {
        echo '<select name="cars[]" id="workers-multipleselect" aria-labelledby="dropdownMenuButton"
        multiple="multiple" required><option disabled>Selecione 1.º as datas de início e fim</option></select>';
        return;
    }
    $con = connectDB($db);
    $sql="  SELECT * 
            FROM workers 
            where id not in 
                (   select WorkerId 
                    from schedules 
                    inner join scheduleWorkers
                    on scheduleWorkers.scheduleid = schedules.id
                    where   (str_to_date('$datetimeStart','%d/%m/%Y %H:%i') between start and end)
                            or
                            (str_to_date('$datetimeEnd','%d/%m/%Y %H:%i') between start and end)
                ) 
            ORDER BY name
        ";
    $result=mysqli_query($con,$sql);
    if (!$result)
    {
        echo("Error description: " . mysqli_error($con));
    }
    // Associative arrays
    $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
    $workers=$allRows;
    // Free result set
    mysqli_free_result($result);
    mysqli_close($con);

    $displayMultiselect = '<select name="cars[]" id="workers-multipleselect" aria-labelledby="dropdownMenuButton"
    multiple="multiple" required>';

    foreach($workers AS $worker) {
        $displayMultiselect.='<option value="'.$worker["Id"].'">'.$worker["Name"].'</option>';
    }

    $displayMultiselect.='</select>';

    echo $displayMultiselect;
?>