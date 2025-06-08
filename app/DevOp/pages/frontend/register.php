<?php
require '../../database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/plain');


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        echo 'error: missing fields';
        exit();
    }

   $email = strtolower(trim($_POST['email'] ?? ''));

$stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo 'error: email already registered';
    exit();
}

    else {
        $stmt->close();
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if (!$stmt) {
            echo 'error: prepare failed - ' . $conn->error;
            exit();
        }
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error: ' . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error: invalid method';
}