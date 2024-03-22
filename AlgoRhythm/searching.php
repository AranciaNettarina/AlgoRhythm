<?php
  $conn = mysqli_connect("localhost","root", "", "algorhythm");
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
$displayName = $_GET['DisplayName'];
$password = $_GET['Password'];

$sql = "SELECT * FROM user WHERE DisplayName = '$displayName' AND Password = '$password'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Country = $row['Country'];
    $Image = $row['Image'];
    $Email = $row['Email'];
}
if ($result->num_rows > 0) {
    $encodedDisplayName = urlencode($displayName);
    $encodedEmail = urlencode($Email);
    $encodedImage = urlencode($Image); 
    $encodedCountry = urlencode($Country); 
    header("Location: ../Algorhythm/indexfake.php?DisplayName=$encodedDisplayName&Email=$encodedEmail&Image=$encodedImage");
} else {
    echo "DisplayName o Password non validi.";
}
$conn->close();

?>

