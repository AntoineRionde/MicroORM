<?php
namespace iutnc\hellokant\query;

use PDO;

class Query
{
    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';

    public static function table( string $table) : Query {
        $query = new Query;
        $query->sqltable= $table;
        return $query;
    }

    public function get(): Array {
        $this->sql = "SELECT $this->fields FROM $this->sqltable";
        if ($this->where) {
            $this->sql .= " WHERE $this->where";
        }
        echo $this->sql;
        $pdo = new PDO('sqlite:'.__DIR__.'/../db.sqlite');
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select( array $fields) : Query {
        $this->fields = implode( ',', $fields);
        return $this;
    }

    public function delete(string $ligne) {
        $this->sql = "DELETE FROM $this->sqltable WHERE $ligne";
        echo $this->sql;
    }

    public function insert(array $fields) {
        $this->sql = "INSERT INTO $this->sqltable VALUES (";
        foreach ($fields as $key => $value) {
            $this->sql .= "'$value',";
        }
        $this->sql = substr($this->sql, 0, -1);
        $this->sql .= ")";
        echo $this->sql;
    }


    public function where(string $col, string $op, mixed $val) : Query {
        $this->where = "$col $op ?";
        $this->args[] = $val;
        return $this;
    }






}