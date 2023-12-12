<?php

class AdminController extends Controller 
{
    public function __construct() 
    {
        $this->view = new View('admin_template');
    }

    public function index() 
    {
        $this->view->render("Дэшборд", "admin/dashboard");
    }

    public function movies() 
    {
        $movieModel = new MovieModel();
        $movies = $movieModel->getAll();
        $this->view->add("movies", $movies);
        $this->view->render("Фильмы", "admin/movies");
    }

    public function tickets() 
    {
        $ticketModel = new TicketModel();
        $tickets = $ticketModel->getAll();
        $this->view->add("tickets", $tickets);
        $this->view->render("Билеты", "admin/tickets");
    }

    public function sessions() 
    {
        $sessionModel = new SessionModel();
        $sessions = $sessionModel->getAll();
        $this->view->add("sessions", $sessions);
        $this->view->render("Сеансы", "admin/sessions");
    }

    public function createMovie() 
    {
        $title = $_POST['title'];
        $releaseYear = $_POST['release_year'];
        $genre = $_POST['genre'];
        $director = $_POST['director'];
        $description = $_POST['description'];
        $ageRating = $_POST['age_rating'];
        $duration = $_POST['duration'];
        $rating = $_POST['rating'];
        $posterUrl = $_POST['poster_url'];
        $trailerUrl = $_POST['trailer_url'];
        $movieModel = new MovieModel();
        $movieModel->create($title, $releaseYear, $genre, $description, $director, 
                                    $ageRating, $duration, $rating, $posterUrl, $trailerUrl);
        redirect('/admin/movies');
    }

    public function updateMovie($id) 
    {
        $title = $_POST['title'];
        $releaseYear = $_POST['release_year'];
        $genre = $_POST['genre'];
        $director = $_POST['director'];
        $description = $_POST['description'];
        $ageRating = $_POST['age_rating'];
        $duration = $_POST['duration'];
        $rating = $_POST['rating'];
        $posterUrl = $_POST['poster_url'];
        $trailerUrl = $_POST['trailer_url'];
        $movieModel = new MovieModel();
        $movieModel->update($id, $title, $releaseYear, $genre, $description, $director, 
                                    $ageRating, $duration, $rating, $posterUrl, $trailerUrl);
        redirect('/admin/movies');
    }

    public function deleteMovie($id) 
    {
        $movieModel = new MovieModel();
        $movies = $movieModel->delete($id);
        redirect('/admin/movies');
    }
}