<?php
define('DB_SERVER', 'localhost',);
define('DB_USERNAME', 'root');  
define('DB_PASSWORD', '');      
define('DB_NAME', 'sipermi');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>