<?php
    // Check if the POST parameters are set
    // Throw an error message if not

    // Retrieve POST data

    // Include database connection details
    require_once("db_credentials.php");

    // Create a new MySQLi connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);

    // Check if the connection was successful
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Hash the password for security

    // Prepare an SQL INSERT statement
   
    // Bind the parameters to the statement

    // Execute the statement
    // Upon successfull Registration forward the User to the index page.
    
    // Close the statement and database connection
   

?>