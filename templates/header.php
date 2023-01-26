<?php

require_once("globals.php");
require_once("config.php");
require_once("models/Message.php");

$message = new Message($BASE_URL);

$flassMessage = $message->getMessage();

if (!empty($flassMessage)) {
    # limpa a mensagem
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieStar</title>
    <link rel="short icon" href="<?=$BASE_URL?>img/moviestar.ico">
    <!-- BootStrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" />
    <!-- FontAewsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- Folha de estilo local -->
    <link rel="stylesheet" href="<?=$BASE_URL?>css/style.css">
</head>
<body>
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg">
            <a href="<?=$BASE_URL?>" class="navbar-brand">
                <img src="<?=$BASE_URL?>img/logo.svg" alt="MovieStar" id="logo">
                <span id="moviestar-title">MovieStar</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="navigation">
                <i class="fas fas-bars"></i>
            </button>
            <form action="" method="GET"  id="search-form" class="form-inline my-2 my-lg-0">
                <input type="text" name="q" id="search"  class="form-control mr-sm-2" type="search" 
                placeholder="Buscar filmes" aria-label="Search">
                <button class="btn my-2 my-sm-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?=$BASE_URL?>auth.php" class="nav-link">Entrar / Cadastrar</a>
                    </li>
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

  