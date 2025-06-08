<?php
$host = 'mysql_server';       // ← Matches service name in docker-compose.yml
$db   = 'LoginTracker';
$user = 'user';
$pass = 'password';

// Use correct variable names
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}