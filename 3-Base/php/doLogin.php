<?php

// This code tries to log the user in with the given credentials.
    // POST parameters required:
    //     username
    //     password

// Check if the Request is valid
if(!isset($_POST['username']) || !isset($_POST['password'])) {
    echo("Invalid Post Parameters");
    http_response_code(400); 
    die();
}

session_start();


require_once ("./db_credentials.php");
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PW,DB_NAME);

// Oh no! A connect_errno exists so the connection attempt failed!
if ($mysqli->connect_errno) {
    // The connection failed. What do you want to do?
    // You could contact yourself (email?), log the error, show a nice page, etc.
    // You do not want to reveal sensitive information

    // Let's try this:
    echo "Sorry, this website is experiencing problems.";

    // Something you should not do on a public site, but this example will show you
    // anyways, is print out MySQL error related information -- you might log this
    echo "Error: could not connect to sql server \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";

    // You might want to show them something nice, but we will simply exit
    exit;
}

// Change character set to utf8
$mysqli -> set_charset("utf8");

// Check if Password is correct and log the User in.
// Return an Error if the user could not be logged in.
// Return an OK Message if the user and password were correct.
// Set the $_SESSION['id'] to the user's ID = trainerId