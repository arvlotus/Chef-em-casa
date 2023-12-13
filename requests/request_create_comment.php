<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header('Location: ../login.php');
}

include_once('../helpers/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $connection = connectDatabase();

    $post_id = $_POST['post_id'];
    $comment = $_POST['content'];
    $user_id = $_SESSION['user_id'];


    $post_id = mysqli_real_escape_string($connection, $post_id);
    $comment = mysqli_real_escape_string($connection, $comment);
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO comments (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$comment')";

    if (mysqli_query($connection, $query)) {
        $connection = connectDatabase();
        $_SESSION['message'] = "Seu comentário foi publicado com sucesso";
        $_SESSION['message_type'] = "success";
        header("Location: ../post.php?post_id=$post_id");
    } else {
        $_SESSION['message'] = "Ocorreu um erro ao enviar seu comentário";
        $_SESSION['message_type'] = "danger";
        header("Location: ../post.php?post_id=$post_id");
    }
}
