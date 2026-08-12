<?php




$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'mafiga';
$port = (int) (getenv('DB_PORT') ?: 3306);

$conn = new mysqli($host, $user, $password, $dbname, $port);

?>
