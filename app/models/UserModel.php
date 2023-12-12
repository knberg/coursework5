<?php


class UserModel extends Model 
{
    public function __construct() 
    {
        $this->db = new Database();
        $this->table = "users";
    }

    public function create($name, $email, $password) 
    {
        $userId = $this->db->insert($this->table, [
            'name' => $name, 
            'email' => $email, 
            'password' => $password
        ]);
        return $userId;
    }

    public function updateProfile($id, $name, $email) 
    {
        $sql = "UPDATE $this->table SET name=:name, email=:email WHERE id=:id";
        $this->db->query($sql, [':name' => $name, ':email' => $email, ':id' => $id]);
    }

    public function updatePassword($id, $newPassword) 
    {
        $sql = "UPDATE $this->table SET password=:password WHERE id=:id";
        $this->db->query($sql, [':password' => $newPassword, ':id' => $id]);
    }

    public function getByEmail($email)
    {
        $sql = "SELECT u.*, r.name AS role
                FROM $this->table AS u 
                JOIN roles AS r ON u.role = r.id 
                WHERE u.email = :email";

        $user = $this->db->fetch($sql, [":email" => $email]);
        return $user;
    }

    public function getById($id)
    {
        $sql = "SELECT u.*, r.name AS role
                FROM $this->table AS u 
                JOIN roles AS r ON u.role = r.id 
                WHERE u.id = :id";

        $user = $this->db->fetch($sql, [":id" => $id]);
        return $user;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM $this->table AS u 
                INNER JOIN roles AS r ON u.role = r.id";
                
        $users = $this->db->fetchAll($sql);
        return $users;
    }

    public function isExists($email)
    {
        return $this->getByEmail($email) != null;
    }
}
