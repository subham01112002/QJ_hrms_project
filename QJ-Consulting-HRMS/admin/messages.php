<?php
    session_start();
    include("./loginCheck.php");
    include("./../connection/connection.php");
    include("./../functions/sessionMessage.php");
    if(isset($_REQUEST['submit']))
    {
        if(!isset($_REQUEST['message']) || trim($_REQUEST['message']) == "" || $_REQUEST['emp-id'] == "")
        {
            header("Location: ./messages.php");
            exit();
        }
        $empID = (int) $_REQUEST['emp-id'];
        $message = trim($_REQUEST['message']);
        $query = "INSERT INTO `message_master` (`emp_id`, `message`) VALUES ('$empID', '$message')";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Message sent successfully", "./messages.php");
    }
    if(isset($_REQUEST['update']))
    {
        if(!isset($_REQUEST['message']) || $_REQUEST['message'] == "")
        {
            header("Location: ./messages.php");
            exit();
        }
        $messageID = (int) $_REQUEST['message-id'];
        $message = trim($_REQUEST['message']);
        $query = "UPDATE `message_master` SET `message` = '$message' WHERE `msg_id` = '$messageID'";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Message updated and sent successfully", "./messages.php");
        
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
            .button-sn:nth-of-type(6)
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
                    Messages
                </div>
                <div class="font-16 color-2" style="color: grey;">Message your employees here</div>
            </div>
            <div class="my-32 px-2vw">
                <form class="w300-px" method="POST">
                    <div class="flex flex-column gap-16">
                        <div class="flex flex-column gap-8 font-18">
                            To
                            <select class="input-field font-16" name="emp-id">
                                <option value="">Select an employee</option>
                                <option value="0">All</option>
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
                        <div class="flex flex-column gap-8 font-18">
                            Message
                            <textarea class="input-field resize-y font-16" placeholder="Type a message" name="message"></textarea>
                        </div>
                        <div class="flex flex-column gap-8">
                            <input class="button-1 font-16" type="submit" value="Add" name="submit">
                        </div>
                    </div>
                </form>
                <?php printSessionMessage(); ?>
            </div>
            <div class="my-32 px-2vw">
                <div class="font-22">Your messages</div>
                <div class="my-8 flex flex-column gap-16">
                    <?php
                        $query = "SELECT 
                                    mm.*,
                                    IFNULL(em.`name`, ' ') AS name
                                FROM `message_master` mm
                                LEFT JOIN `employee_master` em ON mm.`emp_id` = em.`emp_id`;";
                        $data = mysqli_query($connection, $query);
                        while($ar = mysqli_fetch_array($data))
                        {
                    ?>
                            <div class="card-1">
                                <form class="flex flex-column gap-16" method="POST">
                                    <input type="hidden" value="<?php echo $ar['msg_id']; ?>" name="message-id">
                                    <div class="flex align-center justify-between">
                                        <div class="flex align-center gap-8">
                                            <img src="./../res/icons/right-cheveron.svg" alt="" onclick="showDetails(this)">
                                            <div class="font-18">
                                                To: <?php echo ($ar['emp_id']) ? $ar['name'] : "All"; ?>
                                            </div>
                                        </div>
                                        <input class="button-1 font-16" type="submit" value="Update" name="update">
                                    </div>
                                    <div class="pl-24">
                                        <div class="bg-color-1 h2-px"></div>
                                        <div class="font-18 my-8">
                                            Description:
                                            <textarea class="input-field font-18 w100-percent" name="message"><?php echo trim($ar['message']); ?></textarea>
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