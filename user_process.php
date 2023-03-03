<?php

require_once("globals.php");
require_once("config.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("utils/check_password.php");

$userDAO = new UserDAO($conn, $BASE_URL);

$message = new Message($BASE_URL);

$type = filter_input(INPUT_POST, "type");

if ($type == "update") {

    // recebe dados do post
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");

    $user = new User();
    $userData = $userDAO->verifyToken();

    // Preencher os dados do usuário
    $userData->name = $name;
    $userData->lastname = $lastname;
    $userData->email = $email;
    $userData->bio = $bio;

    // Upload da imagem
    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
        
        $image = $_FILES["image"];

        // tipos permitidos
        $imagesTypes = ["image/jpg", "image/jpeg", "image/png"];
        $jpgArray = ["image/jpg", "image/jpeg"];

        // Checagem de tipo de imagem
        if (in_array($image["type"], $imagesTypes)) {
            
            if (in_array($image["type"], $jpgArray)) {
               
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);

            // se cair no else é png    
            }else {
                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }

        }else {
            $message->setMessage("Tipo inválido de imagem, insira imagens do tipo png ou jpg.", "error", "back");
        }

        // gera nome para imagem
        $imageName = $user->imageGenerateName();

        /*
        cria a imagem no diretorio, variável da imagem, 
        caminho para a imagenm, nome da imagem e qualidade para a imagem 
        */
        imagejpeg($imageFile, "./img/users/" . $imageName, 100);

        $userData->image = $imageName;

    }

    $userDAO->update($userData);

} else if ($type == "changePassword") {

    $password = filter_input(INPUT_POST, "password");
    $confirmPassword = filter_input(INPUT_POST, "confirmPassword");

    $userData = $userDAO->verifyToken();
    $id = $userData->id;

    if ($password) {

            if ($password === $confirmPassword) {

                if (password_strength($password)) { 

                    $user = new User();

                    $password_changed = $user->generatePassword($password);

                    $userData->password = $password_changed;
                    $userData->id = $id;
        
                    $userDAO->changePassword($userData);

                }else {
                    $message->setMessage("A senha deve possuir ao menos 8 caracteres, sendo pelo menos 1 letra maiúscula, 1 minúscula, 1 número e 1 simbolo.", "error", "editProfile.php");
                }
               
            }else {
                $message->setMessage("As senhas não são iguais.", "error", "editProfile.php");
            }
        
    }else {
        $message->setMessage("Por favor preencha os campos senha e confirmação de senha", "error", "editProfile.php");
    }
   
   
} else {
    $message->setMessage("Informações inválidas.", "error", "index.php");
}



