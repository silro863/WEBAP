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
    <script src="js/scripts/arena.js"> </script>
</head>

<body>
    <header>
        <img class="logo" src="img/logo.png" alt="Pokémon">
        <h1>3. Ajax dynamic content Exercises</h1>
    </header>
    <?php
   // kick user to index if not logged in.
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
    <main>

        <section class="half">
            <h2>Battles:</h2>
            <div id="battles">
            </div>
        </section>
        <section class="half">
            <h2>Demand Fight:</h2>
            <div id="opponents">

            </div>
        </section>
        <section id="arenaContainer">
            <h1>Arena</h1>
            <h2><span id="playername"></span> VS. <span id="opponentname"></span></h2>
            <div id="arena">
                <div class="pokemon" id="player">
                    <img id="playerimg" src="assets/pokedata/images/000.png" alt="player">
                    <div class="pokemon-health"></div>
                    <div class="health-bar">
                        <div class="current-health"></div>
                    </div>
                    <div class="health-text">
                        <span class="current-hp">100</span>/<span class="max-hp">100</span> HP
                    </div>
                    <button class="btnAttack" type="button">Attack</button>
                    <button class="btnAttack" type="button">Give up</button>
                </div>
                <div class="pokemon" id="opponent">
                    <img id="opponentimg" src="assets/pokedata/images/000.png" alt="opponent">
                    <div class="pokemon-health"></div>
                    <div class="health-bar">
                        <div class="current-health"></div>
                    </div>
                    <div class="health-text">
                        <span class="current-hp">100</span>/<span class="max-hp">100</span> HP
                    </div>
                </div>
            </div>
        </section>
    </main>
    <dialog id="chooseDefendant">
        <h2 class="break">Choose defendant:</h2>
    <div class="flexed"></div>    
</dialog>
    <dialog id="win"></dialog>
    <dialog id="lose"></dialog>
</body>

</html>