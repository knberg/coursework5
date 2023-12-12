<?php


class HallModel extends Model 
{
    public function __construct() 
    {
        $this->db = new Database();
        $this->table = "halls";
    }

    public function create($number, $type) 
    {
        $id = $this->db->insert($this->table, [
            'number' => $number, 
            'type' => $type
        ]);
        return $id;
    }

    public function getById($number)
    {
        $sql = "SELECT * FROM $this->table WHERE number = :number";
        $hall = $this->db->fetch($sql, [":number" => $number]);
        return $hall;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";
        $halls = $this->db->fetchAll($sql);
        return $halls;
    }

    public function getHallSchema($number) {
        $sql = "SELECT * FROM seats WHERE hall_number = :hall_number";
        $seats = $this->db->fetchAll($sql, [":hall_number" => $number]);
        $seatsArray = [];
        foreach ($seats as $seat) {
            $rowNumber = $seat['row_numb'];
            $colNumber = $seat['col_numb'];
            $seatInfo = array(
                'row' => $rowNumber,
                'col' => $colNumber,
                'id' => $seat['id']
            );
            $seatsArray[$rowNumber][$colNumber] = $seatInfo;
        }
        return $seatsArray;
    }
}
