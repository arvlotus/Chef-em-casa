<?php

include_once('../helpers/database.php');

// Verifica se um ID de post foi passado via GET
if (isset($_GET['banner_id'])) {
    $banner_id = $_GET['banner_id'];
} else {
    // Se nenhum ID foi fornecido, redirecione para uma página de erro ou para a lista de posts
    header("Location: ../404.php");
    exit();
}

// Conecta-se ao banco de dados
$connection = connectDatabase();

// Obtém os dados do post existente
$query = "SELECT title, image FROM banners WHERE id = '$banner_id'";
$result = mysqli_query($connection, $query);

// Verifica se o post existe
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $existing_title = $row['title'];
    $existing_image = $row['image'];
} else {
    // Se o post não existir, redirecione para uma página de erro ou para a lista de posts
    header("Location: ../404.php");
    exit();
}

// Informações da página
$pageInfo = array(
    'title' => 'Editar Banner',
    'description' => 'Edite seu banner existente.',
    'pageName' => 'edit_banner',
);

include_once('../components/admin/header.php');
?>

<!-- Conteúdo do dashboard -->
<main class="container py-5">
    <div class="row">
        <!-- Sidebar do dashboard -->
        <div class="col-md-3">
            <?php include_once('../components/admin/menu_sidebar.php'); ?>
        </div>
        <!-- Main do dashboard -->
        <section class="col-md-9">
            <h2><?= $pageInfo['title'] ?></h2>
            <p><?= $pageInfo['description'] ?></p>
            <hr>
            <div class="card">
                <div class="card-body">
                    <?php if (isset($_SESSION['message'])) { ?>
                        <div class="alert alert-<?= $_SESSION['message_type'] ?>" role="alert">
                            <?= $_SESSION['message']; ?>
                        </div>
                    <?php unset($_SESSION['message']); } ?>
                    <form action="requests/request_edit_banner.php" method="post" enctype="multipart/form-data">
                        <!-- Adiciona um campo oculto para enviar o ID do post -->
                        <input type="hidden" name="banner_id" value="<?= $banner_id ?>">
                        <div class="form-group">
                            <label for="title">Título do Banner</label>
                            <!-- Preenche o campo com o título existente -->
                            <input type="text" class="form-control" id="title" name="title"
                                value="<?= $existing_title ?>">
                        </div>
                        <div class="form-group">
                            <label for="image">Imagem do Banner</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                            <!-- Exibe a imagem existente para referência -->
                            <img src="../<?= $existing_image ?>" alt="Imagem Existente" class="img-thumbnail mt-2"
                                style="max-width: 200px;">
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
$currentPage = 'edit_banner';
include_once('../components/admin/footer.php');
?>
