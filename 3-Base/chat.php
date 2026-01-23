<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon Chat</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.cdnfonts.com/css/g-guarantee" rel="stylesheet">
    <script type="text/javascript" src="js/code.jquery.com_jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/code.jquery.com_ui_1.13.2_jquery-ui.js"></script>
</head>

<body>
    <header>
        <img class="logo" src="img/logo.png" alt="Pokémon">
        <h1> - Chat</h1>
    </header>
    <?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: index.php");
        exit;
    }
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
        <h2>Trainer Chat</h2>
        
        <div class="trainer-select">
            <label for="trainerSelect">Select Trainer to Chat With:</label>
            <select id="trainerSelect">
                <option value="">-- Select a Trainer --</option>
                <option value="all">All</option>
            </select>
        </div>
        
        <div class="chat-container">
            <div id="chatMessages"></div>
            <div class="chat-input-area">
                <input type="text" id="messageInput" placeholder="Type a message...">
                <button id="sendButton">Send</button>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $("nav").removeAttr("hidden").fadeIn(800);
            $("main").removeAttr("hidden").fadeIn(800);

            $("#logout").click(function(e) {
                e.preventDefault();
                $.post("php/doLogout.php", function() {
                    window.location.replace("index.php");
                });
            });

            function loadTrainers() {
                $.getJSON("php/getTrainersList.php", function(trainers) {
                    let select = $("#trainerSelect");
                    select.html('<option value="">-- Select a Trainer --</option><option value="all">📢 Send to Everyone</option>');
                    $.each(trainers, function(index, trainer) {
                        select.append('<option value="' + trainer.idTrainer + '">' + trainer.username + '</option>');
                    });
                });
            }

            function loadMessages() {
                let selectedTrainer = $("#trainerSelect").val();
                if (!selectedTrainer) {
                    $("#chatMessages").html('<p>Select a trainer to start chatting</p>');
                    return;
                }

                $.getJSON("php/getMessages.php", {"trainer": selectedTrainer}, function(messages) {
                    let html = '';
                    $.each(messages, function(index, msg) {
                        let msgClass = msg.isSent ? 'sent' : 'received';
                        let senderName = msg.isSent ? 'You' : msg.senderName;
                        html += '<div class="message ' + msgClass + '">';
                        html += '<strong>' + senderName + ':</strong> ' + msg.message;
                        html += '<div class="message-time">' + msg.timestamp + '</div>';
                        html += '</div>';
                    });
                    $("#chatMessages").html(html);
                    $("#chatMessages").scrollTop($("#chatMessages")[0].scrollHeight);
                });
            }

            loadTrainers();

            $("#trainerSelect").change(function() {
                loadMessages();
            });

            $("#sendButton").click(function() {
                let message = $("#messageInput").val();
                let selectedTrainer = $("#trainerSelect").val();

                if (!message.trim()) {
                    alert("Please type a message");
                    return;
                }

                if (!selectedTrainer) {
                    alert("Please select a trainer");
                    return;
                }

                $.post("php/sendMessage.php", {
                    "trainer": selectedTrainer,
                    "message": message
                }, function(response) {
                    $("#messageInput").val('');
                    loadMessages();
                });
            });

            setInterval(function() {
                let selectedTrainer = $("#trainerSelect").val();
                if (selectedTrainer) {
                    $.getJSON("php/checkNewMessages.php", {"trainer": selectedTrainer}, function(data) {
                        if (data.hasNew) {
                            let notification = '<div class="chat-notification">' +
                                '<span class="chat-notification-close">&times;</span>' +
                                '<strong>' + data.senderName + '</strong> sent you a message!<br>' +
                                '<em>' + data.message + '</em>' +
                                '</div>';
                            $("body").append(notification);

                            setTimeout(function() {
                                $(".chat-notification").fadeOut(function() {
                                    $(this).remove();
                                });
                            }, 5000);

                            $(".chat-notification-close").click(function() {
                                $(this).parent().fadeOut(function() {
                                    $(this).remove();
                                });
                            });

                            loadMessages();
                        }
                    });
                }
            }, 2000);
        });
    </script>
</body>

</html>
