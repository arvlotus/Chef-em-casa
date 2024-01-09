<?php
session_start();

include_once('../../helpers/database.php');

$user_id = $_GET['user_id'];
$connection = connectDatabase();

$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    $delete_query = "DELETE FROM users WHERE id = '$user_id'";
    $delete_result = mysqli_query($connection, $delete_query);

    if ($delete_result) {
        $_SESSION['message'] = "O usuario foi deletado com sucesso.";
        $_SESSION['message_type'] = "success";
        header("Location: ../users.php");
    }
}
