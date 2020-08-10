<?php

class DB {
    protected $pdo = null;

    public function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $opt);

    }


    public function getRow($sql, $args) {
        $stmt = $this->pdo->prepare($sql);
        if($stmt->execute($args))
            return $stmt->fetch();
        return false;
    }


    public function getAllRows($sql, $args) {
        $stmt = $this->pdo->prepare($sql);
        if($stmt->execute($args))
            return $stmt->fetchAll();
        return false;
        
    }


    public function query($sql, $args) {
        $stmt = $this->pdo->prepare($sql);
        if($stmt->execute($args))
            return $this->pdo->lastInsertId();
        return false;
    }
}


