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
            where   exists (Select  1 
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
    $schedulesbyworker=$allRows;
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
    
    foreach($schedulesbyworker AS $schedulebyworker) {
        $displayList.='<tr class="table-row" data-href="?page=schedulesEdit&Id='.$schedulebyworker['id'].'">';
        $displayList.='<td>'.$schedulebyworker['start'].'</td>';
        $displayList.='<td>'.$schedulebyworker['client'].'</td>';
        $displayList.='<td>'.$schedulebyworker['cars'].'</td>';
        $displayList.='<td>'.$schedulebyworker['address'].'</td>';
        $displayList.='<td>'.$schedulebyworker['endaddress'].'</td>';
        $displayList.='<td class="text-danger"><a class="removeWorker" title="Remover da Mudança" data-id='.$schedulebyworker['id'].'><i class="text-danger fas fa-minus"></i></a></td>';
        $displayList.='</tr>';
    }

    $displayList.= '</tbody></table>';
    if(empty($schedulesbyworker)){
        $displayList.='<tr><td><div class="blank-slate">Não tem Mudanças</div></td></tr>';
    }
    $displayList.='</div>';

    echo $displayList;
?>