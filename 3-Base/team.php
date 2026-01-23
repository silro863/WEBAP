<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon Basics</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.cdnfonts.com/css/g-guarantee" rel="stylesheet">
    <!-- import Libraries -->
    <script type="text/javascript" src="js/code.jquery.com_jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/code.jquery.com_ui_1.13.2_jquery-ui.js"></script>
</head>

<body>
    <header>
        <img class="logo" src="img/logo.png" alt="Pokémon">
        <h1>3. Ajax dynamic content Exercises</h1>
    </header>
    <?php
    // Check if the session field "id" is set.
    // If not, kick the user out to the login Page.
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: index.php");
        exit;
    }
    ?>
    <nav hidden>
        <ul>
            <li><a id="logout" href="#">Logout</a></li>
            <li><a href="chat.php">Chat</a></li>
            <li><a href="team.php">My Team</a></li>
            <li><a href="explore.php">Explore</a></li>
            <li><a href="arena.php">Arena</a></li>
            <li><a href="pokedex.php">Pokedex</a></li>
        </ul>
    </nav>
    <main hidden>
        <h2>Exercise 2: Loading Items from a database</h2>
        <h3>My Team</h3>
        <id  id="pokemonDataDiv" class="flexed"></id>
        
    
        <script>
            // Exercise 3 Instructions:
            // 1. Show the "nav" and on load with an fitting effect.
            // 2. If the user clicks on Logout, log the User out and send him to the index page
            // 3. Load the Team data from getTeam.php directly on document ready.
            // 4. When finished show the "main" and on load with a fitting effect.

            $(document).ready(function() {
                // 1. Show the nav with a fitting effect
                $("nav").removeAttr("hidden").fadeIn(800);

                // 2. Handle logout click
                $("#logout").click(function(e) {
                    e.preventDefault();
                    $.post("php/doLogout.php", function() {
                        window.location.replace("index.php");
                    });
                });

                // 3. Load team data from getTeam.php
                $.get("php/getTeam.php", function(data) {
                    $("#pokemonDataDiv").html(data);
                    
                    // 4. Show main with a fitting effect when data is loaded
                    $("main").removeAttr("hidden").fadeIn(800);
                });
            });
        </script>
    </main>
</body>

</html>

<!--

EXAMPLE how to format Pokemon Team:

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

