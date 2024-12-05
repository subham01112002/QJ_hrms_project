<?php
    session_start();
    include("./loginCheck.php");
    include("./../connection/connection.php");
    include("./../functions/sessionMessage.php");
    $curDate = date("Y-m-d");
    if(isset($_REQUEST['approve']))
    {
        $elID = $_REQUEST['el-id'];
        $query = "UPDATE `employee_leave_map` SET `status` = 1 WHERE `el_id` = '$elID'";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Leave approved successfully", "./leaves.php");
    }
    if(isset($_REQUEST['reject']))
    {
        $elID = $_REQUEST['el-id'];
        $query = "UPDATE `employee_leave_map` SET `status` = -1 WHERE `el_id` = '$elID'";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Leave rejected successfully", "./leaves.php");
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
            .button-sn:nth-of-type(7)
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
                    Leaves
                </div>
                <div class="font-16 color-2" style="color: grey;">View or control your employee's Leave applications here</div>
            </div>
            <div class="my-32 px-2vw">
                <?php printSessionMessage(); ?>
            </div>
            <div class="my-32 px-2vw">
                <div class="font-22">Leave Requests</div>
                <div class="my-8 flex flex-column gap-16">
                    <?php
                        $query = "SELECT
                                    elm.*,
                                    em.`name`
                                FROM `employee_leave_map` elm
                                LEFT JOIN `employee_master` em ON em.`emp_id` = elm.`emp_id`;";
                        $data = mysqli_query($connection, $query);
                        while($ar = mysqli_fetch_array($data))
                        {
                    ?>
                            <div class="card-1">
                                <div class="flex flex-column gap-16">
                                    <div class="flex align-center justify-between" style="min-height: 45px;">
                                        <div class="flex align-center gap-8">
                                            <img src="./../res/icons/right-cheveron.svg" alt="" onclick="showDetails(this)">
                                            <div class="font-18">
                                                <?php echo $ar['name'].": Casual Leave"; ?>
                                            </div>
                                        </div>
                                        <?php
                                            if($ar['status'] == -1)
                                            {
                                                echo "Rejected";
                                            }
                                            else
                                            {
                                                
                                        ?>
                                            <form method="POST">
                                                <input type="hidden" value="<?php echo $ar['el_id']; ?>" name="el-id">
                                                <?php
                                                    if($ar['status'] == 0)
                                                    {
                                                ?>
                                                        <input class="button-1 font-16" type="submit" value="Approve" name="approve">
                                                <?php
                                                    }
                                                ?>
                                                <input class="button-1 font-16" type="submit" value="Reject" name="reject">
                                            </form>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="pl-24">
                                        <div class="bg-color-1 h2-px"></div>
                                        <div class="font-18 my-8">
                                            <div class="flex gap-16">
                                                <div>
                                                    Start Date:
                                                    <br>
                                                    <input class="input-field font-18" type="date" value="<?php echo $ar['start_date']; ?>" name="start-date">
                                                </div>
                                                <div>
                                                    End Date:
                                                    <br>
                                                    <input class="input-field font-18" type="date" value="<?php echo $ar['end_date']; ?>" name="end-date">
                                                </div>
                                                <div>
                                                    No.of Days:
                                                    <br>
                                                    <input class="input-field font-18" type="number" value="<?php echo $ar['count']; ?>">
                                                </div>
                                            </div>
                                            <div class="my-8">
                                                Reason:
                                                <textarea class="input-field font-18 w100-percent" name="reason" id=""><?php echo trim($ar['reason']); ?></textarea>
                                            </div>
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
        <script src="./../js/script.js"></script>
    </body>
</html>