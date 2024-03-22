<?php
$conn = mysqli_connect("localhost", "root", "", "algorhythm");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["Image"]) && $_FILES["Image"]["error"] == 0) {
    $target_directory = "img/";
    $target_file = $target_directory . basename($_FILES["Image"]["name"]);
    
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "Sono permesse solo immagini JPG, JPEG, PNG e GIF.";
        exit; 
    }
    
    if (move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file)) {
        $Image = $target_file; 
        $Image = str_replace("img/", "", $target_file);
    } else {
        echo "Si è verificato un errore durante il caricamento del file.";
        exit; 
    }
} else {
    echo "Nessun file è stato caricato.";
    exit; 
}

$Email = $_POST['Email'];
$DisplayName = $_POST['DisplayName'];
$Password = $_POST['Password'];
$Country = "IT";


$ID_User = substr(uniqid(), 0, mt_rand(8, 16));


$insertinto = "INSERT INTO user (ID_User, Email, DisplayName, Password, Country, Image) 
                VALUES ('$ID_User', '$Email', '$DisplayName', '$Password', '$Country', '$Image')";
$r = mysqli_query($conn, $insertinto);

if (!$r) {
    echo "Query non eseguita";
} else {
    
    $encodedDisplayName = urlencode($DisplayName);
    $encodedEmail = urlencode($Email);
    $encodedImage = urlencode($Image);
    header("Location: ../Algorhythm/homedb.php?DisplayName=$encodedDisplayName&Email=$encodedEmail&Image=$encodedImage&Country=$Country");
}

$conn->close();
?>