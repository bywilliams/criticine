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

$type = filter_input(INPUT_POST, 'type');

$userData = $userDAO->verifyToken();

if ($type === "create") {
    echo "teste";
}else {
    echo "else";
}