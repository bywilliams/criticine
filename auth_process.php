<?php

require_once("globals.php");
require_once("config.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("utils/check_password.php");

$message = new Message($BASE_URL);

// Resgata o tipo do formulário ex: register | login
$type = filter_input(INPUT_POST, "type");

if ($type === 'register') {
    $email = filter_input(INPUT_POST, "email");
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $password = filter_input(INPUT_POST, "password");
    $confirmPassword = filter_input(INPUT_POST, "confirmPassword");

    // Verificação de dados mínimos

    if ($name && $lastname && $email && $password) {

        if ($password === $confirmPassword) {
            
            if(password_strength($password)){
                echo "password forte";
            }else{
                $message->setMessage("A senha deve possuir ao menos 8 caracteres, sendo pelo menos 1 letra maiúscula, 1 minúscula, 1 número e 1 simbolo.", "error", "back");
            }

            // echo "<script>alert('Ok as senhas são iguais');</script>";
        } else {
            // envia msg de erro, senhas não conferem 
            $message->setMessage("As senhas não são iguais.", "error", "back");
        }
    } else {
        // envia msg de erro, dados faltantes
        $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
    }
} else if ($type === 'login') {
}
