<?php
    $listpage = (empty($_GET['listpage'])?$tablelist['defaultpage']:$_GET['listpage']);
    $linecount = (empty($_GET['linecount'])?$tablelist['defaultlinecount']:$_GET['linecount']);
    $search = $_POST['submitbutton']=='clear'?'':$_POST['search'];
    $con = connectDB($db);
    $sql="select 	dates.currdate,
    (	select GROUP_CONCAT(DISTINCT workers.Name)
        from 	schedules
                 inner join scheduleWorkers
                 on scheduleWorkers.ScheduleId = schedules.id
                 inner join workers
                 on workers.id = scheduleWorkers.WorkerId
         where 	date(schedules.Start) = date(dates.currdate)
                 OR
                 date(schedules.End) = date(dates.currdate)
    ) workers, 
    (	select count(distinct scheduleWorkers.workerid)
        from schedules
             inner join scheduleWorkers
             on scheduleWorkers.ScheduleId = schedules.id
         where 	date(schedules.Start) = date(dates.currdate)
                 OR
                 date(schedules.End) = date(dates.currdate)
    ) workerstotal,
    (	select GROUP_CONCAT(DISTINCT cars.Number)
        from 	schedules
                 inner join scheduleCars
                 on scheduleCars.ScheduleId = schedules.id
                 inner join cars
                 on cars.id = scheduleCars.CarId
         where 	date(schedules.Start) = date(dates.currdate)
                 OR
                 date(schedules.End) = date(dates.currdate)
    ) cars, 
    (	select count(distinct scheduleCars.carid)
        from schedules
             inner join scheduleCars
             on scheduleCars.ScheduleId = schedules.id
         where 	date(schedules.Start) = date(dates.currdate)
                 OR
                 date(schedules.End) = date(dates.currdate)
    ) carstotal
from (	select a.Date currdate
from (
    select DATE_ADD(CURRENT_DATE(),INTERVAL 10 DAY) - INTERVAL (a.a + (10 * b.a) + (100 * c.a) + (1000 * d.a) ) DAY as Date
    from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
    cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
    cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
    cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as d
) a
where a.Date between DATE_ADD(CURRENT_DATE(),INTERVAL -5 DAY) and DATE_ADD(CURRENT_DATE(),INTERVAL 10 DAY)
) dates
order by currdate desc
limit $linecount offset ".$listpage*$linecount.";";
    $result=mysqli_query($con,$sql);
    // Associative arrays
    $allRows=mysqli_fetch_all($result,MYSQLI_ASSOC);
    $list=$allRows;
    // Free result set
    mysqli_free_result($result);

    $sql="select count(1)
	from (
		select DATE_ADD(CURRENT_DATE(),INTERVAL 10 DAY) - INTERVAL (a.a + (10 * b.a) + (100 * c.a) + (1000 * d.a) ) DAY as Date
		from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
		cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
		cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
		cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as d
	) a
	where a.Date between DATE_ADD(CURRENT_DATE(),INTERVAL -5 DAY) and DATE_ADD(CURRENT_DATE(),INTERVAL 10 DAY)
        ";
    $result=mysqli_query($con,$sql);
    $count = mysqli_fetch_row($result)[0];
    mysqli_free_result($result);
    mysqli_close($con);

    $dailies = [
        "list"=>$list,
        "count"=>$count
    ];
    return $dailies;
?>