<?php


class SessionModel extends Model 
{

    private $sql = "SELECT 
                s.id AS session_id, 
                s.date, 
                s.time,
                s.price,
                m.id AS movie_id,
                m.title, 
                m.genre, 
                h.number AS hall_number,
                h.type
            FROM sessions AS s
            INNER JOIN movies AS m ON s.movie_id = m.id
            INNER JOIN halls AS h ON s.hall_number = h.number";

    public function __construct() 
    {
        $this->db = new Database();
        $this->table = "sessions";
    }

    public function create($movieId, $hallNumber, $date, $time, $price) 
    {
        $id = $this->db->insert($this->table, [
            'movieId' => $movieId, 
            'hall_number' => $hallNumber,
            'date' => $date,
            'time' => $time,
            'price' => $price,
        ]);
        return $id;
    }

    public function getById($id)
    {
        $sql = $this->sql . " WHERE s.id = :id";
        $row = $this->db->fetch($sql, [":id" => $id]);
        $session = $this->fromRow($row);
        return $session;
    }

    public function getAll()
    {
        $sql = $this->sql;
        $rows = $this->db->fetchAll($sql);
        $sessions = [];
        foreach ($rows as $row) {
            $sessions[] = $this->fromRow($row);;
        }
        return $sessions;
    }

    public function getByMovie($movieId)
    {
        $sql = $this->sql . " WHERE movie_id = :movie_id";
        $rows = $this->db->fetchAll($sql, [":movie_id" => $movieId]);
        $sessions = [];
        foreach ($rows as $row) {
            $sessions[] = $this->fromRow($row);;
        }
        return $sessions;
    }

    public function getByDate($date)
    {
        $sql = $this->sql . " WHERE date = :date";
        $rows = $this->db->fetchAll($sql, [":date" => $date]);
        $sessions = [];
        foreach ($rows as $row) {
            $sessions[] = $this->fromRow($row);;
        }
        return $sessions;
    }

    public function getByMovieAndDateGroupByHall($movieId, $date)
    {
        $sql = "SELECT 
                s.id AS session_id, 
                s.movie_id, 
                s.time,
                s.date,
                s.price, 
                s.hall_number,
                h.type
            FROM sessions AS s
            INNER JOIN halls AS h ON s.hall_number = h.number
            WHERE movie_id = :movie_id AND date = :date
            ORDER BY hall_number, time";

        $rows = $this->db->fetchAll($sql, [":movie_id" => $movieId, ":date" => $date]);

        $groupedSessions = array();

        foreach ($rows as $row) {
            $session = array(
                'id' => $row['session_id'],
                'time' => substr($row['time'], 0, 5),
                'price' => $row['price'],
            );

            $groupedSessions[$row['hall_number']]['type'] = $row['type'];
            $groupedSessions[$row['hall_number']]['sessions'][] = $session;
        }
        return $groupedSessions;
    }

    public function fromRow($row) {
        return array(
            'id' => $row['session_id'],
            'date' => $row['date'],
            'time' =>substr($row['time'], 0, 5),
            'price' => $row['price'],
            'movie' => array(
                'id' => $row['movie_id'],
                'title' => $row['title'],
                'genre' => $row['genre'],
            ),
            'hall' => array(
                'number' => $row['hall_number'],
                'type' => $row['type'],
            )
        );
    }
}
