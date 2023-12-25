<?php
namespace iutnc\hellokant\query;

use iutnc\hellokant\factory\ConnectionFactory;
use PDO;

class Query
{
    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';

    public static function table(string $table) : Query {
        $query = new Query;
        $query->sqltable= $table;
        return $query;
    }

    public function where(string $col, string $op, mixed $val) : Query {
        if (!is_null($this->where)) {
            $this->where .= ' AND ';
        }
        $this->where .= ' ' . $col . ' ' . $op . ' ? ';
        $this->args[] = $val;
        return $this;
    }

    public function get() : array|bool
    {
        $this->sql = "SELECT $this->fields FROM $this->sqltable";
        if ($this->where !== null) {
            $this->sql .= " WHERE $this->where";
        }

        $pdo = ConnectionFactory::getConnection();
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function select(array $fields) : Query {
        $this->fields = implode( ',', $fields);
        return $this;
    }

    public function one() {
        $this->sql = "SELECT $this->fields FROM $this->sqltable";
        if ($this->where !== null) {
            $this->sql .= " WHERE $this->where";
        }
        $this->sql .= " LIMIT 1";
        $pdo = ConnectionFactory::getConnection();
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete() {
        if (!is_null($this->where)) {
            $this->sql = "DELETE FROM " . $this->sqltable . " WHERE " . $this->where;
        }
        $pdo = ConnectionFactory::getConnection();
        $request = $pdo->prepare($this->sql);
        $request->execute($this->args);
        return $request->rowCount();
    }

    public function insert(array $fields) {

        $tabsize = count($fields);
        $compteur = 0;
        $this->sql = "INSERT INTO " . $this->sqltable . " (";
        foreach ($fields as $k => $v) {
            $this->sql .= "$k";
            $compteur++;
            if (!($compteur == $tabsize)) {
                $this->sql .= ',';
            }
        }
        $this->sql .= ') VALUES (';
        $compteur = 0;
        foreach ($fields as $v) {
            $this->args[] = $v;
            $this->sql .= "?";
            $compteur++;
            if (!($compteur == $tabsize)) {
                $this->sql .= ',';
            }
        }
        $this->sql .= ')';

        $pdo = ConnectionFactory::getConnection();
        $request = $pdo->prepare($this->sql);
        $request->execute($this->args);

        return $pdo->lastInsertId($this->sqltable);
    }

}