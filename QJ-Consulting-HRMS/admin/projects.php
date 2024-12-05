<?php
    session_start();
    include("./loginCheck.php");
    include("./../connection/connection.php");
    include("./../functions/sessionMessage.php");
    if(isset($_REQUEST['submit']))
    {
        if(!isset($_REQUEST['title']) || trim($_REQUEST['title']) == "")
        {
            header("Location: ./projects.php");
            exit();
        }
        $title = $_REQUEST['title'];
        $query = "INSERT INTO `project_master` (`title`) VALUES ('$title')";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Project added successfully", "./projects.php");
    }
    if(isset($_REQUEST['update']))
    {
        if(!isset($_REQUEST['title']) || $_REQUEST['title'] == "")
        {
            header("Location: ./projects.php");
            exit();
        }
        $projectID = (int) $_REQUEST['project-id'];
        $title = $_REQUEST['title'];
        $query = "UPDATE `project_master` SET `title` = '$title' WHERE `project_id` = '$projectID'";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Project updated successfully", "./projects.php");
        
    }
    if(isset($_REQUEST['assign']))
    {
        if(!isset($_REQUEST['project-id']) || !isset($_REQUEST['emp-id']))
        {
            header("Location: ./projects.php");
        }
        $projectID = (int) $_REQUEST['project-id'];
        $empID = (int) $_REQUEST['emp-id'];
        $startDate = date("Y-m-d");
        $query = "INSERT INTO `project_employee_map` (`project_id`, `emp_id`, `start_date`, `end_date`) VALUES ('$projectID', '$empID', '$startDate', NULL)";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Project assigned successfully", "./projects.php");
    }
    if(isset($_REQUEST['remove-emp']))
    {
        if(!isset($_REQUEST['project-id']) || !isset($_REQUEST['emp-id']))
        {
            header("Location: ./projects.php");
        }
        $projectID = (int) $_REQUEST['project-id'];
        $empID = (int) $_REQUEST['emp-id'];
        $endDate = date("Y-m-d");
        $query = "UPDATE `project_employee_map` SET `end_date` = '$endDate'  WHERE `project_id` = '$projectID' AND `emp_id` = '$empID'";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Project unassigned successfully", "./projects.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("./../title.php"); ?>
        <link rel="stylesheet" href="./../css/style.css">
        <link rel="stylesheet" href="./../css/navigation.css">
    </head>
    <body>
        <style>
            .button-sn:nth-of-type(2)
            {
                background-color: var(--theme-color-2);
                img
                {
                    filter: invert(1);
                }
                div
                {
                    color: var(--theme-color-3);
                }
            }
        </style>
        <?php include("./topNavigation.php"); ?>
        <?php include("./sideNavigation.php"); ?>
        <div class="container">
            <div class="my-32 px-2vw">
                <div class="font-32">
                    Projects
                </div>
                <div class="font-16 color-2" style="color: grey;">Add or edit your projects here</div>
            </div>
            <div class="my-32 px-2vw">
                <form class="w300-px" method="POST">
                    <div class="flex flex-column gap-16">
                        <div class="flex flex-column gap-8 font-18">
                            Project Title
                            <input class="input-field font-16" type="text" placeholder="Enter project title" name="title">
                        </div>
                        <div class="flex flex-column gap-8">
                            <input class="button-1 font-16" type="submit" value="Add" name="submit">
                        </div>
                    </div>
                </form>
                <?php printSessionMessage(); ?>
            </div>
            <div class="my-32 px-2vw">
                <input class="button-2 w300-px font-16" type="button" onclick="toggleOverlay()" value="Assign project">
            </div>
            <div class="my-32 px-2vw">
                <div class="font-22">Your Projects</div>
                <div class="my-8 flex flex-column gap-16">
                    <?php
                        $query = "SELECT 
                                pm.`project_id`,
                                pm.`title`,
                                GROUP_CONCAT(em.`emp_id` ORDER BY em.`emp_id` SEPARATOR ',') AS emp_ids,
                                GROUP_CONCAT(em.`name` ORDER BY em.`emp_id` SEPARATOR ',') AS emp_names,
                                GROUP_CONCAT(pem.`start_date` ORDER BY em.`emp_id` SEPARATOR ',') AS start_dates
                            FROM `project_master` pm
                            LEFT JOIN `project_employee_map` pem ON pm.`project_id` = pem.`project_id`
                            LEFT JOIN `employee_master` em ON pem.`emp_id` = em.`emp_id`
                            GROUP BY pm.`project_id`";
                        
                        $data = mysqli_query($connection, $query);
                        while($ar = mysqli_fetch_array($data))
                        {
                    ?>
                            <div class="card-1 flex flex-column gap-16">
                                <form method="POST">
                                    <input type="hidden" value="<?php echo $ar['project_id']; ?>" name="project-id">
                                    <div class="flex align-center justify-between gap-8">
                                        <div class="flex align-center gap-8 w100-percent">
                                            <img src="./../res/icons/right-cheveron.svg" alt="" onclick="showDetails(this)">
                                            <input class="font-18 w100-percent" type="text" value="<?php echo $ar['title']; ?>" name="title">
                                        </div>
                                        <input class="button-1 font-16" type="submit" value="Update" name="update">
                                    </div>
                                </form>
                                <div class="pl-24">
                                    <div class="bg-color-1 h2-px"></div>
                                    <div class="font-18 my-8">
                                        Assigned Employees:
                                        <div class="flex align-center gap-8 flex-wrap font-18 my-8">
                                            <?php
                                                if($ar['emp_names'] != NULL)
                                                {
                                                    $empNames = explode(",", $ar['emp_names']);
                                                    $empIDs = explode(",", $ar['emp_ids']);
                                                    $startDates = explode(",", $ar['start_dates']);
                                                    $l = count($empNames);
                                                    for($i=0; $i<$l; $i++)
                                                    {
                                            ?>
                                                        <form method="POST">
                                                            <input type="hidden" value="<?php echo $ar['project_id']; ?>" name="project-id">
                                                            <input type="hidden" value="<?php echo $empIDs[$i]; ?>" name="emp-id">
                                                            <div class="input-field">
                                                                <div>
                                                                    <?php echo $empNames[$i]; ?>
                                                                    &nbsp;
                                                                    <button type="submit" value="Remove" name="remove-emp">
                                                                        <img src="./../res/icons/cross.svg" alt="">
                                                                    </button>
                                                                </div>
                                                                <input type="date" value="<?php echo $startDates[$i]; ?>" disabled>
                                                            </div>
                                                        </form>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <div id="overlay-form" class="overlay flex align-center justify-center absolute h100-vh">
            <form class="base-form flex flex-column gap-16">
                <div class="text-center font-28">
                    Assign Project
                    <div class="font-16 color-2" style="color: grey;">Assign project to your employee</div>
                </div>
                <br>
                <div class="flex flex-column gap-8 font-18">
                    Select a project
                    <select class="input-field font-16" name="project-id">
                        <option value="">Select a project</option>
                        <?php
                            mysqli_data_seek($data, 0);
                            while($ar = mysqli_fetch_array($data))
                            {
                        ?>
                                <option value="<?php echo $ar['project_id']; ?>">
                                    <?php echo $ar['title']; ?>
                                </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="flex flex-column gap-8 font-18">
                    Select an employee
                    <select class="input-field font-16" name="emp-id">
                        <option value="">Select an employee</option>
                        <?php
                            $query = "SELECT * FROM `employee_master`";
                            $data = mysqli_query($connection, $query);
                            while($ar = mysqli_fetch_array($data))
                            {
                        ?>
                                <option value="<?php echo $ar['emp_id']; ?>">
                                    <?php echo $ar['name']; ?>
                                </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="flex flex-column gap-8">
                    <input class="button-2 font-16" type="submit" value="Assign" name="assign">
                </div>
                <div class="flex flex-column gap-8">
                    <input class="button-2 font-16" type="button" value="Cancel" onclick="toggleOverlay()">
                </div>
            </form>
        </div>
        <script src="./../js/script.js"></script>
    </body>
</html>