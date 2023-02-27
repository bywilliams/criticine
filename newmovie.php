<?php require_once("templates/header.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);

// verifica se usuário está autenticado
$userData = $userDao->verifyToken(true);
?>

<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-movie-container">
        <h1 class="page-title">Adicionar filme</h1>
        <p class="page-description">Adicione sua crítica e compartilhe com o mundo!</p>
        <form action="<?= $BASE_URL ?>movie_process.php" id="add-movie-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="create">
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Digite o título para seu filme: ">
            </div>
            <div class="form-group">
                <label for="image">Imagem:</label>
                <input type="file" name="image" id="image" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="length">Duração:</label>
                <input type="text" name="length" id="length" class="form-control" placeholder="Digite a duração do filme: ">
            </div>
            <div class="form-group">
                <label for="category">Categoria:</label>
                <select name="category" id="category" class="form-control">
                    <option value="">Selecione</option>
                    <option value="Ação">Ação</option>
                    <option value="Drama">Drama</option>
                    <option value="Comédia">Comédia</option>
                    <option value="Fantasia / Ficção">Fantasia / Ficção</option>
                    <option value="Romance">Romance</option>
                </select>
            </div>
            <div class="form-group">
                <label for="trailer">Trailer:</label>
                <input type="text" name="trailer" id="trailer" class="form-control" placeholder="Insira o link do trailer: ">
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme:"></textarea>
            </div>
            <input type="submit" value="Adicionar filme" class="btn card-btn">
        </form>

    </div>
</div>

<?php require_once("templates/footer.php") ?>