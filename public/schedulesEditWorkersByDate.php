<?php
    //construct cars multiselect to use with ajax
    defined("APPLICATION_PATH") || define("APPLICATION_PATH",realpath(dirname('__FILE__')) . '/../app');
    const DS = DIRECTORY_SEPARATOR;

    //inclue config file
    require_once(APPLICATION_PATH.DS.'config'.DS.'config.php');

    $datetimeStart = $_GET['datetimeStart'];
    $datetimeEnd = $_GET['datetimeEnd'];
    if(empty($datetimeStart) || empty($datetimeEnd)) {
        echo '<select name="cars[]" id="workers-multipleselect" aria-labelledby="dropdownMenuButton"
        multiple="multiple" required><option disabled>Selecione 1.º as datas de início e fim</option></select>';
        return;
    }
    $con = connectDB($db);
    $scheduleId = get("Id");
    $sql="  SELECT * 
            FROM workers 
            where ";
    if(!empty($scheduleId)) {
        $sql.="exists (Select 1 from scheduleWorkers where scheduleWorkers.WorkerId = workers.Id and scheduleWorkers.ScheduleId = $scheduleId)
        or ";
    }
    $sql.="id not in 
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
    $scheduleWorkers = '';
    if(!empty($scheduleId)) {
        $sql = 'Select WorkerId from scheduleWorkers where scheduleWorkers.ScheduleId = '.$scheduleId;
        $result=mysqli_query($con,$sql);
        if (!$result)
        {
            echo("Error description: " . mysqli_error($con));
        }
        // Associative arrays
        $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
    } else {
        $allRows = '';
    }
    
    $scheduleWorkers = $allRows;

    // Free result set
    mysqli_free_result($result);
    mysqli_close($con);

    $displayMultiselect = '<select name="workers[]" id="workers-multipleselect" aria-labelledby="dropdownMenuButton"
    multiple="multiple" required>';

    foreach($workers AS $worker) {
        $displayMultiselect.='<option '.((isArrayValueInArrayOfArray($scheduleWorkers,[$worker["Id"]]))?"selected":"").' value="'.$worker["Id"].'">'.$worker["Name"].'</option>';
    }

    $displayMultiselect.='</select>';

    echo $displayMultiselect;
?>