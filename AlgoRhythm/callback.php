<?php
session_start();

$clientId = '5d2ef00b7f3245158b71e04be91edb06';  // Replace with your Spotify app's client ID
$clientSecret = '9580d455479b460a9e6aec5f2cb1200c';  // Replace with your Spotify app's client secret
$redirectUri = 'http://localhost/Presacane/AlgoRhythm/callback.php';  // Specify the correct redirect URI

// Step 1: Get the authorization code from the query parameters
$code = $_GET['code'];

$tokenUrl = 'https://accounts.spotify.com/api/token';
$data = [
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => $redirectUri,
    'client_id' => $clientId,
    'client_secret' => $clientSecret
];

$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($tokenUrl, false, $context);
$response = json_decode($result, true);

// Step 3: Store the access token in the session
$_SESSION= $response;

// Redirect to the main page
header('Location: home.php');
exit;
?>
