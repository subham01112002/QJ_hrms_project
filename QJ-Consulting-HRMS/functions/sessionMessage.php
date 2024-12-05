<?php
    /*
        Function to set a session message.
        mode:
            0 - Error message
            1 - Custom message
        message:
            Custom message is passed here
        location:
            Redirection page after setting session message
    */
    function setSessionMessage($mode, $message, $location)
    {
        if($mode)
        {
            $_SESSION['status'] = $message;
            header("Location: ".$location);
        }
        else
        {
            $_SESSION['status'] = "Something went wrong";
            header("Location: ".$location);
        }
        exit();
    }
    /*
        Function to print the session message
    */
    function printSessionMessage()
    {
        if(isset($_SESSION['status']))
        {
            echo "<div class=\"my-8\">".$_SESSION['status']."</div>";
            unset($_SESSION['status']);
        }
    }
?>