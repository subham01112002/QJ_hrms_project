<?php
    session_start();
    if(!(isset($_SESSION['admin'])))
    {
        exit();
    }
    include("./../../connection/connection.php");
    $data = [];
    if(isset($_REQUEST['project-filter']) && (int) $_REQUEST['project-filter'] != "")
    {
        $projectFilter = $_REQUEST['project-filter'];

        $query = "SELECT 
                    tm.`task_id`,
                    tm.`title`,
                    SEC_TO_TIME(SUM(TIME_TO_SEC(ptm.total))) AS `total_time`
                FROM
                    `project_task_map` ptm
                LEFT JOIN `project_employee_map` pem ON ptm.`pe_id` = pem.`pe_id`
                LEFT JOIN `task_sub_task_map` tstm ON ptm.`tst_id` = tstm.`tst_id`
                LEFT JOIN `task_master` tm ON tstm.`task_id` = tm.`task_id`
                WHERE
                    pem.`project_id` = '$projectFilter'
                GROUP BY
                    tm.`task_id`";
        $data = mysqli_query($connection, $query);
        $data = mysqli_fetch_all($data);
    }
    else if(isset($_REQUEST['employee-filter']) && (int) $_REQUEST['employee-filter'] != "")
    {
        $employeeFilter = $_REQUEST['employee-filter'];

        $query = "SELECT 
                    tm.`task_id`,
                    tm.`title`,
                    SEC_TO_TIME(SUM(TIME_TO_SEC(ptm.total))) AS `total_time`
                FROM
                    `project_task_map` ptm
                LEFT JOIN `project_employee_map` pem ON ptm.`pe_id` = pem.`pe_id`
                LEFT JOIN `task_sub_task_map` tstm ON ptm.`tst_id` = tstm.`tst_id`
                LEFT JOIN `task_master` tm ON tstm.`task_id` = tm.`task_id`
                WHERE
                    pem.`emp_id` = '$employeeFilter'
                GROUP BY
                    tm.`task_id`";
        $data = mysqli_query($connection, $query);
        $data = mysqli_fetch_all($data);
    }
    echo json_encode($data);
?>