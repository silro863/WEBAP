<?php
    session_start();
    if(isset($_SESSION["id"])) {
        echo "Welcome back, " . $_SESSION["id"];
    } else {
        echo "You are not yet logged in.";
    }
?>