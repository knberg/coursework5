<?php

class HomeController extends Controller 
{
    public function __construct() 
    {
        $this->view = new View('home_template');
    }

    public function index() 
    {
        $movieModel = new MovieModel();
        $movies = $movieModel->getAll();
        $this->view->add('movies', $movies);
        $this->view->render('Главная', "home/index");
    }

    public function kids() 
    {
        $movieModel = new MovieModel();
        $movies = $movieModel->getByGenre('мультфильм');
        $this->view->add('movies', $movies);
        $this->view->render('Детям', "home/kids");
    }

    public function contacts() 
    {
        $this->view->render('Контакты', "home/contacts");
    }

    public function about() 
    {
        $this->view->render('О нас', "home/about");
    }

    public function film($id) 
    {
        $movieModel = new MovieModel();
        $movie = $movieModel->getById($id);
        if ($movie == null) redirect('/');

        $date = $_GET['date'] ?? date("Y-m-d");

        $sessionModel = new SessionModel();
        $sessions = $sessionModel->getByMovieAndDateGroupByHall($id, $date);
        $this->view->add('date', $date);
        $this->view->add('movie', $movie);
        $this->view->add('sessions', $sessions);
        $this->view->render($movie['title'], "home/film");
    }
}