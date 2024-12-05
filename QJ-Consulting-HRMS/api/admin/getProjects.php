<?php
    session_start();
    if(!(isset($_SESSION['admin'])))
    {
        exit();
    }
    include("./../../connection/connection.php");
    $data = [];
    if((int) $_REQUEST['employee-filter'] != "")
    {
        $employeeFilter = $_REQUEST['employee-filter'];
        
        $query = "SELECT 
                    pm.`project_id`,
                    pm.`title`,
                    SEC_TO_TIME(SUM(TIME_TO_SEC(ptm.total))) AS `total_time`
                FROM
                    `project_task_map` ptm
                LEFT JOIN `project_employee_map` pem ON ptm.`pe_id` = pem.`pe_id`
                LEFT JOIN `task_sub_task_map` tstm ON ptm.`tst_id` = tstm.`tst_id`
                LEFT JOIN `task_master` tm ON tstm.`task_id` = tm.`task_id`
                LEFT JOIN `project_master` pm ON pem.`project_id` = pm.`project_id`
                WHERE
                    pem.`emp_id` = '$employeeFilter'
                GROUP BY
                    pm.`project_id`";
        $data = mysqli_query($connection, $query);
        $data = mysqli_fetch_all($data);
    }
    echo json_encode($data);
?>