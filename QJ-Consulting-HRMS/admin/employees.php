<?php
    session_start();
    include("./loginCheck.php");
    include("./../connection/connection.php");
    include("./../functions/sessionMessage.php");
    if(isset($_REQUEST['submit']))
    {
        if(!isset($_REQUEST['name']) || trim($_REQUEST['name']) == "" || !isset($_REQUEST['phone']) || $_REQUEST['email'] == "" || !isset($_REQUEST['doj']))
        {
            header("Location: ./employees.php");
            exit();
        }
        $name = $_REQUEST['name'];
        $phone = $_REQUEST['phone'];
        if(!($phone >= 1000000000 && $phone <= 9999999999))
        {
            header("Location: ./employees.php");
            exit();
        }
        $email = $_REQUEST['email'];
        $password = md5("Welcome");
        $doj = $_REQUEST['doj'];
        $dob = $_REQUEST['dob'];
        $query = "INSERT INTO `employee_master` (`name`, `phone`, `email`, `password`, `doj`, `dob`) VALUES ('$name', '$phone', '$email', '$password', '$doj', ";
        if($dob == "")
        {
            $query = $query."NULL)";
        }
        else
        {
            $query = $query."'$dob')";
        }
        
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Employee registered successfully", "./employees.php");
    }
    if(isset($_REQUEST['update']))
    {
        if(!isset($_REQUEST['name']) || trim($_REQUEST['name']) == "" || !isset($_REQUEST['phone']) || $_REQUEST['email'] == "" || !isset($_REQUEST['doj']))
        {
            header("Location: ./employees.php");
            exit();
        }
        $empID = (int) $_REQUEST['emp-id'];
        $name = $_REQUEST['name'];
        $phone = $_REQUEST['phone'];
        if(!($phone >= 1000000000 && $phone <= 9999999999))
        {
            header("Location: ./employees.php");
            exit();
        }
        $email = $_REQUEST['email'];
        $doj = $_REQUEST['doj'];
        $dob = $_REQUEST['dob'];
        $query = "UPDATE `employee_master` SET `name` = '$name',
                                               `phone` = '$phone',
                                               `email` = '$email',
                                               `doj` = '$doj',
                                               `dob`= ";
        if($dob == "")
        {
            $query = $query."NULL ";
        }
        else
        {
            $query = $query."'$dob' ";
        }
        $query = $query."WHERE `emp_id` = '$empID'";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Employee updated successfully", "./employees.php");
    }
    if(isset($_REQUEST['reset-pswd']))
    {
        if(!isset($_REQUEST['name']) || trim($_REQUEST['name']) == "" || !isset($_REQUEST['phone']))
        {
            header("Location: ./employees.php");
            exit();
        }
        $empID = (int) $_REQUEST['emp-id'];
        $name = $_REQUEST['name'];
        $phone = $_REQUEST['phone'];
        $password = md5("Welcome");
        $query = "UPDATE `employee_master` SET `password` = '$password',
                                               `pswd_state` = 1 WHERE `emp_id` = '$empID'";
        $data = mysqli_query($connection, $query);
        setSessionMessage($data, "Password reset successfully", "./employees.php");
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
            .button-sn:nth-of-type(3)
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
                    Employees
                </div>
                <div class="font-16 color-2" style="color: grey;">Add or view your employees here</div>
            </div>
            <div class="my-32 px-2vw">
                <input class="button-1 font-16" type="button" onclick="toggleOverlay()" value="Register Employee">
                <?php printSessionMessage(); ?>
            </div>
            <div class="my-32 px-2vw">
                <div class="font-22">Your Employees</div>
                <div class="my-8 flex flex-column gap-16">
                    <?php
                        $query = "SELECT * FROM `employee_master`";
                        $data = mysqli_query($connection, $query);
                        while($ar = mysqli_fetch_array($data))
                        {
                    ?>
                            <div class="card-1">
                                <form class="flex flex-column gap-16" method="POST">
                                    <input type="hidden" value="<?php echo $ar['emp_id']; ?>" name="emp-id">
                                    <div class="flex align-center justify-between">
                                        <div class="flex align-center gap-8">
                                            <img src="./../res/icons/right-cheveron.svg" alt="" onclick="showDetails(this)">
                                            <input class="font-18 w100-percent" type="text" value="<?php echo $ar['name']; ?>" name="name">
                                        </div>
                                        <div>
                                            <input class="button-1 font-16" type="submit" value="Update" name="update">
                                            <input class="button-2 font-16" type="submit" value="Reset Password" name="reset-pswd">
                                        </div>
                                    </div>
                                    <div class="pl-24">
                                        <div class="bg-color-1 h2-px"></div>
                                        <div class="flex flex-wrap font-18 gap-16 my-8">
                                            <div class="flex flex-column gap-8">
                                                Contact: 
                                                <input class="input-field font-18" type="text" value="<?php echo $ar['phone']; ?>" name="phone">
                                            </div>
                                            <div class="flex flex-column gap-8">
                                                Email: 
                                                <input class="input-field font-18" type="email" value="<?php echo $ar['email']; ?>" name="email">
                                            </div>
                                            <div class="flex flex-column gap-8">
                                                D.O.J:
                                                <input class="input-field font-18" type="date" value="<?php echo $ar['doj']; ?>" name="doj">
                                            </div>
                                            <div class="flex flex-column gap-8">
                                                D.O.B:
                                                <input class="input-field font-18" type="date" value="<?php echo $ar['dob']; ?>" name="dob">
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
                <div class="text-center font-28">Register Employee</div>
                <br>
                <div class="flex flex-column gap-8 font-18">
                    <div class="flex align-center justify-between">
                        <div class="font-18">Full Name</div>
                        <div class="font-14">*required</div>
                    </div>
                    <input class="input-field font-16" type="text" placeholder="Enter name" name="name">
                </div>
                <div class="flex flex-column gap-8 font-18">
                    <div class="flex align-center justify-between">
                        <div class="font-18">Phone</div>
                        <div class="font-14">*required</div>
                    </div>
                    <input class="input-field font-16" type="number" placeholder="Enter phone number" name="phone">
                </div>
                <div class="flex flex-column gap-8 font-18">
                    <div class="flex align-center justify-between">
                        <div class="font-18">Email</div>
                        <div class="font-14">*required</div>
                    </div>
                    <input class="input-field font-16" type="email" placeholder="Enter email" name="email">
                </div>
                <div class="flex flex-column gap-8 font-18">
                    <div class="flex align-center justify-between">
                        <div class="font-18">Default Password</div>
                    </div>
                    <input class="input-field font-16" type="text" placeholder="<Welcome>" name="" disabled>
                </div>
                <div class="flex flex-column gap-8 font-18">
                    <div class="flex align-center justify-between">
                        <div class="font-18">Date of joining</div>
                        <div class="font-14">*required</div>
                    </div>
                    <input class="input-field font-16" type="date" name="doj">
                </div>
                <div class="flex flex-column gap-8 font-18">
                    Date of Birth
                    <input class="input-field font-16" type="date" name="dob">
                </div>
                <div class="flex flex-column gap-8">
                    <input class="button-2 font-16" type="submit" value="Submit" name="submit">
                </div>
                <div class="flex flex-column gap-8">
                    <input class="button-2 font-16" type="button" value="Cancel" onclick="toggleOverlay()">
                </div>
            </form>
        </div>
        <script src="./../js/script.js"></script>
    </body>
</html>