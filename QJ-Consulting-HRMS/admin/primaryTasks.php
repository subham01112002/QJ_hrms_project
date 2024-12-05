<?php
    session_start();
    include("./loginCheck.php");
    include("./../connection/connection.php");
    include("./../functions/sessionMessage.php");
    if(isset($_REQUEST['submit']))
    {
        if(!isset($_REQUEST['title']) || trim($_REQUEST['title']) == "")
        {
            header("Location: ./primaryTasks.php");
            exit();
        }
        $title = $_REQUEST['title'];
        $description = trim($_REQUEST['description']);
        $query = "INSERT INTO `task_master` (`title`, `description`) VALUES ('$title', '$description')";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Task added successfully", "./primaryTasks.php");
    }
    if(isset($_REQUEST['update']))
    {
        if(!isset($_REQUEST['title']) || $_REQUEST['title'] == "")
        {
            header("Location: ./primaryTasks.php");
            exit();
        }
        $taskID = (int) $_REQUEST['task-id'];
        $title = $_REQUEST['title'];
        $description = trim($_REQUEST['description']);
        $query = "UPDATE `task_master` SET `title` = '$title',
                                           `description` = '$description' WHERE `task_id` = '$taskID'";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Task updated successfully", "./primaryTasks.php");
        
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
            .button-sn:nth-of-type(4)
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
                    Primary Tasks
                </div>
                <div class="font-16 color-2" style="color: grey;">Add or edit your primary tasks here</div>
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
                <?php printSessionMessage(); ?>
            </div>
            <div class="my-32 px-2vw">
                <div class="font-22">Your tasks</div>
                <div class="my-8 flex flex-column gap-16">
                    <?php
                        $query = "SELECT * FROM `task_master`";
                        $data = mysqli_query($connection, $query);
                        while($ar = mysqli_fetch_array($data))
                        {
                    ?>
                            <div class="card-1">
                                <form class="flex flex-column gap-16" method="POST">
                                    <input type="hidden" value="<?php echo $ar['task_id']; ?>" name="task-id">
                                    <div class="flex align-center justify-between">
                                        <div class="flex align-center gap-8">
                                            <img src="./../res/icons/right-cheveron.svg" alt="" onclick="showDetails(this)">
                                            <input class="font-18 w100-percent" type="text" value="<?php echo $ar['title']; ?>" name="title">
                                        </div>
                                        <input class="button-1 font-16" type="submit" value="Update" name="update">
                                    </div>
                                    <div class="pl-24">
                                        <div class="bg-color-1 h2-px"></div>
                                        <div class="font-18 my-8">
                                            Description:
                                            <textarea class="input-field font-18 w100-percent" name="description"><?php echo trim($ar['description']); ?></textarea>
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
        <script src="./../js/script.js"></script>
    </body>
</html>