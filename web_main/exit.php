<?php
session_start();

require "this_file.php";




$login = $_POST['login']; 
$password = trim($_POST['password']);

// существует ли пользователь с таким именем или почтой
$stmt = $conn->prepare("SELECT userName, password FROM users WHERE userName = ? OR email = ?");
$stmt->bind_param("ss", $login, $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['user'] = $row['userName'];
       
        header("Location: sobakafirst.html");
        setcookie("username", $row['userName'], time() + (30 * 24 * 60 * 60), "/");
        exit(); 
    } else {
        echo "Неверный пароль. ";
    }
} else {
    echo "Пользователь не найден.";
}



$stmt->close();
$conn->close();
?>
