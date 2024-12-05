<?php
    session_start();
    include("./loginCheck.php");
    include("./../connection/connection.php");
    include("./../functions/sessionMessage.php");
    if(isset($_REQUEST['submit']))
    {
        if(!isset($_REQUEST['title']) || trim($_REQUEST['title']) == "")
        {
            header("Location: ./secondaryTasks.php");
            exit();
        }
        $title = $_REQUEST['title'];
        $description = trim($_REQUEST['description']);
        $query = "INSERT INTO `sub_task_master` (`title`, `description`) VALUES ('$title', '$description')";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Task added successfully", "./secondaryTasks.php");
    }
    if(isset($_REQUEST['update']))
    {
        if(!isset($_REQUEST['title']) || $_REQUEST['title'] == "")
        {
            header("Location: ./secondaryTasks.php");
            exit();
        }
        $taskID = (int) $_REQUEST['task-id'];
        $title = $_REQUEST['title'];
        $description = trim($_REQUEST['description']);
        $query = "UPDATE `sub_task_master` SET `title` = '$title',
                                           `description` = '$description' WHERE `sub_task_id` = '$taskID'";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Task updated successfully", "./secondaryTasks.php");
    }
    if(isset($_REQUEST['map']))
    {
        if(!isset($_REQUEST['primary-task']) || (int)$_REQUEST['primary-task'] == 0 || !isset($_REQUEST['secondary-task']) || (int)$_REQUEST['secondary-task'] == 0)
        {
            header("Location: ./secondaryTasks.php");
            exit();
        }
        $taskID = (int)$_REQUEST['primary-task'];
        $subTaskID = (int)$_REQUEST['secondary-task'];
        $query = "INSERT INTO `task_sub_task_map` (`task_id`, `sub_task_id`) VALUES ('$taskID', '$subTaskID')";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Sub task mapped successfully", "./secondaryTasks.php");
    }
    if(isset($_REQUEST['remove-task-map']))
    {
        if(!isset($_REQUEST['primary-task']) || !isset($_REQUEST['secondary-task']))
        {
            header("Location: ./secondaryTasks.php");
        }
        $taskID = (int) $_REQUEST['primary-task'];
        $subTaskID = (int) $_REQUEST['secondary-task'];
        $query = "DELETE FROM `task_sub_task_map` WHERE `task_id` = '$taskID' AND `sub_task_id` = '$subTaskID'";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Sub task removed from mapping successfully", "./secondaryTasks.php");
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
            .button-sn:nth-of-type(5)
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
                    Secondary Tasks
                </div>
                <div class="font-16 color-2" style="color: grey;">Add or edit your secondary tasks here</div>
            </div>
            <div class="my-32 px-2vw">
                <form class="w300-px" method="POST">
                    <div class="flex flex-column gap-16">
                        <div class="flex flex-column gap-8 font-18">
                            Task Title
                            <input class="input-field font-16" type="text" placeholder="Enter task title" name="title">
                        </div>
                        <div class="flex flex-column gap-8 font-18">
                            Description
                            <textarea class="input-field resize-y font-16" placeholder="Task description" name="description"></textarea>
                        </div>
                        <div class="flex flex-column gap-8">
                            <input class="button-1 font-16" type="submit" value="Add" name="submit">
                        </div>
                    </div>
                </form>
                <br>
                <input class="button-1 font-16" type="button" value="Map Secondary Task" onclick="toggleOverlay()">
                <?php printSessionMessage(); ?>
            </div>
            <div class="my-32 px-2vw">
                <div class="font-22">Your tasks</div>
                <div class="my-8 flex flex-column gap-16">
                    <?php
                        $query = "SELECT 
                                    stm.`sub_task_id` AS stm_id,
                                    stm.`title` AS stm_title,
                                    stm.`description` AS stm_description,
                                    GROUP_CONCAT(tm.`task_id` ORDER BY tm.`task_id` SEPARATOR ',') AS tm_ids,
                                    GROUP_CONCAT(tm.`title` ORDER BY tm.`task_id` SEPARATOR ',') AS tm_titles
                                FROM `sub_task_master` stm
                                LEFT JOIN `task_sub_task_map` tstm ON tstm.`sub_task_id` = stm.`sub_task_id`
                                LEFT JOIN `task_master` tm ON tm.`task_id` = tstm.`task_id`
                                GROUP BY stm.`sub_task_id`
                                ORDER BY stm.`sub_task_id`";
                        $data = mysqli_query($connection, $query);
                        while($ar = mysqli_fetch_array($data))
                        {
                    ?>
                            <div class="card-1">
                                <form class="flex flex-column gap-16" method="POST">
                                    <input type="hidden" value="<?php echo $ar['stm_id']; ?>" name="task-id">
                                    <div class="flex align-center justify-between">
                                        <div class="flex align-center gap-8">
                                            <img src="./../res/icons/right-cheveron.svg" alt="" onclick="showDetails(this)">
                                            <input class="font-18 w100-percent" type="text" value="<?php echo $ar['stm_title']; ?>" name="title">
                                        </div>
                                        <input class="button-1 font-16" type="submit" value="Update" name="update">
                                    </div>
                                    <div class="pl-24">
                                        <div class="bg-color-1 h2-px"></div>
                                        <div class="font-18 my-8">
                                            Description:
                                            <textarea class="input-field font-18 w100-percent" name="description"><?php echo trim($ar['stm_description']); ?></textarea>
                                        </div>
                                        <div class="font-18 my-8">
                                            Mapped To:
                                            <div class="flex align-center gap-8 flex-wrap font-18 my-8">
                                                <?php
                                                    if($ar['tm_titles'] != NULL)
                                                    {
                                                        $taskTitles = explode(",", $ar['tm_titles']);
                                                        $taskIDs = explode(",", $ar['tm_ids']);
                                                        $l = count($taskTitles);
                                                        for($i=0; $i<$l; $i++)
                                                        {
                                                ?>
                                                            <form method="POST">
                                                                <input type="hidden" value="<?php echo $ar['stm_id']; ?>" name="secondary-task">
                                                                <input type="hidden" value="<?php echo $taskIDs[$i]; ?>" name="primary-task">
                                                                <div class="input-field">
                                                                    <div>
                                                                        <?php echo $taskTitles[$i]; ?>
                                                                        &nbsp;
                                                                        <button type="submit" value="Remove" name="remove-task-map">
                                                                            <img src="./../res/icons/cross.svg" alt="">
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <div id="overlay-form" class="overlay flex align-center justify-center absolute h100-vh">
            <form class="base-form flex flex-column gap-16">
                <div class="text-center font-28">Map Secondary Task</div>
                <br>
                <div class="flex flex-column gap-8 font-18">
                    <div class="flex align-center justify-between">
                        <div class="font-18">Primary Task</div>
                        <div class="font-14">*required</div>
                    </div>
                    <select class="input-field font-16" name="primary-task">
                        <option value="0">Select a primary task</option>
                        <?php
                            $query = "SELECT * FROM `task_master`";
                            $data = mysqli_query($connection, $query);
                            while($ar = mysqli_fetch_array($data))
                            {
                        ?>
                                <option value="<?php echo $ar['task_id']; ?>"><?php echo $ar['title']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="flex flex-column gap-8 font-18">
                    <div class="flex align-center justify-between">
                        <div class="font-18">Secondary Task</div>
                        <div class="font-14">*required</div>
                    </div>
                    <select class="input-field font-16" name="secondary-task">
                        <option value="0">Select a secondary task</option>
                        <?php
                            $query = "SELECT * FROM `sub_task_master`";
                            $data = mysqli_query($connection, $query);
                            while($ar = mysqli_fetch_array($data))
                            {
                        ?>
                                <option value="<?php echo $ar['sub_task_id']; ?>"><?php echo $ar['title']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="flex flex-column gap-8">
                    <input class="button-2 font-16" type="submit" value="Submit" name="map">
                </div>
                <div class="flex flex-column gap-8">
                    <input class="button-2 font-16" type="button" value="Cancel" onclick="toggleOverlay()">
                </div>
            </form>
        </div>
        <script src="./../js/script.js"></script>
    </body>
</html>