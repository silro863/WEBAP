<?php
// Include database connection details
require_once("db_credentials.php");

// Check if the POST parameter 'username' is set
if (isset($_POST['username'])) {
    // Retrieve the username from the POST data
    $username = $_POST['username'];

    // Create a new MySQLi connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);

    // Check if the connection was successful
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Prepare an SQL SELECT statement to check if the username exists
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
    
    // Bind the parameter to the statement
    $stmt->bind_param("s", $username);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result
    $stmt->store_result();
      
    // Check if a row with the given username exists
    if ($stmt->num_rows > 0) {
        // Username exists
        echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
    } else {
        // Username is available
        echo json_encode(['status' => 'success', 'message' => 'Username available']);
    }
    
    // Close the statement and database connection
    $stmt->close();
    $mysqli->close();
    
} else {
   // Throw an Error message if the User has not supplied a username to be tested
   echo json_encode(['status' => 'error', 'message' => 'No username provided']);
}
