<?php
session_start();

include_once('../../helpers/database.php');

$banner_id = $_GET['banner_id'];
$connection = connectDatabase();

$query = "SELECT * FROM banners WHERE id = '$banner_id'";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    $delete_query = "DELETE FROM banners WHERE id = '$banner_id'";
    $delete_result = mysqli_query($connection, $delete_query);

    if ($delete_result) {
        $_SESSION['message'] = "O banner foi deletado com sucesso.";
        $_SESSION['message_type'] = "success";
        header("Location: ../banners.php");
    }
}
?>