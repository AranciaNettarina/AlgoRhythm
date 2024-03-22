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
session_start();
$accessToken = $_SESSION["access_token"];
$clientId = '5d2ef00b7f3245158b71e04be91edb06'; 
$redirectUri = 'http://localhost/Presacane/AlgoRhythm/callback.php'; 
$countryCode="IT";
$loginUrl = "https://accounts.spotify.com/authorize?client_id=$clientId&redirect_uri=$redirectUri&scope=user-read-private%20user-read-email%20user-read-playback-state%20user-modify-playback-state%20user-read-currently-playing%20app-remote-control%20streaming%20user-library-read%20user-library-modify%20user-read-playback-position%20user-read-recently-played%20user-top-read%20playlist-read-private%20playlist-read-collaborative%20playlist-modify-public%20playlist-modify-private%20ugc-image-upload%20user-follow-modify%20user-follow-read&response_type=code";
$userInfoEndpoint = "https://api.spotify.com/v1/me";
$recentlyPlayedEndpoint = "https://api.spotify.com/v1/me/player/recently-played";

$chUserInfo = curl_init();
curl_setopt($chUserInfo, CURLOPT_URL, $userInfoEndpoint);
curl_setopt($chUserInfo, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $accessToken
));
curl_setopt($chUserInfo, CURLOPT_RETURNTRANSFER, true);

$chRecentlyPlayed = curl_init();
curl_setopt($chRecentlyPlayed, CURLOPT_URL, $recentlyPlayedEndpoint);
curl_setopt($chRecentlyPlayed, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $accessToken
));
curl_setopt($chRecentlyPlayed, CURLOPT_RETURNTRANSFER, true);

$chartsAlbumsEndpoint = "https://api.spotify.com/v1/browse/new-releases?after=2023-03-01&before=2023-03-31&country=$countryCode&limit=4";
$chTopAlbums = curl_init();
curl_setopt($chTopAlbums, CURLOPT_URL, $chartsAlbumsEndpoint);
curl_setopt($chTopAlbums, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $accessToken
));
curl_setopt($chTopAlbums, CURLOPT_RETURNTRANSFER, true);

$multiHandler = curl_multi_init();
curl_multi_add_handle($multiHandler, $chUserInfo);
curl_multi_add_handle($multiHandler, $chRecentlyPlayed);
curl_multi_add_handle($multiHandler, $chTopAlbums);

do {
    $status = curl_multi_exec($multiHandler, $active);
    if ($active) {
        curl_multi_select($multiHandler);
    }
} while ($active && $status == CURLM_OK);

$userInfoResponse = curl_multi_getcontent($chUserInfo);
$userData = json_decode($userInfoResponse, true);

$recentlyPlayedResponse = curl_multi_getcontent($chRecentlyPlayed);
$recentlyPlayedData = json_decode($recentlyPlayedResponse, true);

$topAlbumsResponse = curl_multi_getcontent($chTopAlbums);
$topAlbumsData = json_decode($topAlbumsResponse, true);


curl_multi_remove_handle($multiHandler, $chUserInfo);
curl_multi_remove_handle($multiHandler, $chRecentlyPlayed);
curl_multi_remove_handle($multiHandler, $chTopAlbums);
curl_multi_close($multiHandler);

if (empty($recentlyPlayedData['items'])) {
    echo "No recently played tracks found.";
} else {
    $mostRecentTrackId = $recentlyPlayedData['items'][0]['track']['id'];

    if (empty($mostRecentTrackId)) {
        echo "No track ID found for the most recent track.";
    } else {
        $recommendationsEndpoint = "https://api.spotify.com/v1/recommendations?limit=4&seed_tracks=" . $mostRecentTrackId;

        $chRecommendations = curl_init();
        curl_setopt($chRecommendations, CURLOPT_URL, $recommendationsEndpoint);
        curl_setopt($chRecommendations, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $accessToken
        ));
        curl_setopt($chRecommendations, CURLOPT_RETURNTRANSFER, true);

        $recommendationsResponse = curl_exec($chRecommendations);

        if ($recommendationsResponse === false) {
            echo 'Error: ' . curl_error($chRecommendations);
        } else {
            $statusCode = curl_getinfo($chRecommendations, CURLINFO_HTTP_CODE);
            if ($statusCode != 200) {
                echo 'Error: ' . $statusCode;
                echo 'Response: ' . $recommendationsResponse;
            } else {
                $recommendationsData = json_decode($recommendationsResponse, true);
            }
        }

        curl_close($chRecommendations);
    }
}




?>







        
                

    <div class="d-flex flex-row mb-2">
        <div class="d-flex flex-column mb-8 menu-laterale">
            <div class="p-2"><img class="ratio ratio-21x9 logo-grey" src="img/logo_grey.png"></div>
            <div class="menu-buttons">
                <div  class="p-2 d-flex flex-row menu-div">
                    <img class="icon-img me-3"src="img/home.png" alt="">
                    <p class="menu-text">Home</p>
                </div>
                <div class=" p-2 d-flex flex-row menu-div">
                    <img class="icon-img me-3"src="img/lens.png" alt="">
                    <a href="search.php"><p class="menu-text">Search</p></a>
                </div>
                <div  class=" p-2 d-flex flex-row menu-div">
                    <img class="icon-img me-3"src="img/book.png" alt="">
                    <p class="menu-text">Library</p>
                </div>
                <div  class=" p-2 d-flex flex-row menu-div middle-menu">
                    <img class="icon-img me-3"src="img/add.png" alt="">
                    <p class="menu-text">Create Playlist</p>
                </div>
                <div  class=" p-2 d-flex flex-row menu-div">
                    <img class="icon-img me-3"src="img/like.png" alt="">
                    <p class="menu-text">Liked songs</p>
                </div>
                <div  class=" p-2 d-flex flex-row menu-div bottom-menu">
                    <img class="icon-img me-3"src="img/settings.png" alt="">
                    <p class="menu-text">Setting</p>
                </div>
                <div id="logoutButton" class=" p-2 d-flex flex-row menu-div">
                    <img class="icon-img me-3"src="img/logout.png" alt="">
                    <p class="menu-text">Logout</p>
                    
                </div>
            </div>

        </div>
    
        <div class="d-flex flex-column mb-9 section2">
            
            <div class="d-flex flex-row mb-4 mt-3">
                <h1 class="ms-2">Welcome <?php 
                if (isset($userData["display_name"])) {
                    echo $userData["display_name"];
                } else {
                    echo "to AlgoRhythm";
                }
                ?></h1>
                <div class="ms-auto d-flex flex-row">
                    <div class="notification-container d-flex align-items-center me-2 "><img src="img/notification.png" class="icon-img" alt=""></div>
                    <div class="user-container d-flex align-items-center me-5 " id="login"><img src="<?php 
                    if (isset($userData["images"]["0"]["url"])) {
                        echo $userData["images"]["0"]["url"];
                    } else {
                        echo "img/user.png";
                    }                    
                    ?>" class="user-image" alt=""></div>
                    
                    



                    <script>
                        var user = document.getElementById("login");

                        user.addEventListener("click", function() {
                            redirectToLogin();
                        });

                        function redirectToLogin() {
                            window.location.href = "<?php echo $loginUrl; ?>";
                        }
                    </script>

                </div>
            </div>
            <div class="d-flex flex-row">
                <h2 class="ms-3 align-items-center">Top Albums in <?php echo $countryCode ?></h2>
                <button class="view-all mt-1 ms-auto me-5"><p class="view-text">View all</p></button>
            </div>
            <div class="d-flex flex-row flex-wrap mb-4 your-picks mt-3 justify-content-around">
            <?php
if (isset($topAlbumsData['albums'])) {
    $albums = $topAlbumsData['albums']['items'];
    $albumCount = count($albums);

    for ($i = 0; $i < $albumCount; $i++) {
        if ($i % 2 == 0) {
            echo '<div class="flex-wrap d-flex flex-row category2 justify-content-around">';
        }

        $album = $albums[$i];

        if (isset($album['images']) && !empty($album['images'])) {
            $albumImageUrl = $album['images'][2]['url'];
            $albumTitle = $album['name'];

            echo '<div class="quick-category" style="background-image: url(' . $albumImageUrl . '); background-size:cover;   ">';
            
            echo "<b class='textDiv'>$albumTitle</b>";
            echo '</div>';
        } else {
            echo 'No images found for this album.';
        }

        if (($i + 1) % 2 == 0 || $i == ($albumCount - 1)) {
            echo '</div>'; 
        }
    }
} else {
    echo 'No top albums found.';
}
?>
</div>
            <div class="d-flex flex-row">
                <h2 class="align-items-center ms-3">Your Picks</h2>
                <button class="view-all mt-1 ms-auto me-5"><p class="view-text">View all</p></button>
            </div>
            <div class="d-flex flex-row flex-wrap mb-4 your-picks mt-3 justify-content-around">
            <?php
            if (isset($recommendationsData['tracks'])) {
                foreach ($recommendationsData['tracks'] as $track) {
                    if (isset($track['album']['images']) && !empty($track['album']['images'])) {
                        $trackImageUrl = $track['album']['images'][0]['url'];
                        $trackTitle = $track['name'];
                        $trackArtists = implode(", ", array_column($track['artists'], 'name'));
                        echo '<div class="quick-category" style="background-image: url(' . $trackImageUrl . ');">';
                        echo "<b class='textDiv'>$trackTitle</b>";
                        echo "<b class='textDiv'>$trackArtists</b>";
                        echo '</div>';
                    } else {
                        echo 'No images found for this track.';
                    }
                }
            } else {
                echo 'No recommendations data found.';
            }
            ?>
            </div>
            <h2 class="mt-3 ms-3 mb-5">Recently Listened</h2>
            <div class="ms-3">
            <?php
$_SESSION['songs'] = [];

if (isset($recentlyPlayedData['items']) && is_array($recentlyPlayedData['items'])) {
    $num = 0;
    foreach ($recentlyPlayedData['items'] as $item) {
        $songName = $item['track']['name'];
        $artistName = $item['track']['artists'][0]['name'];
        $albumName = $item['track']['album']['name'];
        $trackImage = $item['track']['album']['images'][0]['url'];

        $songExists = false;
        foreach ($_SESSION['songs'] as $song) {
            if ($song['songName'] === $songName) {
                $songExists = true;
                break;
            }
        }

        if (!$songExists) {
            $_SESSION['songs'][] = [
                'songName' => $songName,
                'artistName' => $artistName,
                'albumName' => $albumName,
                'trackImage' => $trackImage
            ];

            echo '<div class="d-flex flex-row mb-3 track">';
            echo '<img src="' . $trackImage . '" class="track-image">';
            echo '<div class="d-flex flex-column mb-2 track-name">';
            echo '<div><p class="track-title mb-0">' . $songName . '</p></div>';
            echo '<div><p class="track-artist mb-0">' . $artistName . '</p></div>';
            echo '</div>';
            echo '<div class="d-flex align-items-center ms-auto play-container"><a href="main.php?index=' . $num . '"><img src="img/play.png" class="play-icon"></a></div>';
            echo '</div>';
            $num++;
        }
    }
} else {
    echo "No tracks found.";
}






?>




        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>