<?php
    //construct cars multiselect to use with ajax
    defined("APPLICATION_PATH") || define("APPLICATION_PATH",realpath(dirname('__FILE__')) . '/../app');
    const DS = DIRECTORY_SEPARATOR;

    //inclue config file
    require(APPLICATION_PATH.DS.'config'.DS.'config.php');

    $workerid = $_GET['workerid'];
    //print_r($workerid);
    $con = connectDB($db);

    $sql="
            SELECT  schedules.id id,
                    client,
                    start,
                    (
                        SELECT  GROUP_CONCAT(distinct number order by number SEPARATOR ', ')
                        FROM    scheduleCars
                                inner join cars
                                on cars.id = scheduleCars.carid
                        where   scheduleCars.scheduleid = schedules.id
                    ) cars,
                    address,
                    endaddress
            from    schedules
            where   not exists (Select  1 
                            from    scheduleWorkers 
                            where   workerid = $workerid
                                    and scheduleid = schedules.id
                        )
                    and ifnull(schedules.iscanceled,0) = 0
                    and end > sysdate()
            order by
                    start
        ;";
    //print_r($sql);
    $result=mysqli_query($con,$sql);
    if (!$result)
    {
        echo("Error description: " . mysqli_error($con));
    }
    // Associative arrays
    $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
    $availableschedules=$allRows;
    // Free result set
    mysqli_free_result($result);

    mysqli_close($con);   

    $displayList = '
    <div class="table-responsive">
        <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Início</th>
                <th scope="col">Cliente</th>
                <th scope="col">Carros</th>
                <th scope="col">Carga</th>
                <th scope="col">Descarga</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>';
    
    foreach($availableschedules AS $availableschedule) {
        $displayList.='<tr class="table-row" data-href="?page=schedulesEdit&Id='.$availableschedule['id'].'">';
        $displayList.='<td>'.$availableschedule['start'].'</td>';
        $displayList.='<td>'.$availableschedule['client'].'</td>';
        $displayList.='<td>'.$availableschedule['cars'].'</td>';
        $displayList.='<td>'.$availableschedule['address'].'</td>';
        $displayList.='<td>'.$availableschedule['endaddress'].'</td>';
        $displayList.='<td class="text-success"><a class="addWorker" title="Colocar na Mudança" data-id='.$availableschedule['id'].'><i class="text-success fas fa-plus"></i></a></td>';
        $displayList.='</tr>';
    }

    $displayList.= '</tbody></table>';
    if(empty($availableschedules)){
        $displayList.='<tr><td><div class="blank-slate">Não há Mudanças disponíveis</div></td></tr>';
    }
    $displayList.='</div>';

    echo $displayList;
?>