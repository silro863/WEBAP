<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon Basics</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.cdnfonts.com/css/g-guarantee" rel="stylesheet">
    <!-- import Libraries -->
</head>

<body>
    <header>
        <img class="logo" src="img/logo.png" alt="Pokémon">
        <h1>3. Ajax dynamic content Exercises</h1>
    </header>
    <?php
    // Check if the session field "id" is set.
    // If not, kick the user out to the login Page. 
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
        <id  id="pokemonDataDiv" class="flexed"></id>
        
    
        <script>
            // Exercise 3 Instructions:
            // 1. Show the "nav" and on load with an fitting effect.
            // 2. If the user clicks on Logout, log the User out and send him to the index page
            // 3. Load the Team data from getTeam.php directly on document ready.
            // 4. When finished show the "main" and on load with a fitting effect.

     
        </script>
    </main>
</body>

</html>