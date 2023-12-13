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

$query ="DELETE FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";

if(mysqli_query($connection, $query)){
        $_SESSION['message'] = "Você descurtiu está publicação";
        $_SESSION['message_type'] = "danger";
        header("Location: ../post.php?post_id=$post_id");
    }

?>