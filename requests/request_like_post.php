<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header('Location: ../login.php');
}

include_once ('../helpers/database.php');

$connection = connectDatabase();

$post_id = $_GET['post_id'];
$user_id = $_SESSION['user_id'];

$post_id = mysqli_real_escape_string($connection, $post_id);

$query ="INSERT INTO likes (post_id, user_id) VALUES ('$post_id', '$user_id')";

if(mysqli_query($connection, $query)){
        $_SESSION['message'] = "Você curtiu está publicação";
        $_SESSION['message_type'] = "success";
        header("Location: ../post.php?post_id=$post_id");
    }

?>