<?php
require_once("templates/header.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);

// Pega todos os dados o usuário pelo Token
$userData = $userDao->verifyToken(true);

$fullName = $user->getFullName($userData);

// Se o usuário não tiver imagem cadastrada, define uma padrão para o layout
if ($userData->image == "") {
    $userData->image = "user.png";
}

?>


<div id="main-container" class="container-fluid edit-profile-page">
    <div class="col-md-12">
        <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <div class="row">
                <div class="col-md-4">
                    <h1><?= $fullName ?></h1>
                    <p class="page-description">Altere os dados no formulário abaixo:</p>
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Digite seu nome"
                            value="<?= $userData->name ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome:</label>
                        <input type="text" name="lastname" id="lastname" class="form-control"
                            placeholder="Digite seu soobrenome" value="<?= $userData->lastname ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="text" name="email" id="email" readonly class="form-control disable"
                            placeholder="Digite seu e-mail" value="<?= $userData->email ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div id="profile-image-container"
                        style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')">
                    </div>
                    <div class="form-group">
                        <label for="name">Foto:</label>
                        <input type="file" name="image" id="file" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <label for="bio">Sobre você:</label>
                        <textarea class="form-control" name="bio" id="bio" rows="5"
                            placeholder="Fale sobre quem você é, o que faz, onde trabalha..."><?= $userData->bio ?></textarea>
                    </div>
                    <input type="submit" class="btn card-btn" value="Alterar">
                </div>
            </div>
        </form>
        <div class="row" id="change-password-container">
            <div class="col-md-4">
                <h2>Alterar a senha:</h2>
                <p class="page-description">Digite a nova senha e clique em alterar.</p>
                <form action="<?= $BASE_URL ?>user_process.php" method="post">
                <input type="hidden" name="type" value="changePassword">
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Digite sua nova senha">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirmação de senha:</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control"
                            placeholder="Confirme sua nova senha">
                    </div>
                    <input type="submit" class="btn card-btn" value="Alterar Senha">
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once("templates/footer.php") ?>