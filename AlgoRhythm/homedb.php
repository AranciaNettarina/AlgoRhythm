
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algorhytm - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="home.css">
    <script src="js/script.js"></script>
</head>
<body>

<?php
$conn = mysqli_connect("localhost", "root", "", "algorhythm");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$DisplayName = urldecode($_GET['DisplayName']);
$Email = urldecode($_GET['Email']);
$Image = urldecode($_GET['Image']); 
$Country = "IT"; 

?>
    <div class="d-flex flex-row mb-2">
        <div class="d-flex flex-column mb-8 menu-laterale">
            <div class="p-2"><img class="ratio ratio-21x9 logo-grey" src="img/logo_grey.png"></div>
            <div class="menu-buttons">
                <div  class="p-2 d-flex flex-row menu-div">
                    <img class="icon-img me-3"src="img/home.png" alt="">
                    <p class="menu-text">Home</p>
                </div>
                <a href="uploadsong.php?DisplayName=<?php echo urlencode($DisplayName); ?>&Email=<?php echo urlencode($Email); ?>&Image=<?php echo urlencode($Image); ?>&Country=<?php echo urlencode($Country); ?>" class="p-2 d-flex flex-row menu-div" style="text-decoration: none;">
                <div  class=" p-2 d-flex flex-row menu-div">
                     <img class="icon-img me-3" src="img/add.png" alt="">
                     <p class="menu-text">Upload Song</p>
                     </div>
                    </a>
                <div  class=" p-2 d-flex flex-row menu-div">
                    <img class="icon-img me-3"src="img/book.png" alt="">
                    <p class="menu-text">Library</p>
                </div>
                <div  class=" p-2 d-flex flex-row menu-div bottom-menu">
                    <img class="icon-img me-3"src="img/settings.png" alt="">
                    <p class="menu-text">Setting</p>
                </div>
                <a href="index.html" class="p-2 d-flex flex-row menu-div" style="text-decoration: none;">
                 <img class="icon-img me-3" src="img/logout.png" alt="">
                <p class="menu-text">Logout</p>
                </a>



            </div>

        </div>
    
        <div class="d-flex flex-column mb-9 section2">
            
            <div class="d-flex flex-row mb-4 mt-3">
            <h1 class="ms-2">Welcome <?php echo $DisplayName; ?> to AlgoRhythm!</h1>
                </h1>
                <div class="ms-auto d-flex flex-row">
                    <div class="notification-container d-flex align-items-center me-2 "><img src="img/notification.png" class="icon-img" alt=""></div>
                    <div class="user-container d-flex align-items-center me-5 " id="login"> <img src="img/<?php echo $Image; ?>" class="user-image" alt=""></div>
                    
                    <script>
                        var user = document.getElementById("login");

                        user.addEventListener("click", function() {
                            redirectToLogin();
                        });

                        function redirectToLogin() {
                            window.location.href = "register.html";
                        }
                    </script>

                </div>
            </div>
            <br>
            <div class="d-flex flex-row">
                <h2 class="align-items-center ms-3">Your Picks</h2>
                
            </div>
            <div class="d-flex flex-row flex-wrap mb-4 your-picks mt-3 justify-content-around">
            <?php
    $conn = mysqli_connect("localhost", "root", "", "algorhythm");

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    $query = "SELECT name, filePath, image FROM track ORDER BY RAND() LIMIT 4";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="your-category" style="background-image: url(' . $row["image"] . ');background-size: cover;" data-filepath="' . $row["filePath"] . '">' . $row["name"] . '</div>';
        }
    } else {
        echo "Nessuna canzone trovata nel database.";
    }

    $conn->close();
    ?>
                </div>
                <?php
$conn = mysqli_connect("localhost", "root", "", "algorhythm");

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Seleziona un genere a caso
$queryGenre = "SELECT genre FROM track ORDER BY RAND() LIMIT 1";
$resultGenre = $conn->query($queryGenre);
if ($resultGenre->num_rows > 0) {
    $rowGenre = $resultGenre->fetch_assoc();
    $randomGenre = $rowGenre['genre'];

    // Stampa il genere selezionato casualmente
    echo '<div class="d-flex flex-row">';
    echo '<h2 class="align-items-center ms-3">' . $randomGenre . ' Picks</h2>';
    echo '</div>';

    // Seleziona 4 canzoni casuali con lo stesso genere
    $querySongs = "SELECT name, filePath, image FROM track WHERE genre='$randomGenre' ORDER BY RAND() LIMIT 4";
    $resultSongs = $conn->query($querySongs);

    if ($resultSongs->num_rows > 0) {
        echo '<div class="d-flex flex-row flex-wrap mb-4 your-picks mt-3 justify-content-around">';
        while ($row = $resultSongs->fetch_assoc()) {
            echo '<div class="your-category" style="background-image: url(' . $row["image"] . ');background-size: cover;" data-filepath="' . $row["filePath"] . '">' . $row["name"] . '</div>';
        }
        echo '</div>';
    } else {
        echo "Nessuna canzone trovata nel database con il genere '$randomGenre'.";
    }
} else {
    echo "Nessun genere trovato nel database.";
}

$conn->close();
?>
<div style="display: flex; justify-content: center;">
    <button id="stopButton" class="btn btn-danger" onclick="stopSong()" style="max-width: 200px;">Stop</button>
    <button class="btn btn-danger" onclick="changeVolume('up')" style="max-width: 200px;">Aumenta volume</button>
<button class="btn btn-danger" onclick="changeVolume('down')" style="max-width: 200px;">Abbassa volume</button>
</div>



            </div>
            

<audio id="audioPlayer" controls style="display: none;"></audio>

<script>
    
    var audioPlayer = document.getElementById('audioPlayer');
    
    function changeVolume(direction) {
        var currentVolume = audioPlayer.volume;
        
        if (direction === 'up') {
            if (currentVolume < 1) {
                audioPlayer.volume += 0.1; 
            }
        } else if (direction === 'down') {
            if (currentVolume > 0) {
                audioPlayer.volume -= 0.1; 
            }
        }
    }
    function playSong(filePath) {
        audioPlayer.src = filePath;
        audioPlayer.play();
    }

    function stopSong() {
        audioPlayer.pause();
        audioPlayer.currentTime = 0;
    }

    var categoryElements = document.querySelectorAll('.your-category');
    categoryElements.forEach(function(element) {
        element.addEventListener('click', function() {
            var filePath = this.getAttribute('data-filepath');
            playSong(filePath);
        });
    });
</script>


            </div>
            <button class="view-all mt-1 ms-auto me-5"><p class="view-text">View More</p></button>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>