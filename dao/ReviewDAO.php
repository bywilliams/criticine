<?php 

require_once("models/Movie.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

class ReviewDAO implements ReviewDAOInterface {

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildReview($data) {

        $reviewObject = new Review();

        $reviewObject->id = $data['id'];
        $reviewObject->rating = $data['rating'];
        $reviewObject->review = $data['review'];
        $reviewObject->movies_id = $data['movies_id'];
        $reviewObject->users_id = $data['users_id'];

        return $reviewObject;

    }
    public function create(Review $review) {

    }
    public function getMoviewsReview($id) {

    }
    public function hasAlreadyReviewed($id, $users_id) {

    }
    public function getRating($id) {

    }

}