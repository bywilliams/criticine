<?php require_once("templates/header.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);

$movieDao = new MovieDAO($conn, $BASE_URL);

// verifica se usuário está autenticado
$userData = $userDao->verifyToken(true);

$id = filter_input(INPUT_GET, "id");

$movie;

// Verifica id está vazio 
if (empty($id)) {
    $message->setMessage("O filme não foi encontrado.", "error", "index.php");
} else {

    $movie = $movieDao->findById($id);

    // Verifica se retornou resultado na busca pelo filme
    if (!$movie) {
        $message->setMessage("O filme não foi encontrado.", "error", "index.php");
    }

}

// checa se o filme tem imagem
if($movie->image == "") {
    $movie->image = "movie_cover.jpg";
}


?>


<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1>
                    <?= $movie->title ?>
                </h1>
                <p class="page-description">Altere os dados do filme no formulário abaixo:</p>
                <form id="edit-movie-form" action="<?= $BASE_URL ?>movie_process.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update">
                <input type="hidden" name="id" value="<?= $movie->id ?>">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" name="title" id="title" class="form-control"
                        placeholder="Digite o título para seu filme: " value="<?= $movie->title ?>">
                </div>
                <div class="form-group">
                    <label for="image">Imagem:</label>
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>
                <div class="form-group">
                    <label for="length">Duração:</label>
                    <input type="text" name="length" id="length" class="form-control"
                        placeholder="Digite a duração do filme:" value="<?= $movie->length ?>">
                </div>
                <div class="form-group">
                    <label for="category">Categoria:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Selecione</option>
                        <option value="Ação" <?= $movie->category === "Ação" ? "selected" : ""?>>Ação</option>
                        <option value="Drama" <?= $movie->category === "Drama" ? "selected" : ""?>>Drama</option>
                        <option value="Comédia" <?= $movie->category === "Comédia" ? "selected" : ""?>>Comédia</option>
                        <option value="Fantasia / Ficção" <?= $movie->category === "Fantasia / Ficção" ? "selected" : ""?>>Fantasia / Ficção</option>
                        <option value="Romance" <?= $movie->category === "Romance" ? "selected" : ""?>>Romance</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="trailer">Trailer:</label>
                    <input type="text" name="trailer" id="trailer" class="form-control"
                        placeholder="Insira o link do trailer:" value="<?= $movie->trailer ?>">
                </div>
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea name="description" id="description" rows="5" class="form-control"
                        placeholder="Descreva o filme:"><?= $movie->description ?></textarea>
                </div>
                <input type="submit" value="Editar filme" class="btn card-btn">
                </form>
            </div>
            <div class="col-md-3">
                <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image?>')"></div>
            </div>
        </div>
    </div>
</div>

<?php require_once("templates/footer.php") ?>