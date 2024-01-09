<?php

$pageInfo = array(
    'title' => 'Listagem de Banners da Pagina Inicial',
    'description' => 'Visualize e gerencie as imagens da pagina inicial.',
    'pageName' => 'banners',
);

include_once('../components/admin/header.php');

include_once('../helpers/database.php');

$connection = connectDatabase();

$query = "SELECT * FROM banners";

$result = mysqli_query($connection, $query);

$banners = array();

if (mysqli_num_rows($result) > 0) {
    $banners = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>


<!-- Conteúdo do dashboard -->
<main class="container py-5">
    <div class="row">
        <!-- Sidebar do dashboard -->
        <div class="col-md-3">
            <?php
            include_once('../components/admin/menu_sidebar.php');
            ?>
        </div>
        <!-- Main do dashboard -->
        <section class="col-md-9">
            <h2><?= $pageInfo['title'] ?></h2>
            <p><?= $pageInfo['description'] ?></p>
            <a href="create_banner.php" class="btn btn-success my-2 my-sm-0 text-light">
                Adicionar uma nova imagem
            </a>
            <hr>

            <?php if(isset($_SESSION['message'])){ ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?>" role="alert">
                    <?php echo $_SESSION['message']; ?>
                </div>
            <?php unset($_SESSION['message']); } ?>
            

            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Imagem</th>
                                <th>Data de Registro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($banners as $banner) { ?>

                                <tr>
                                    <td>
                                        <?php echo $banner['title']; ?>
                                    </td>
                                    <td>
                                        <?php echo $banner['image']; ?>
                                    </td>
                                    <td>
                                        <?php echo date('d/m/Y', strtotime($banner['created_at'])); ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Ações
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="edit_banner.php?banner_id=<?= $banner['id'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                    Editar
                                                </a>
                                                <a class="dropdown-item text-danger" href="requests/request_delete_banners.php?banner_id=<?= $banner['id'] ?>">
                                                    <i class="fas fa-trash"></i>
                                                    Excluir
                                                </a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <!-- Adicione mais linhas conforme necessário -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
$currentPage = 'banners';
include_once('../components/admin/footer.php');
?>