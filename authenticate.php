<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $users = file('users.txt', FILE_IGNORE_NEW_LINES);
    
    foreach ($users as $user) {
        list($username, $storedEmail, $storedPassword) = explode(':', $user);
        
        if ($email == $storedEmail && password_verify($password, $storedPassword)) {
            $_SESSION['username'] = $username;
            
            if ($email == 'admin@admin.com') {
                $_SESSION['role'] = 'admin';
                header('Location: admin.php');
            } else {
                $_SESSION['role'] = 'user';
                header('Location: user.php');
            }
            
            exit;
        }
    }
    header('Location: login.php');
    exit;
}
?>