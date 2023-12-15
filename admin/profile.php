<?php

$pageInfo = array(
    'title' => 'Meu Perfil',
    'description' => 'Visualize e gerencie suas informações de perfil.',
    'pageName' => 'profile',
);

include_once('../components/admin/header.php');

// Conecta-se ao banco de dados
$connection = connectDatabase();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];


    $query = "SELECT
    name as user_name,
    about as user_about,
    image as user_image,
    email as user_email
    FROM users
    WHERE id = '$user_id'";

    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_name = $row['user_name'];
        $user_about = $row['user_about'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
    } else {
        // Se o post não existir, redirecione para uma página de erro ou para a lista de posts
        header("Location: ../404.php");
        exit();
    }
} else {
    // Se não houver uma sessão de usuário, redirecione para a página de login
    header("Location: ../login.php");
    exit();
}

include_once('../components/admin/header.php');
?>

<!-- Conteúdo da página de perfil -->
<main class="container py-5">
    <div class="row">
        <!-- Informações do perfil -->
        <section class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <img src="<?php echo $user_image; ?>" alt="Foto de Perfil" class="img-fluid mb-3" alt="Foto de usuário" title="Foto de usuário">
                    <h5>
                        <?php echo $user_name; ?>
                    </h5>
                    <p>
                        <?php echo $user_about; ?>
                    </p>
                    <p>Email: <?php echo $user_email; ?></p>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <form action="requests/atualizar_perfil.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?php echo $user_id ?>">

                        <div class="form-group">
                            <label for="image">Foto de usuário</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user_name ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">Endereço de Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_email ?>">
                        </div>

                        <div class="form-group">
                            <label for="about">Sobre</label>
                            <input type="about" class="form-control" id="about" name="about" value="<?php echo $user_about ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Nova Senha</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirme sua senha</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </div>

        </section>

        <!-- Publicações e Comentários -->
        <section class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <!-- Tabs para Comentários e Curtidas -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="comentarios-tab" data-toggle="tab" data-target="#comentarios" type="button" role="tab" aria-controls="comentarios" aria-selected="true">
                                Meus Comentários
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="curtidas-tab" data-toggle="tab" data-target="#curtidas" type="button" role="tab" aria-controls="curtidas" aria-selected="false">
                                Minhas Curtidas
                            </button>
                        </li>
                    </ul>

                    <!-- Conteúdo das Tabs -->
                    <div class="tab-content" id="myTabContent">
                        <!-- Tab de Comentários -->
                        <div class="tab-pane fade show active" id="comentarios" role="tabpanel" aria-labelledby="comentarios-tab">
                            <!-- Exemplo de Comentários -->
                            <div class="media mb-3">
                                <img src="path/to/fake-profile-image.jpg" class="mr-3 rounded-circle" alt="Foto de Perfil">
                                <div class="media-body">
                                    <h5 class="mt-0">Usuário Exemplo</h5>
                                    <p>Comentário exemplo 1. <i class="far fa-thumbs-up"></i> 5 curtidas</p>
                                </div>
                            </div>

                            <div class="media">
                                <img src="path/to/fake-profile-image.jpg" class="mr-3 rounded-circle" alt="Foto de Perfil">
                                <div class="media-body">
                                    <h5 class="mt-0">Outro Usuário</h5>
                                    <p>Comentário exemplo 2. <i class="far fa-thumbs-up"></i> 10 curtidas</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tab de Curtidas -->
                        <div class="tab-pane fade" id="curtidas" role="tabpanel" aria-labelledby="curtidas-tab">
                            <!-- Exemplo de Curtidas -->
                            <div class="media mb-3">
                                <img src="path/to/fake-profile-image.jpg" class="mr-3 rounded-circle" alt="Foto de Perfil">
                                <div class="media-body">
                                    <h5 class="mt-0">Usuário Exemplo</h5>
                                    <p>Curtiu a publicação: Título da Publicação 1</p>
                                </div>
                            </div>

                            <div class="media">
                                <img src="path/to/fake-profile-image.jpg" class="mr-3 rounded-circle" alt="Foto de Perfil">
                                <div class="media-body">
                                    <h5 class="mt-0">Outro Usuário</h5>
                                    <p>Curtiu a publicação: Título da Publicação 2</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</main>

<?php
$currentPage = 'index';
include_once('../components/admin/footer.php');
?>