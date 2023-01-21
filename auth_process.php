<?php

require_once("globals.php");
require_once("config.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");

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
        echo"<script>alert('Ok dados preenchidos');</script>";
    }else {
        echo"<script>alert('Preencha os dados antes de continuar');</script>";
        //header("Location: auth.php");
    }

}else if ($type === 'login') {

}