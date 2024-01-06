<?php
session_start();

include_once('../../helpers/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $user_id = $_POST["user_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $connection = connectDatabase();

    
    // Usar prepared statements para proteger contra SQL injection
    $title = mysqli_real_escape_string($connection, $title);
    $content = mysqli_real_escape_string($connection, $content);
}