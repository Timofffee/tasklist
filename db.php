<?php

class DB {
    private $host = '127.0.0.1';
    private $db   = 'tasklist';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8';

    protected $pdo = null;

    function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $this->user, $this->pass, $opt);

    }

    function getRow($sql, $args) {
        $stmt = $this->pdo->prepare($sql);
        if($stmt->execute($args))
            return $stmt->fetch();
        return false;
    }

    function getAllRows($sql, $args) {
        $stmt = $this->pdo->prepare($sql);
        if($stmt->execute($args))
            return $stmt->fetchAll();
        return false;
        
    }

    function query($sql, $args) {
        $stmt = $this->pdo->prepare($sql);
        if($stmt->execute($args))
            return $this->pdo->lastInsertId();
        return false;
    }

    function getUser($val) {
        if (is_int($val)) { # id
            $sql = "SELECT * FROM users WHERE id = :val LIMIT 1";
            return $this->getRow($sql, [
                "val" => $val
            ]);
        } elseif (is_string($val)) { # login
            $sql = "SELECT * FROM users WHERE login = :val LIMIT 1";
            return $this->getRow(
                $sql, [
                    "val" => htmlspecialchars($val, ENT_QUOTES, 'UTF-8')
                ]);
        }
        return false;
    }
}
