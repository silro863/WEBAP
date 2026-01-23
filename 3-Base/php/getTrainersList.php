    <?php
    session_start();
    header('Content-Type: application/json');

    // Check authentication
    if (!isset($_SESSION['id'])) {
        http_response_code(401);
        echo json_encode(["message" => "User not authenticated."]);
        exit;
    }

    require_once("db_credentials.php");

    // Create connection (procedural)
    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME);

    if (!$mysqli) {
        http_response_code(500);
        echo json_encode(["message" => "Database connection failed: " . mysqli_connect_error()]);
        exit;
    }

    // Set charset
    mysqli_set_charset($mysqli, "utf8mb4");

    $user_id = (int) $_SESSION['id'];

    // SQL query
    $sql = "SELECT idTrainer, username 
            FROM trainers 
            WHERE idTrainer != ?";

    // Prepare statement
    $stmt = mysqli_prepare($mysqli, $sql);

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["message" => "Prepare failed: " . mysqli_error($mysqli)]);
        exit;
    }

    // Bind parameter
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute
    mysqli_stmt_execute($stmt);

    // Get result
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        http_response_code(500);
        echo json_encode(["message" => "Query failed: " . mysqli_error($mysqli)]);
        exit;
    }

    // Fetch data
    $trainers = [];
    $num_rows = mysqli_num_rows($result);
    for ($i = 0; $i < $num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        $trainers[] = $row;
    }

    // Close resources
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    // Output JSON
    echo json_encode($trainers);
    exit;
    ?>
