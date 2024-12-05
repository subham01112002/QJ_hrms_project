<?php
    session_start();
    if(!(isset($_SESSION['admin'])))
    {
        exit();
    }
    include("./../../connection/connection.php");
    $data = [];
    if((int) $_REQUEST['project-filter'] != "" && (int) $_REQUEST['ptask-filter'] != "")
    {
        $projectFilter = $_REQUEST['project-filter'];
        $ptaskFilter = $_REQUEST['ptask-filter'];
        
        $query = "SELECT 
                    em.`emp_id`,
                    em.`name`
                FROM
                    `project_task_map` ptm
                LEFT JOIN `project_employee_map` pem ON ptm.`pe_id` = pem.`pe_id`
                LEFT JOIN `task_sub_task_map` tstm ON ptm.`tst_id` = tstm.`tst_id`
                LEFT JOIN `task_master` tm ON tstm.`task_id` = tm.`task_id`
                LEFT JOIN `employee_master` em ON pem.`emp_id` = em.`emp_id`
                WHERE
                    pem.`project_id` = '$projectFilter'
                    AND tm.`task_id` = '$ptaskFilter'
                GROUP BY
                    em.`emp_id`";
        $data = mysqli_query($connection, $query);
        $data = mysqli_fetch_all($data);
    }
    echo json_encode($data);
?>