<?php

require_once("globals.php");
require_once("config.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");

$message = new Message($BASE_URL);
$userDAO = new UserDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);

// Resgata o tipo do formulário
$type = filter_input(INPUT_POST, "type");

//resgata os dados do usuário
$userData = $userDAO->verifyToken();

if ($type === "create") {

    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $length = filter_input(INPUT_POST, "length");
    $category = filter_input(INPUT_POST, "category");
    $trailer = filter_input(INPUT_POST, "trailer");

    $movie = new Movie();

    // Validação minima de dados
    if (!empty($title) && !empty($description) && !empty($category)) {

        $movie->title = $title;
        $movie->description = $description;
        $movie->length = $length;
        $movie->category = $category;
        $movie->trailer = $trailer;
        $movie->users_id = $userData->id;

        // Upload de imagem do filme
        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];
            // tipos permitidos
            $imagesTypes = ["image/jpg", "image/jpeg", "image/png"];
            $jpgArray = ["image/jpg", "image/jpeg"];

            // Checa o tipo da imagem
            if (in_array($image["type"], $imagesTypes)) {
                // Chea se imagem é JPG
                if (in_array($image["type"], $jpgArray)) {
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else {
                    // Cria como PNG
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                // Ggerando o nome da imagem
                $imageName = $movie->imageGenerateName();

                imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                $movie->image = $imageName;

            } else {
                $message->setMessage("Tipo inválido de imagem, insira imagens do tipo png ou jpg.", "error", "back");
            }

        }

        // Salva o filme no BD
        $movieDao->create($movie);

    } else {
        $message->setMessage("Você precisa adicionar pelo menos: titulo, descrição e categoria!", "error", "back");
    }


} else if ($type === "delete"){

    // Recebe os dados do form
    $id = filter_input(INPUT_POST, "id");

    $movie = $movieDao->findById($id);

    if($movie) {
        // Verificar se o filme é do usuário
        if($movie->users_id === $userData->id) {

            $movieDao->destroy($movie->id);

        }else {
            $message->setMessage("Informações inválidas.", "error", "index.php");
        }

    }else {
        $message->setMessage("Informações inválidas.", "error", "index.php");
    }
    

} else if ($type === "update"){

    // recebe os dados dos inputs
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $length = filter_input(INPUT_POST, "length");
    $category = filter_input(INPUT_POST, "category");
    $trailer = filter_input(INPUT_POST, "trailer");
    $id = filter_input(INPUT_POST, "id");


    $movie = $movieDao->findById($id);

    if($movie) {

        // Verificar se o filme é do usuário
        if($movie->users_id === $userData->id) {

            // Validação minima de dados
            if (!empty($title) && !empty($description) && !empty($category)) {

                // Edição do filme
                $movie->title = $title;
                $movie->description = $description;
                $movie->length = $length;
                $movie->category = $category;
                $movie->trailer = $trailer;

                // Upload de imagem do filme
                if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                    $image = $_FILES["image"];
                    $imagesTypes = ["image/jpg", "image/jpeg", "image/png"];
                    $jpgArray = ["image/jpg", "image/jpeg"];

                    // Checa o tipo da imagem
                    if (in_array($image["type"], $imagesTypes)) {

                        // Chea se imagem é JPG
                        if (in_array($image["type"], $jpgArray)) {
                            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                        } else {
                            // Cria como PNG
                            $imageFile = imagecreatefrompng($image["tmp_name"]);
                        }

                        // Ggerando o nome da imagem
                        $imageName = $movie->imageGenerateName();

                        imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                        $movie->image = $imageName;

                    } else {
                        $message->setMessage("Tipo inválido de imagem, insira imagens do tipo png ou jpg.", "error", "back");
                    }

                }
                
                $movieDao->update($movie);


            } else {
                $message->setMessage("Você precisa adicionar pelo menos: titulo, descrição e categoria!", "error", "back");
            }

        }else {
            $message->setMessage("Informações inválidas.", "error", "index.php");
        }


    }else {
        $message->setMessage("Informações inválidas.", "error", "index.php");
    }

} else {
    $message->setMessage("Informações inválidas.", "error", "index.php");
}