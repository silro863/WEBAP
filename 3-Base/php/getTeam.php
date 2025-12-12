<?php
// Start or resume the session
session_start();

// Check if the user is logged in (adjust this based on your authentication system)
if (!isset($_SESSION['id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(array("message" => "User not authenticated."));
    exit;
}

// Include database connection details
require_once("db_credentials.php");

// Create a new MySQLi connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);

// Check if the connection was successful
if ($mysqli->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Database connection error."));
    exit;
}

// Prepare an SQL SELECT statement to retrieve the trainer's Pokémons
// Retreive the trainer's ID from the session variable "id"

// Generate and return the php code for showing the Pokemon //
//    Apply different styles based on health levels (optional) in php
//    Show images from assets/pokedata/thumbnails/
//    Show Basic Information for each Pokemon.
//    Use classes full-health above 70 hp
//                medium-health between 30-70 hp
//                low-health below 30

// Close the statement and database connection

//here is an example how the data should be formatted:
/*

<id id="pokemonDataDiv" class="flexed">
    <section class="section">
        <h2>Name: Rocky</h2>
        <p>Level: 11</p>
        <img id="opponentimg" src="assets/pokedata/thumbnails/133.png" alt="Avatar">
        <div class="pokemon-health">
            <div class="health-bar">
                <div class="current-health full-health" style="width:85%">
                    <div class="health-text"><span class="current-hp">85</span>/<span class="max-hp">100</span> HP</div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <h2>Name: Eeve</h2>
        <p>Level: 15</p>
        <img id="opponentimg" src="assets/pokedata/thumbnails/255.png" alt="Avatar">
        <div class="pokemon-health">
            <div class="health-bar">
                <div class="current-health medium-health" style="width:50%">
                    <div class="health-text"><span class="current-hp">50</span>/<span class="max-hp">100</span> HP</div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <h2>Name: Torchy</h2>
        <p>Level: 6</p>
        <img id="opponentimg" src="assets/pokedata/thumbnails/016.png" alt="Avatar">
        <div class="pokemon-health">
            <div class="health-bar">
                <div class="current-health low-health" style="width:7%">
                    <div class="health-text"><span class="current-hp">7</span>/<span class="max-hp">100</span> HP</div>
                </div>
            </div>
        </div>
    </section>
</id>

*/

?>
