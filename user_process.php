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
    
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");

    $userData = $userDAO->verifyToken();

    $userData->name = $name;
    $userData->lastname = $lastname;
    $userData->email = $email;
    $userData->bio = $bio;
    
    $userDAO->update($userData);

} else if($type == "changePassword") {
    echo "mudar password";
}else {
    $message->setMessage("Informações inválidas.", "error", "index.php");
}