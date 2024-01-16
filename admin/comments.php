<?php

$pageInfo = array(
    'title' => 'Listagem de Comentários',
    'description' => 'Visualize e gerencie os comentários nas postagens.',
    'pageName' => 'comments',
);

$pageName = $pageInfo['pageName'];

include_once('../components/admin/header.php');

include_once('../helpers/database.php');

$connection = connectDatabase();

$queryc = "SELECT
comments.id as id,
comments.content as content,
comments.created_at as created_at,
users.name as name
 FROM comments
 JOIN users ON users.id = comments.user_id";

$result = mysqli_query($connection, $queryc);

$comments = array();

if(mysqli_num_rows($result) > 0){
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$queryu = "SELECT name FROM users;";

$result = mysqli_query($connection, $queryu);

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
            <hr>
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Autor</th>
                                <th>Comentário</th>
                                <th>Data de Comentário</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($comments as $comment){ ?>
                            <tr>

                                <td>
                                    <?php echo $comment['id']; ?>
                                </td>
                                <td>
                                    <?php echo $comment['name']; ?>
                                </td>
                                <td>
                                    <?php echo $comment['content']; ?>
                                </td>
                                <td>
                                    <?php echo date('d/m/Y', strtotime($comment['created_at'])); ?>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-edit"></i>
                                                Editar
                                            </a>
                                            <a class="dropdown-item text-danger" href="requests/request_delete_comment.php?comment_id=<?= $comment['id'] ?>">
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
include_once('../components/admin/footer.php');
?>
