<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon Basics</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.cdnfonts.com/css/g-guarantee" rel="stylesheet">
    <!-- import jquery Library -->
    <script type="text/javascript" src="js/code.jquery.com_jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/code.jquery.com_ui_1.13.2_jquery-ui.js"></script>
    <script src="js/scripts/explore.js"> </script>
</head>

<body>
    <header>
        <img class="logo" src="img/logo.png" alt="Pokémon">
        <h1>3. Ajax dynamic content Exercises</h1>
    </header>
    <?php
   // Kick user to index if not logged in.
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
        </div>
        <button id="spinButton">Spin</button><button id="runawayButton">Run Away</button>
        <div id="result"></div>
    </main>
</body>

</html>