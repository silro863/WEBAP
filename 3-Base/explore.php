<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon Basics</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.cdnfonts.com/css/g-guarantee" rel="stylesheet">
    <!-- import jquery Library -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- import jquery UI Library -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="js/scripts/explore.js"></script>
    <style>
        .pot-container {
            display: flex;
            justify-content: center;
            margin: 30px 0;
        }
        .pot {
            position: relative;
            width: 300px;
            height: 300px;
        }
        .prices {
            display: flex;
            overflow: hidden;
            width: 100%;
            height: 100%;
            border-radius: 10px;
            border: 3px solid #333;
        }
        .prices img {
            width: 60px;
            height: 60px;
            margin: 5px;
            object-fit: contain;
        }
        .highlight-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70px;
            height: 70px;
            border: 3px solid #FFCB05;
            background-color: rgba(255, 203, 5, 0.2);
            pointer-events: none;
            z-index: 10;
        }
        button {
            margin: 10px 5px;
            padding: 10px 20px;
            font-size: 1em;
        }
        #result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            min-height: 30px;
        }
    </style>
</head>

<body>
    <header>
        <img class="logo" src="img/logo.png" alt="Pokémon">
        <h1>3. Ajax dynamic content Exercises</h1>
    </header>
    <?php
    // Kick user to index if not logged in.
    session_start();
    
    if (!isset($_SESSION['id'])) {
        header('Location: index.php');
        exit();
    }
    
    $trainerId = $_SESSION['id'];
    ?>
    <nav hidden>
        <ul>
            <li><a id="logout" href="#">Logout</a></li>
            <li><a href="team.php">My Team</a></li>
            <li><a href="explore.php">Explore</a></li>
            <li><a href="arena.php">Arena</a></li>
            <li><a href="pokedex.php">Pokedex</a></li>
        </ul>
    </nav>
    <main hidden>
        <h2>Exercise 2: Loading Items from a database</h2>
        <h3>My Team</h3>
        <div class="pot-container">
            <div class="pot">
                <div class="prices" id="pokemonImages">
                    <!-- Pokémon images will be displayed here -->
                </div>
                <div class="highlight-box"></div>


            </div>
 