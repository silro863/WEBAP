<?php
session_start();
header('Content-Type: application/json');

// Auth check
if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(["message" => "User not authenticated."]);
    exit;
}

// Input validation
if (!isset($_POST['trainer']) || !isset($_POST['message'])) {
    http_response_code(400);
    echo json_encode(["message" => "Trainer ID or message not provided."]);
    exit;
}

$otherTrainerId    = $_POST['trainer'];
$currentTrainerId  = (int) $_SESSION['id'];
$message           = trim($_POST['message']);

require_once("db_credentials.php");

// Connect (procedural)
$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME);

if (!$mysqli) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection error: " . mysqli_connect_error()]);
    exit;
}

// Charset
mysqli_set_charset($mysqli, "utf8mb4");


if ($otherTrainerId === "all") {

    // Get all trainers except current
    $sql = "SELECT idTrainer FROM trainers WHERE idTrainer != ?";
    $stmt = mysqli_prepare($mysqli, $sql);

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["message" => "Prepare failed: " . mysqli_error($mysqli)]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $currentTrainerId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        http_response_code(500);
        echo json_encode(["message" => "Query failed: " . mysqli_error($mysqli)]);
        exit;
    }

    $trainers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $trainers[] = (int) $row['idTrainer'];
    }

    mysqli_stmt_close($stmt);

    // Prepare insert once
    $insertSql = "INSERT INTO messages (idSender, idReceiver, message, timestamp)
                  VALUES (?, ?, ?, NOW())";

    $insertStmt = mysqli_prepare($mysqli, $insertSql);

    if (!$insertStmt) {
        http_response_code(500);
        echo json_encode(["message" => "Insert prepare failed: " . mysqli_error($mysqli)]);
        exit;
    }

    // Insert for each trainer
    foreach ($trainers as $trainerId) {

        mysqli_stmt_bind_param(
            $insertStmt,
            "iis",
            $currentTrainerId,
            $trainerId,
            $message
        );

        if (!mysqli_stmt_execute($insertStmt)) {
            http_response_code(500);
            echo json_encode(["message" => "Insert failed: " . mysqli_stmt_error($insertStmt)]);
            exit;
        }
    }

    mysqli_stmt_close($insertStmt);


} else {

    $otherTrainerId = (int) $otherTrainerId;

    $insertSql = "INSERT INTO messages (idSender, idReceiver, message, timestamp)
                  VALUES (?, ?, ?, NOW())";

    $stmt = mysqli_prepare($mysqli, $insertSql);

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["message" => "Prepare failed: " . mysqli_error($mysqli)]);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "iis",
        $currentTrainerId,
        $otherTrainerId,
        $message
    );

    if (!mysqli_stmt_execute($stmt)) {
        http_response_code(500);
        echo json_encode(["message" => "Insert failed: " . mysqli_stmt_error($stmt)]);
        exit;
    }

    mysqli_stmt_close($stmt);
}

// Close DB
mysqli_close($mysqli);

// Success response
echo json_encode(["message" => "Message sent successfully."]);
exit;
?>
