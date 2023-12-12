<?php


class TicketModel extends Model 
{
    public function __construct() 
    {
        $this->db = new Database();
        $this->table = "tickets";
    }

    public function create($userId, $sessionId, $seatId, $total) 
    {
        $id = $this->db->insert($this->table, [
            'user_id' => $userId, 
            'session_id' => $sessionId,
            'seat_id' => $seatId,
            'total' => $total,
        ]);
        return $id;
    }

    public function getById($id)
    {
        $sql = "SELECT 
                    t.id,
                    t.total,
                    t.active,
                    t.date AS buy_date,
                    s.date AS session_date,
                    s.time AS session_time,
                    s.hall_number,
                    st.row_numb,
                    st.col_numb,
                    m.title
                FROM tickets AS t
                INNER JOIN sessions AS s ON t.session_id = s.id
                INNER JOIN movies AS m ON s.movie_id = m.id
                INNER JOIN seats AS st ON t.seat_id = st.id
                WHERE t.id = :id";

        $ticket = $this->db->fetch($sql, [":id" => $id]);
        return $ticket;
    }
    
    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";
        $tickets = $this->db->fetchAll($sql);
        return $tickets;
    }

    public function getByUser($userId)
    {
        $sql = "SELECT 
                    t.id,
                    t.total,
                    t.active,
                    t.date AS buy_date,
                    s.date AS session_date,
                    s.time AS session_time,
                    s.hall_number,
                    st.row_numb,
                    st.col_numb,
                    m.title
                FROM tickets AS t
                INNER JOIN sessions AS s ON t.session_id = s.id
                INNER JOIN movies AS m ON s.movie_id = m.id
                INNER JOIN seats AS st ON t.seat_id = st.id
                WHERE user_id = :user_id";

        $tickets = $this->db->fetchAll($sql, [":user_id" => $userId]);
        return $tickets;
    }

    public function check($sessionId, $seatId)
    {
        $sql = "SELECT * FROM $this->table WHERE session_id = :session_id AND seat_id = :seat_id";
        $ok = $this->db->fetch($sql, [':session_id'=>$sessionId, ':seat_id'=>$seatId]);
        return $ok;
    }

    public function getBookedSeatsBySession($sessionId)
    {
        $sql = "SELECT seat_id FROM $this->table WHERE session_id = :session_id AND active = 1";
        $result = $this->db->fetchAll($sql, [":session_id" => $sessionId]);
        $bookedSeats = [];
        foreach ($result as $row) {
            $bookedSeats[] = $row['seat_id'];
        }
        return $bookedSeats;
    }
}
