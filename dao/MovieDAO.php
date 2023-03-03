<?php
require_once("globals.php");
require_once("models/Message.php");


Class MovieDAO implements MovieDAOInterface {

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildMovie($data) {

    }

    public function findAll() {
      
    }

    public function getLatestMovies() {

    }
    public function getMoviesByCategory($category) {

    }
    public function getMoviesByUserId($id) {

    }
    public function findById($id) {

    }
    public function findByTitle($title) {

    }
    public function create(Movie $movie) {

    }
    public function update(Movie $movie) {

    }
    public function destroy($id) {

    }
}
