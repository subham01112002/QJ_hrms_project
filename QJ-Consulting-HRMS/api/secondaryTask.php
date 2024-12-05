<?php
    session_start();
    if(!(isset($_SESSION['admin']) || isset($_SESSION['employee'])))
    {
        exit();
    }
    include("./../connection/connection.php");
    $data = "";
    if(isset($_REQUEST['primary-task']))
    {
        $taskID = (int) $_REQUEST['primary-task'];
        if($taskID > 0)
        {
            $query = "SELECT
                        tstm.`tst_id`,
                        stm.`title`
                    FROM `sub_task_master` stm
                    INNER JOIN `task_sub_task_map` tstm ON tstm.`sub_task_id` = stm.`sub_task_id`
                    WHERE tstm.`task_id` = '$taskID'";
            $data = mysqli_query($connection, $query);
            $data = mysqli_fetch_all($data);
        }
    }
    echo json_encode($data);
?>