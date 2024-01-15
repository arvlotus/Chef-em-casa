<?php
session_start();

include_once('../../helpers/database.php');

$comment_id = $_GET['comment_id'];

$connection = connectDatabase();

$query = "SELECT * FROM comments WHERE id = '$comment_id'";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    $delete_query = "DELETE FROM comments WHERE id = '$comment_id'";
    $delete_result = mysqli_query($connection, $delete_query);

    if ($delete_result) {
        $_SESSION['message'] = "O comentario foi deletado com sucesso.";
        $_SESSION['message_type'] = "success";
        header("Location: ../banners.php");
    }
}
?>