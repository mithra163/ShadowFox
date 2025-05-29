<?php
$conn = new mysqli("localhost", "root", "", "project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if (empty($username) || empty($new_password) || empty($confirm_password)) {
    echo "<script>alert('All fields are required.'); window.history.back();</script>";
    exit();
}

if ($new_password !== $confirm_password) {
    echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
    exit();
}
$hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
$stmt = $conn->prepare("UPDATE datas SET password = ? WHERE username = ?");
$stmt->bind_param("ss", $hashed_password, $username);
if ($stmt->execute()) {
    echo "<script>alert('Password updated successfully!'); window.location.href='login.html';</script>";
} else {
    echo "<script>alert('Error updating password!'); window.history.back();</script>";
}

$conn->close();
?>
