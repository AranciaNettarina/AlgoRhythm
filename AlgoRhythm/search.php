<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://sdk.scdn.co/spotify-player.js"></script>
    <script src="js/script.js"></script>
    <title>Temp</title>
</head>
<body>

    <h1>SEARCH SONG</h1>

    <?php
        session_start();

        $accessToken = $_SESSION['access_token'];
        $trackId=NULL;
        if (isset($_POST['submit'])) {
            $songName = $_POST['songName'];
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

    <form method="post">
        <label for="songName">Search by Name:</label>
        <input type="text" id="songName" name="songName">
        <input type="submit" name="submit" value="Search">
        
    </form>

    <script>
        var token = '<?= $accessToken ?>';
        var trackId = '<?= $trackId ?>';
    </script>

    <button id="togglePlay">Pause/Play</button>
    <button id="nextTrack">Next Track</button>
    <button id="previousTrack">Previous Track</button>
    <button id="bck5">Back 5 sec</button>
    <button id="fwd5">Forward 5 sec</button>
    <button id="highervolume">Higher Volume 0.1/1</button>
    <button id="lowervolume">Lower Volume 0.1/1</button>


</body>
</html>
