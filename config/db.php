<?php 

$env = file_get_contents(".env");
$lines = explode("\n", $env);

foreach ($lines as $line) {
    $parts = explode("=", $line);
    if (count($parts) === 2) {
        $_ENV[$parts[0]] = $parts[1];
    }
}

$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME']; 

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

?>
