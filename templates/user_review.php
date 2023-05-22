<?php 
require_once("models/User.php");

// Traz o nome completo do usuário que fez a crítica
$userModel = new User();
$fullName = $userModel->getFullName($review->user);

// checa se o usuário tem imagem
if($review->user->image == "") {
    $review->user->image = "user.png";
}

?>

<div class="col-md-12 review">
    <div class="row">
        <div class="col-md-1">
            <div class="profile-image-container review-image"
                style="background-image: url('<?= $BASE_URL ?>img/users/<?= $review->user->image ?>')"></div>
        </div>
        <div class="col-md-9 author-details-container">
            <h4 class="author-name">
                <a href=""><?= $fullName; ?></a>
            </h4>
            <p> <i class="fas fa-star text-warning">&nbsp;</i><?= $review->rating ?> </p>
        </div>
        <div class="col-md-12">
            <p class="comment-title">Comentário:</p>
            <p><?= $review->review ?></p>
        </div>
    </div>
</div>