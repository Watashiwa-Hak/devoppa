<?php
session_start();
require '../../database.php'; // your DB connection

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "<script>
            alert('Invalid email or password.');
            window.location.href = 'athentication_form.php';
        </script>";
        exit();
    }

    // Fetch user by email
    $stmt = $conn->prepare("SELECT user_id, name, password, profile_image FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $user_name, $hashed_password, $profile_image);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Password correct: create session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $email;
            $_SESSION['profile_image'] = $profile_image ?? '../uploads/image/pic-1.png';

            // Log successful login
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
            $status = 'success';

            $log_stmt = $conn->prepare("INSERT INTO login_logs (user_id, email, login_time, ip_address, status, user_agent) VALUES (?, ?, NOW(), ?, ?, ?)");
            if ($log_stmt) {
                $log_stmt->bind_param("issss", $user_id, $email, $ip_address, $status, $user_agent);
                $log_stmt->execute();
                $log_stmt->close();
            }

            // Redirect to home or dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Wrong password
            $status = 'failed';
        }
    } else {
        // No such user
        $status = 'failed';
    }

    // Log failed login attempt (no user_id or user_id = null)
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
    $failed_user_id = null;
    $log_stmt = $conn->prepare("INSERT INTO login_logs (user_id, email, login_time, ip_address, status, user_agent) VALUES (?, ?, NOW(), ?, ?, ?)");
    if ($log_stmt) {
        $log_stmt->bind_param("issss", $failed_user_id, $email, $ip_address, $status, $user_agent);
        $log_stmt->execute();
        $log_stmt->close();
    }

    echo "<script>
        alert('Invalid email or password.');
        window.location.href = 'athentication_form.php';
    </script>";

    $stmt->close();
    $conn->close();

} else {
    echo "<script>
        alert('Invalid request method.');
        window.location.href = 'athentication_form.php';
    </script>";
}
?>