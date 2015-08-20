<?php
//$servername = "localhost";
//$username = "username";
//$password = "password";
//$dbname = "myDB";

$dbhost  = 'localhost';    // Unlikely to require changing
$dbname  = 'rhedata';       // Modify these...
$dbuser  = 'sheryl';   // ...variables according
$dbpass  = 'rhepassword';   // ...to your installation
$appname = "Rug Hooking Exchange"; // ...and preference


// Create connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM ItemsForSale";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "itemid: <br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?> 