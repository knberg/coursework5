<?php


class SeatModel extends Model 
{
    public function __construct() 
    {
        $this->db = new Database();
        $this->table = "seats";
    }

    public function create($hallNumber, $rowNumber, $colNumber) 
    {
        $id = $this->db->insert($this->table, [
            'hall_number' => $hall, 
            'row_numb' => $rowNumber,
            'col_numb' => $colNumber,
        ]);
        return $id;
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $seat = $this->db->fetch($sql, [":id" => $id]);
        return $seat;
    }

    public function getByHall($hallNumber)
    {
        $sql = "SELECT * FROM $this->table WHERE hall_number = :hall_number";
        $seats = $this->db->fetchAll($sql, [":hall_number" => $hallNumber]);
        return $seats;
    }

    public function getByHallAndSesion($hallNumber, $sessionNumber)
    {
        $sql = "SELECT * FROM $this->table WHERE hall_number = :hall_number";
        $seats = $this->db->fetchAll($sql, [":hall_number" => $hallNumber]);
        return $seats;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";
        $seats = $this->db->fetchAll($sql);
        return $seats;
    }
}
