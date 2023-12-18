<?php
session_start();


include_once('../../helpers/database.php');

// Estabelece uma conexão com o servidor
$connection = connectDatabase();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém dados do usuário
    $user_id = $_POST["user_id"];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $about = $_POST['about'];
    $user_image = $_POST['image'];

// Usar prepared statements para proteger contra SQL injection
$name = mysqli_real_escape_string($connection, $name);
$email = mysqli_real_escape_string($connection, $email);
$password = mysqli_real_escape_string($connection, $password);
$about = mysqli_real_escape_string($connection, $about);
$image = mysqli_real_escape_string($connection, $image);

// Criptografa a senha
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

if ($_FILES['image']['size'] > 0){

    // Processar a upload da nova imagem

    $targetDir ='../../../src/img/imgperfil/'; // Define um local 
    $randomName = uniqid() . "_" . basename($_FILES['image']['name']); // Transforma o nome da imagem em um nome aleátorio
    $targetFile = $targetDir . $randomName; // Faz a função de random name funcionar. 
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));


    // Validação da imagem
    if(!getimagesize($_FILES['image']['tmp_name']) || file_exists($targetFile) || $_FILES['image']['size'] > 500000){
        $_SESSION['message'] = "Desculpe, a sua imagem deve ter no máximo 5MB.";
        $_SESSION['message_type'] = "danger";
        $uploadOk = 0;
        header("Location: ../profile.php");
    }
        

        // Verificar se ocorreu algum erro durante o upload da imagem
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK){
            $_SESSION['message'] = 'Erro no upload da imagem.';
            $_SESSION['message_type'] = 'danger';
        }else {
        // Se tudo estiver ok, tenta fazer o upload
        if($uploadOk == 1 && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)){
            
            $image_path ="src/img/imgperfil/" . basename($_FILES["image"]["name"]);
            // Atualizar os dados do perfil no banco de dados
            $query ="UPDATE users SET name ='$name', email ='$email', password ='$password_hashed', about ='$about', image ='$image_path' WHERE id ='$user_id'";
            if (mysqli_query($connection, $query)){
                $_SESSION['message'] = 'Imagem alterada com sucesso.';
                $_SESSION['message_type'] = 'success';
            }else {
                $_SESSION['message'] = 'Erro ao editar o perfil.';
                $_SESSION['message_type'] = 'danger';
                }
            }else {
                $_SESSION['message'] = 'Erro ao fazer upload da imagem.';
                $_SESSION['message_type'] = 'danger';
            }
        }
    }else {
        // Atualizar os dados do usuário no banco de dados
        $query ="UPDATE users SET name ='$name', email ='$email', password ='$password_hashed', about ='$about', image ='$image_path' WHERE id ='$user_id'";
        if (mysqli_query($connection, $query)){
            $_SESSION['message'] = 'Imagem alterada com sucesso.';
            $_SESSION['message_type'] = 'success';
        }else {
            $_SESSION['message'] = 'Erro ao editar o perfil.';
            $_SESSION['message_type'] = 'danger';
        }
    }
    // Redirecionar de volta para o dashboard
    header("Location: ../profile.php");
    exit();
}

