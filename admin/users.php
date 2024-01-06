<?php
$pageInfo = array(
    'title' => 'Listagem de Usuários',
    'description' => 'Visualize e gerencie os usuários cadastrados.',
    'pageName' => 'users',
);

include_once('../components/admin/header.php');

include_once('../helpers/database.php');

$connection = connectDatabase();

$query = "SELECT id, name, email, about, image, created_at  FROM users;";

$result = mysqli_query($connection, $query);

$users = array();

if (mysqli_num_rows($result) > 0) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
            <a href="create_user.php" class="btn btn-success my-2 my-sm-0 text-light">
                Adicionar novo usuário
            </a>
            <hr>
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Data de Registro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($users as $user) { ?>

                                <tr>
                                    <td>
                                        <?php echo $user['name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $user['email']; ?>
                                    </td>
                                    <td>
                                        <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Ações
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="edit_user.php?user_id=<?= $user['id'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                    Editar
                                                </a>
                                                <a class="dropdown-item text-danger" href="requests/request_delete_users.php?user_id=<?= $user['id'] ?>">
                                                    <i class="fas fa-trash"></i>
                                                    Excluir
                                                </a>

                                                <a class="dropdown-item" href="#" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                    Detalhes
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
$currentPage = 'users';
include_once('../components/admin/footer.php');
?>