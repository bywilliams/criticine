<?php

require_once("globals.php");
require_once("config.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("utils/check_password.php");

$userDAO = new UserDAO($conn, $BASE_URL);

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

            if (password_strength($password)) {

                // Checa se e-mail já existe no sistema
                if ($userDAO->findByEmail($email) === false) {

                    $user = new User();

                    // Criação de token e senha 
                    $userToken = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);

                    // cria o usuário
                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $finalPassword; //password final em hash
                    $user->token = $userToken;

                    $auth = true;

                    $userDAO->create($user, $auth);
                } else {

                    //Envia mensagem de erro, usuário já existe
                    $message->setMessage("Usuário já cadastrado, tente outro e-mail.", "error", "back");
                }
            } else {
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

    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    // Tenta autenticar usuário
    if ($userDAO->authenticateUser($email, $password)) {



        // Dá as boas vindas para o usuário que efetuou o login
        $message->setMessage("Seja bem-vindo!", "success", "editProfile.php");

        // redireciona usuário, caso não conseguir atenticar

    } else {
        // envia msg de erro, usuário ou senha não encontrados
        $message->setMessage("E-mail e/ou senha inválidos.", "error", "back");
    }
} else {
    // se tentar algo estranho expulsa para a index
    $message->setMessage("Informações inválidas.", "error", "index.php");
}
