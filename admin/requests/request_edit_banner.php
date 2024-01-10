<?php
session_start();

include_once('../../helpers/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $banner_id = $_POST["banner_id"];
    $title = $_POST["title"];

    $connection = connectDatabase();

    // Usar prepared statements para proteger contra SQL injection
    $title = mysqli_real_escape_string($connection, $title);

    // Verifica se uma nova imagem foi enviada
    if ($_FILES["image"]["size"] > 0) {
        // Processar o upload da nova imagem
        $targetDir = "../../src/img/banners";  // Substitua pelo diretório correto
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Verificar se ocorreu algum erro durante o upload
        if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
            $_SESSION['message'] = 'Erro no upload da imagem.';
            $_SESSION['message_type'] = 'danger';
        } else {
            // Se tudo estiver ok, tentar fazer o upload
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $image_path = "src/img/banners" . basename($_FILES["image"]["name"]);
                // Atualizar os dados do post no banco de dados
                $query = "UPDATE banners SET title = '$title', image = '$image_path' WHERE id = '$banner_id'";
                if (mysqli_query($connection, $query)) {
                    $_SESSION['message'] = 'Banner editado com sucesso.';
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['message'] = 'Erro ao editar o banner.';
                    $_SESSION['message_type'] = 'danger';
                }
            } else {
                $_SESSION['message'] = 'Erro ao fazer upload da imagem.';
                $_SESSION['message_type'] = 'danger';
            }
        }
    } else {
        // Se nenhuma nova imagem foi enviada, apenas atualize os dados do post no banco de dados
        $query = "UPDATE banners SET title = '$title', WHERE id = '$banner_id'";
        if (mysqli_query($connection, $query)) {
            $_SESSION['message'] = 'Banner editado com sucesso.';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Erro ao editar o banner.';
            $_SESSION['message_type'] = 'danger';
        }
    }

    // Redirecionar de volta para a página de edição ou para a lista de posts
    header("Location: ../edit_banner.php?banner_id=$banner_id");
    exit();
}
?>
