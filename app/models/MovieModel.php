<?php


class MovieModel extends Model 
{
    public function __construct() 
    {
        $this->db = new Database();
        $this->table = "movies";
    }

    public function create($title, $release_year, $genre, $description, $director, 
                            $age_rating, $duration, $rating, $poster_url, $trailer_url) 
    {
        $id = $this->db->insert($this->table, [
            'title' => $title, 
            'release_year' => $release_year,
            'genre' => $genre,
            'description' => $description,
            'director' => $director,
            'age_rating' => $age_rating,
            'duration' => $duration,
            'rating' => $rating,
            'poster_url' => $poster_url,
            'trailer_url' => $trailer_url
        ]);
        return $id;
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $movie = $this->db->fetch($sql, [":id" => $id]);
        return $movie;
    }

    public function getByGenre($genre)
    {
        $sql = "SELECT * FROM $this->table WHERE genre = :genre";
        $movies = $this->db->fetchAll($sql, [":genre" => $genre]);
        return $movies;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";
        $movies = $this->db->fetchAll($sql);
        return $movies;
    }

    public function update($id, $title, $release_year, $genre, $description, $director, 
                            $age_rating, $duration, $rating, $poster_url, $trailer_url) 
    {
        $this->db->update($this->table, [
            'title' => $title, 
            'release_year' => $release_year,
            'genre' => $genre,
            'description' => $description,
            'director' => $director,
            'age_rating' => $age_rating,
            'duration' => $duration,
            'rating' => $rating,
            'poster_url' => $poster_url,
            'trailer_url' => $trailer_url
        ], ['id' => $id]);
    }

    public function delete($id)
    {
        $this->db->delete($this->table, ['id' => $id]);
    }

}
