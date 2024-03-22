<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://sdk.scdn.co/spotify-player.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>@import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@700&display=swap');</style>
    <link rel="stylesheet" href="home.css">
    <title>Temp</title>
</head>
<body>

<?php
session_start(); 

if (isset($_SESSION['songs']) && isset($_GET['index'])) {
    $index = $_GET['index'];

    if (isset($_SESSION['songs'][$index])) {
        $songDetails = $_SESSION['songs'][$index];
        
        if (isset($songDetails)) {
            $songName = isset($songDetails['songName']) ? $songDetails['songName'] : "";
            $artistName = isset($songDetails['artistName']) ? $songDetails['artistName'] : "";
            $albumName = isset($songDetails['albumName']) ? $songDetails['albumName'] : "";
            $trackImage = isset($songDetails['trackImage']) ? $songDetails['trackImage'] : "";
            $songName = str_replace(' ', '_', $songName); 
          
        } else {
            echo "Song details not found.";
        }
    } else {
        echo "Invalid index or song not found.";
    }
} else {
    echo "No index provided or songs not found.";
}


        $accessToken = $_SESSION['access_token'];
        $trackId=NULL;

          
            $searchEndpoint = "https://api.spotify.com/v1/search?q=$songName&type=track";
            $ch = curl_init($searchEndpoint);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $accessToken,
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $searchResponse = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
            }
            curl_close($ch);
            $searchData = json_decode($searchResponse, true);

            if (isset($searchData['tracks']['items'][0]['id'])) {
                $trackId = $searchData['tracks']['items'][0]['id'];
            }


        $apiEndpoint = "https://api.spotify.com/v1/tracks/$trackId";
        $ch = curl_init($apiEndpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        curl_close($ch);
        $trackData = json_decode($response, true);


    ?>

    <!-- <form method="post">
        <label for="songName">serch by Name:</label>
        <input type="text" id="songName" name="songName">
        <input type="submit" name="submit" value="Search">
        
    </form>
-->
    <script>
        var token = '<?= $accessToken ?>';
        var trackId = '<?= $trackId ?>';
    </script>

<div class="d-flex flex-column ">
    <div>
    <img src="<?php echo $trackImage; ?>" class="background-image">

    </div>
    <div class="playerContainer">
            <div class="d-flex flex-column mb-3">
            <p class="name-player"><?php $songName=str_replace('_', ' ', $songName); echo $songName ?></p>
            <p class="artist-player"><?php echo $artistName ?></p>
            <input id="seekBar" type="range" class="music-control" value="0" min="0" step="1">
            <!-- <div class="d-flex flex-row justify-content-between">
                <p class="track-time">0:00</p>
                <p class="track-time">3:36</p>
            </div>
            -->
            <div class="playerDiv justify-content-around">
                <button id="previousTrack"><img src="img/back.png" class="icon-img control-button"></button>
                <button id="togglePlay"><img src="img/pause.png" class="icon-img control-button"></button>
                <button id="nextTrack"><img src="img/forward.png" class="icon-img control-button"></button>
            </div>
        </div>
                
            <!--
            <button id="highervolume">Higher Volume 0.1/1</button>
            <button id="lowervolume">Lower Volume 0.1/1</button>
            <input type="range" id="seekBar" value="0" min="0" step="1">
            <button id="bck5">Back 5 sec</button>
            <button id="fwd5">Forward 5 sec</button>
            -->

    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
