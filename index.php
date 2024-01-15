<?php

$pageInfo = array(
  'pageName' => 'index',
  'title' => 'Chef Em Casa - Inspire-se na Culinária em Comunidade',
  'description' => 'Bem-vindo ao Chef Em Casa, o seu destino online para explorar, criar e compartilhar experiências culinárias únicas. Descubra receitas deliciosas, compartilhe suas próprias criações e conecte-se com uma comunidade apaixonada por culinária. Seja você um chef experiente ou alguém apenas começando sua jornada na cozinha, aqui você encontrará inspiração para cada paladar.'
);

// Inclui o arquivo de conexão com o banco de dados
include_once('helpers/database.php');

// Conexão com o banco de dados
$connection = connectDatabase();

$querySimilarPosts = "SELECT *
FROM posts
LIMIT 3";

// Execução da query para buscar posts relacionados
$similar_posts = mysqli_query($connection, $querySimilarPosts);

$pageName = $pageInfo['pageName'];

include_once(__DIR__ . '/components/public/header.php');

$queryBanners = "SELECT * FROM banners";

$resultBanners = mysqli_query($connection, $queryBanners);

$banners = array();

if (mysqli_num_rows($resultBanners) > 0) {
  $banners = mysqli_fetch_all($resultBanners, MYSQLI_ASSOC);
}

?>
<main class="">
<section id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <?php foreach ($banners as $active => $banner): ?>
      <div class="carousel-item <?= $active === 0 ? 'active' : ''; ?>">
        <img src="<?= $banner['image']; ?>" class="d-block mx-auto" alt="Imagem do Carrossel">
      </div>
    <?php endforeach ?>
  </div>
</section>
  <section id="about" class="container py-5">
    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <img src="src/img/logo.png" alt="">
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6">
        <h1>
          Chef Em Casa - Inspire-se na Culinária em Comunidade
        </h1>
        <p>
          Bem-vindo ao Chef Em Casa, o seu destino online para explorar, criar e compartilhar experiências culinárias
          únicas. Descubra receitas deliciosas, compartilhe suas próprias criações e conecte-se com uma comunidade
          apaixonada por culinária. Seja você um chef experiente ou alguém apenas começando sua jornada na cozinha, aqui
          você encontrará inspiração para cada paladar.
        </p>
      </div>
    </div>
  </section>
  <section id="features" class=" features py-5">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-lg-3 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h4 class="card-icon">
                <i class="fas fa-utensils"></i>
              </h4>
              <h5 class="card-title">Explore Receitas Variadas</h5>
              <p class="card-text">Navegue por uma ampla variedade de receitas, desde pratos clássicos até criações
                inovadoras. Encontre a inspiração certa para a sua próxima refeição.</p>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-lg-3 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h4 class="card-icon">
                <i class="fas fa-users"></i>
              </h4>
              <h5 class="card-title">Compartilhe suas Receitas</h5>
              <p class="card-text">Torne-se um chef em destaque compartilhando suas próprias receitas exclusivas. Faça
                parte da comunidade Chef Em Casa e inspire outros amantes da culinária.</p>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-lg-3 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h4 class="card-icon">
                <i class="fas fa-comments"></i>
              </h4>
              <h5 class="card-title">Interação Comunitária</h5>
              <p class="card-text">Comente, curta e compartilhe suas impressões sobre as receitas de outros chefs.
                Explore
                fóruns e grupos temáticos para dicas e truques culinários.</p>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-lg-3 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h4 class="card-icon">
                <i class="fas fa-user-plus"></i>
              </h4>
              <h5 class="card-title">Junte-se a Nós</h5>
              <p class="card-text">Registre-se agora para criar seu perfil personalizado, salvar suas receitas favoritas
                e
                participar ativamente da comunidade Chef Em Casa. Transforme sua paixão pela culinária em uma jornada
                compartilhada de descobertas e sabores.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="blog" class="blog py-5">
    <div class="container">
      <h2 class="text-center mb-4">Últimas Postagens</h2>
      <div class="row">
        <?php while ($similar_post = mysqli_fetch_assoc($similar_posts)) { ?>
          <div class="col-md-6">
            <div class="card mb-4 mx-auto" >
              <img src="<?php echo $similar_post['image']; ?>" class="card-img-top" alt="<?php echo $similar_post['title']; ?>" title="<?php echo $similar_post['title']; ?>" style="max-height: 25git0px;">
              <div class="card-body">
                <h6 class="card-title">
                  <a href="post.php?post_id=<?php echo $similar_post['id']; ?>">
                    <?php echo $similar_post['title']; ?>
                  </a>
                </h6>
              </div>
            </div>
          </div>
        <?php } ?>
        <!-- Mensagem se não houver posts relacionados -->
        <?php if (mysqli_num_rows($similar_posts) == 0) { ?>
          <div class="alert alert-info">
            O autor não possui outros posts.
          </div>
        <?php } ?>
      </div>
      <div class="text-center mt-4">
        <a href="todas-as-postagens.html" class="btn btn-lg btn-outline-primary">Ver Todas as Postagens</a>
      </div>
    </div>
  </section>
  <section id="cta" class="text-white text-center py-5">
    <div class="container">
      <h2 class="mb-4">Faça parte da nossa comunidade!</h2>
      <p class="lead mb-4">Registre-se agora para ter acesso a receitas exclusivas, interagir com outros chefs e
        compartilhar suas próprias criações.</p>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <a href="cadastro.php" class="btn btn-light btn-lg btn-block">Cadastre-se</a>
        </div>
        <div class="col-md-6">
          <a href="login.php" class="btn btn-outline-light btn-lg btn-block">Login</a>
        </div>
      </div>
    </div>
  </section>


</main>

<?php
include_once(__DIR__ . '/components/public/footer.php');
?>