<?php require_once("templates/header.php");
require_once("models/Movie.php");
require_once("dao/MovieDAO.php");

$movieDao = new MovieDAO($conn, $BASE_URL);

// pega o id do filme
$id = filter_input(INPUT_GET, "id");

$movie;

// Verifica se existe id 
if(empty($id)) {
    $message->setMessage("O filme não foi encontrado.", "error", "index.php");
}else {

    $movie = $movieDao->findById($id);

    // Verifica se retornou resultado na busca pelo filme
    if(!$movie) {
        $message->setMessage("O filme não foi encontrado.", "error", "index.php");
    }

}

// Checar se o filme é do usuário
$userOwnsMovie = false;

// checa primeiro se o usuário está logado
if(!empty($userData)) {

    if($userData->id === $movie->users_id) {
        $userOwnsMovie = true;
        echo "filme é do usuário";
    }

}

//TODO: resgatar as reviews do filme

?>