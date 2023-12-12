<?php

/**
 * Класс конфигурации базы данных
 */
class Database 
{
    public $host = DB_HOST;
    public $dbname = DB_NAME;
    public $username = DB_USER;
    public $password = DB_PASS;
    public $charset = "utf8mb4";

    public $pdo;

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetch($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select($table, $columns = ['*'], $where = null) 
    {
        $columns = implode(', ', $columns);
        $sql = "SELECT $columns FROM $table";

        if ($where) {
            $whereClause = [];
            foreach ($where as $key => $value) {
                $whereClause[] = "$key=:$key";
            }
            $whereClause = implode(" AND ", $whereClause);
            $sql .= " WHERE $whereClause";
        }

        $result = $this->fetchAll($sql, $where);
        return $result;
    }

    public function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $this->query($sql, $data);
        return $this->pdo->lastInsertId();
    }

    public function update($table, $data, $where = null)
    {
        $set = [];
        foreach ($data as $key => $value) {
            if ($value != null)
                $set[] = "$key=:$key";
        }
        $setClause = implode(", ", $set);
        $sql = "UPDATE $table SET $setClause";

        if ($where) {
            $whereClause = [];
            foreach ($where as $key => $value) {
                $whereClause[] = "$key=:$key";
            }
            $whereClause = implode(" AND ", $whereClause);
            $sql .= " WHERE $whereClause";
            $data = array_merge($data, $where);
        }

        return $this->query($sql, $data)->rowCount();
    }

    public function delete($table, $where = null)
    {
        $sql = "DELETE FROM $table";

        if ($where) {
            $whereClause = [];
            foreach ($where as $key => $value) {
                $whereClause[] = "$key=:$key";
            }
            $whereClause = implode(" AND ", $whereClause);
            $sql .= " WHERE $whereClause";
        }

        return $this->query($sql, $where)->rowCount();
    }

    public function getLimitedRows($sql, $params = [], $limit = 10, $offset = 0)
    {
        $sql .= " LIMIT $limit OFFSET $offset";
        return $this->fetchAll($sql, $params);
    }

    public function countRows($table, $where = null)
    {
        $sql = "SELECT COUNT(*) FROM $table";

        if ($where) {
            $whereClause = [];
            foreach ($where as $key => $value) {
                $whereClause[] = "$key=:$key";
            }
            $whereClause = implode(" AND ", $whereClause);
            $sql .= " WHERE $whereClause";
        }

        return $this->query($sql, $where);
    }

    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }

    public function rollback()
    {
        return $this->pdo->rollBack();
    }
}



// <?php

// /**
//  * Класс конфигурации базы данных
//  */
// class Database 
// {
//     public $host = DB_HOST;
//     public $dbname = DB_NAME;
//     public $username = DB_USER;
//     public $password = DB_PASS;
//     public $charset = "utf8mb4";

//     public static $pdo;

//     public function __construct()
//     {
//         $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

//         try {
//             self::$pdo = new PDO($dsn, $this->username, $this->password);
//             self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         } catch (PDOException $e) {
//             die("Database connection failed: " . $e->getMessage());
//         }
//     }

//     public static function getConnection() {
//         if (self::$pdo == null) {
//             self::$pdo = new Database();
//         }
//         return self::$pdo->connection;
//     }
    
//     public function query($sql, $params = [])
//     {
//         $stmt = self::$pdo->prepare($sql);
//         $stmt->execute($params);
//         return $stmt;
//     }

//     public function fetch($sql, $params = [])
//     {
//         return $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
//     }

//     public function fetchAll($sql, $params = [])
//     {
//         return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
//     }

//     public function select($table, $columns = ['*'], $where = null) 
//     {
//         $columns = implode(', ', $columns);
//         $sql = "SELECT $columns FROM $table";

//         if ($where) {
//             $whereClause = [];
//             foreach ($where as $key => $value) {
//                 $whereClause[] = "$key=:$key";
//             }
//             $whereClause = implode(" AND ", $whereClause);
//             $sql .= " WHERE $whereClause";
//         }

//         $result = $this->fetchAll($sql, $where);
//         return $result;
//     }

//     public function insert($table, $data)
//     {
//         $columns = implode(", ", array_keys($data));
//         $values = ":" . implode(", :", array_keys($data));

//         $sql = "INSERT INTO $table ($columns) VALUES ($values)";
//         $this->query($sql, $data);
//         return self::$pdo->lastInsertId();
//     }

//     public function update($table, $data, $where = null)
//     {
//         $set = [];
//         foreach ($data as $key => $value) {
//             $set[] = "$key=:$key";
//         }
//         $setClause = implode(", ", $set);
//         $sql = "UPDATE $table SET $setClause";

//         if ($where) {
//             $whereClause = [];
//             foreach ($where as $key => $value) {
//                 $whereClause[] = "$key=:$key";
//             }
//             $whereClause = implode(" AND ", $whereClause);
//             $sql .= " WHERE $whereClause";
//             $data = array_merge($data, $where);
//         }

//         return $this->query($sql, $data)->rowCount();
//     }

//     public function delete($table, $where = null)
//     {
//         $sql = "DELETE FROM $table";

//         if ($where) {
//             $whereClause = [];
//             foreach ($where as $key => $value) {
//                 $whereClause[] = "$key=:$key";
//             }
//             $whereClause = implode(" AND ", $whereClause);
//             $sql .= " WHERE $whereClause";
//             $data = array_merge($data, $where);
//         }
//         $whereClause = implode(" AND ", $whereClause);

//         return $this->query($sql, $where)->rowCount();
//     }

//     public function getLimitedRows($sql, $params = [], $limit = 10, $offset = 0)
//     {
//         $sql .= " LIMIT $limit OFFSET $offset";
//         return $this->fetchAll($sql, $params);
//     }

//     public function countRows($table, $where = null)
//     {
//         $sql = "SELECT COUNT(*) FROM $table";

//         if ($where) {
//             $whereClause = [];
//             foreach ($where as $key => $value) {
//                 $whereClause[] = "$key=:$key";
//             }
//             $whereClause = implode(" AND ", $whereClause);
//             $sql .= " WHERE $whereClause";
//         }

//         return $this->query($sql, $where);
//     }

//     public function beginTransaction()
//     {
//         return self::$pdo->beginTransaction();
//     }

//     public function commit()
//     {
//         return self::$pdo->commit();
//     }

//     public function rollback()
//     {
//         return self::$pdo->rollBack();
//     }
// }