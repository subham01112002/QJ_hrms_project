<?php
    session_start();
    if(!(isset($_SESSION['admin'])))
    {
        exit();
    }
    include("./../../connection/connection.php");
    $sortingOrders = ["ASC", "DESC"];
    $data = [];
    if(
        (int) $_REQUEST['project-filter'] != "" && 
        (int) $_REQUEST['employee-filter'] != "" && 
        (int) $_REQUEST['ptask-filter'] != "" && 
        /* (int) $_REQUEST['stask-filter'] != "" && */
        isset($_REQUEST['in-month']) && 
        isset($_REQUEST['in-year']) && 
        isset($_REQUEST['sorting-order']))
    {
        $projectFilter = $_REQUEST['project-filter'];
        $employeeFilter = $_REQUEST['employee-filter'];
        $pTaskFilter = $_REQUEST['ptask-filter'];
        // $sTaskFilter = $_REQUEST['stask-filter'];

        $inMonth = (int) $_REQUEST['in-month'];
        $inYear = (int) $_REQUEST['in-year'];
        $k = (int) $_REQUEST['sorting-order'];

        $query = "SELECT
                    ptm.`date`,
                    pm.`title` AS project_title,
                    em.`name`,
                    tm.`title` AS tm_title,
                    stm.`title` AS stm_title,
                    ptm.`start_time`,
                    ptm.`end_time`,
                    ptm.`total`,
                    ptm.`remarks`
                FROM `project_task_map` ptm
                INNER JOIN `project_employee_map` pem ON pem.`pe_id` = ptm.`pe_id`
                INNER JOIN `employee_master` em ON em.`emp_id` = pem.`emp_id`
                INNER JOIN `task_sub_task_map` tstm ON tstm.`tst_id` = ptm.`tst_id`
                INNER JOIN `project_master` pm ON pm.`project_id` = pem.`project_id`
                INNER JOIN `task_master` tm ON tm.`task_id` = tstm.`task_id`
                INNER JOIN `sub_task_master` stm ON stm.`sub_task_id` = tstm.`sub_task_id`
                WHERE
                    pm.`project_id` = $projectFilter
                    AND em.`emp_id` = $employeeFilter
                    AND tm.`task_id` = $pTaskFilter
                    AND YEAR(ptm.`date`) = $inYear
                    AND MONTH(ptm.`date`) = $inMonth
                ORDER BY ptm.`date` ".$sortingOrders[$k];
        $data = mysqli_query($connection, $query);
        $data = mysqli_fetch_all($data);
    }
    echo json_encode($data);
?>