<?php

require_once("globals.php");
require_once("config.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$flassMessage = $message->getMessage();

if (!empty($flassMessage)) {
    $message->clearMessage();
}

$userDao = new UserDAO($conn, $BASE_URL);

// Verifica o token so usuário, o header todos podem ter acesso então não é protected
$userData = $userDao->verifyToken(false);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criticine</title>
    <link rel="short icon" href="<?=$BASE_URL?>img/moviestar.ico">
    <!-- BootStrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"> 
    <!-- FontAewsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- Folha de estilo local -->
    <link rel="stylesheet" href="<?=$BASE_URL?>css/style.css">
</head>
<body>
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg">
            <a href="<?=$BASE_URL?>" class="navbar-brand">
                <img src="<?=$BASE_URL?>img/logo_criticine.png" alt="Criticine" id="logo">
                <span id="moviestar-title">CritiCine</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
            <form action="<?= $BASE_URL ?>search.php" method="GET"  id="search-form" class="form-inline my-2 my-lg-0">
                <input type="text" name="q" id="search"  class="form-control mr-sm-2" type="search" 
                placeholder="Buscar filmes" aria-label="Search">
                <button class="btn my-2 my-sm-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    <?php if($userData): ?>
                        <li class="nav-item">
                            <a href="<?=$BASE_URL?>newmovie.php" class="nav-link">
                                <i class="far fa-plus-square"></i> Incluir Filme
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=$BASE_URL?>dashboard.php" class="nav-link">Meus Filmes</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=$BASE_URL?>editProfile.php" class="nav-link bold">
                                <?=$userData->name?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=$BASE_URL?>logout.php" class="nav-link">Sair</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="<?=$BASE_URL?>auth.php" class="nav-link">Entrar / Cadastrar</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>



    <div class="nav-bar nav-bar-expand" id="search"></div>

    <?php if (!empty($flassMessage["msg"])): ?>
        <div class="msg-container">
            <p class="msg <?= $flassMessage["type"]?>"><?= $flassMessage["msg"]?></p>">
        </div>
    <?php endif; ?>

  