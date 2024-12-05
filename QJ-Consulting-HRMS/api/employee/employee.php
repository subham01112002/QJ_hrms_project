<?php
    session_start();
    if(!(isset($_SESSION['employee'])))
    {
        exit();
    }
    include("./../../connection/connection.php");
    $sortingOrders = ["ASC", "DESC"];
    $empID = $_SESSION['employee'];
    if((int) $_REQUEST['primary-filter'] != 0 && (int) $_REQUEST['secondary-filter'] != 0)
    {
        $i = (int) $_REQUEST['primary-filter'] - 1;
        $j = (int) $_REQUEST['secondary-filter'];
        $inMonth = (int) $_REQUEST['in-month'];
        $inYear = (int) $_REQUEST['in-year'];
        $k = (int) $_REQUEST['sorting-order'];
        $primaryFilters = ["pm.`project_id`", "tm.`task_id`"];
        $query = "SELECT
                    ptm.`date`,
                    pm.`title` AS project_title,
                    tm.`title` AS tm_title,
                    stm.`title` AS stm_title,
                    ptm.`start_time`,
                    ptm.`end_time`,
                    ptm.`total`,
                    ptm.`remarks`
                FROM `project_task_map` ptm
                INNER JOIN `project_employee_map` pem ON pem.`pe_id` = ptm.`pe_id`
                INNER JOIN `task_sub_task_map` tstm ON tstm.`tst_id` = ptm.`tst_id`
                INNER JOIN `project_master` pm ON pm.`project_id` = pem.`project_id`
                INNER JOIN `task_master` tm ON tm.`task_id` = tstm.`task_id`
                INNER JOIN `sub_task_master` stm ON stm.`sub_task_id` = tstm.`sub_task_id`
                WHERE 
                    pem.`emp_id` = $empID
                    AND YEAR(ptm.`date`) = $inYear
                    AND MONTH(ptm.`date`) = $inMonth 
                    AND ".$primaryFilters[$i]." = $j
                ORDER BY ptm.`date` ".$sortingOrders[$k];
        $data = mysqli_query($connection, $query);
        $data = mysqli_fetch_all($data);
    }
    else if(isset($_REQUEST['in-month']) && isset($_REQUEST['in-year']) && isset($_REQUEST['sorting-order']))
    {
        $inMonth = (int) $_REQUEST['in-month'];
        $inYear = (int) $_REQUEST['in-year'];
        $k = (int) $_REQUEST['sorting-order'];
        $query = "SELECT
                    ptm.`date`,
                    pm.`title` AS project_title,
                    tm.`title` AS tm_title,
                    stm.`title` AS stm_title,
                    ptm.`start_time`,
                    ptm.`end_time`,
                    ptm.`total`,
                    ptm.`remarks`
                FROM `project_task_map` ptm
                INNER JOIN `project_employee_map` pem ON pem.`pe_id` = ptm.`pe_id`
                INNER JOIN `task_sub_task_map` tstm ON tstm.`tst_id` = ptm.`tst_id`
                INNER JOIN `project_master` pm ON pm.`project_id` = pem.`project_id`
                INNER JOIN `task_master` tm ON tm.`task_id` = tstm.`task_id`
                INNER JOIN `sub_task_master` stm ON stm.`sub_task_id` = tstm.`sub_task_id`
                WHERE 
                    pem.`emp_id` = $empID
                    AND YEAR(ptm.`date`) = $inYear 
                    AND MONTH(ptm.`date`) = $inMonth
                ORDER BY ptm.`date` ".$sortingOrders[$k];
        $data = mysqli_query($connection, $query);
        $data = mysqli_fetch_all($data);
    }
    else
    {
        $data = "";
    }
    echo json_encode($data);
?>