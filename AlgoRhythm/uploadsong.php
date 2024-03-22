<?php
$encodedDisplayName = isset($_GET['DisplayName']) ? $_GET['DisplayName'] : '';
$encodedEmail = isset($_GET['Email']) ? $_GET['Email'] : '';
$encodedImage = isset($_GET['Image']) ? $_GET['Image'] : '';
$Country = isset($_GET['Country']) ? $_GET['Country'] : '';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File </title>
</head>
<body>
    <h1>Upload File</h1>
    <form action="songloader.php" method="post" enctype="multipart/form-data">
        Nome della canzone: <input type="text" name="name"><br>
        Genere: <input type="text" name="genre"><br>
        Immagine: <input type="file" name="image"><br>
        Seleziona il file MP3/WAV: <input type="file" name="fileToUpload" id="fileToUpload"><br>
        <input type="hidden" name="DisplayName" value="<?php echo urlencode($encodedDisplayName); ?>">
        <input type="hidden" name="Email" value="<?php echo urlencode($encodedEmail); ?>">
        <input type="hidden" name="Image" value="<?php echo urlencode($encodedImage); ?>">
        <input type="hidden" name="Country" value="<?php echo urlencode($Country); ?>">
        <input type="submit" value="Carica File" name="submit">
    </form>
    
</body>
</html>
