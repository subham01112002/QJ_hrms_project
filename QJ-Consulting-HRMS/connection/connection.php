<?php
    $connection = mysqli_connect("localhost", "root", "", "qj_consulting_hrms");
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to database" . mysqli_connect_error();
    }
?>