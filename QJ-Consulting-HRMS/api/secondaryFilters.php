<?php
    session_start();
    if(!(isset($_SESSION['admin']) || isset($_SESSION['employee'])))
    {
        exit();
    }
    include("./../connection/connection.php");
    $data = "";
    if(isset($_REQUEST['primary-filter']))
    {
        $index = (int) $_REQUEST['primary-filter'];
        if($index > 0 && $index < 4)
        {
            $primaryFilters = ["", "project", "employee" ,"task"];
            $query = "SELECT * FROM ".$primaryFilters[$index]."_master";
            $data = mysqli_query($connection, $query);
            $data = mysqli_fetch_all($data);
        }
    }
    else
    {
        $data = "";
    }
    echo json_encode($data);
?>