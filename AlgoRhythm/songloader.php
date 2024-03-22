<?php
$conn = mysqli_connect("localhost", "root", "", "algorhythm");

$songUploadDirectory = "uploads/";
$imageUploadDirectory = "songpictures/";

if(isset($_FILES['fileToUpload'])) {
    $songFileName = basename($_FILES['fileToUpload']['name']);
    $targetSongFile = $songUploadDirectory . $songFileName;
    if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetSongFile)) {
        echo "Il file della canzone è stato caricato correttamente.";
    } else {
        echo "Si è verificato un errore durante il caricamento del file della canzone.";
    }
}

if(isset($_FILES['image'])) {
    $imageFileName = basename($_FILES['image']['name']);
    $targetImageFile = $imageUploadDirectory . $imageFileName;
    if(move_uploaded_file($_FILES['image']['tmp_name'], $targetImageFile)) {
        echo "Il file immagine è stato caricato correttamente.";
    } else {
        echo "Si è verificato un errore durante il caricamento del file immagine.";
    }
}

if(isset($_POST['name']) && isset($_POST['genre'])) {
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $ID_Track = substr(uniqid(), 0, mt_rand(8, 16));
    $sql = "INSERT INTO track (ID_Track, name, genre, image, filePath) 
            VALUES ('$ID_Track', '$name', '$genre', '$targetImageFile', '$targetSongFile')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuova canzone inserita con successo nel database.";
    } else {
        echo "Errore durante l'inserimento della canzone nel database: " . $conn->error;
    }
}

$encodedDisplayName = isset($_POST['DisplayName']) ? $_POST['DisplayName'] : '';
$encodedEmail = isset($_POST['Email']) ? $_POST['Email'] : '';
$encodedImage = isset($_POST['Image']) ? $_POST['Image'] : '';
$Country = isset($_POST['Country']) ? $_POST['Country'] : '';

header("Location: ../Algorhythm/indexfake.php?DisplayName=" . urlencode($encodedDisplayName) . "&Email=" . urlencode($encodedEmail) . "&Image=" . urlencode($encodedImage) . "&Country=" . urlencode($Country));
exit;
?>
