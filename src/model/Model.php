<?php
namespace iutnc\hellokant\model;
use iutnc\hellokant\query\Query;

abstract class Model
{
    protected static $table;
    protected static $idColumn = 'id';
    protected array $atts = [];

    public function __construct(array $t = null) {
        if (!is_null($t)) $this->_atts = $t;
    }

    public function __get(string $name) : mixed {
        if (array_key_exists($name, $this->_atts)) {
            return $this->_atts[$name];
        }
        else if (method_exists(static::class, $name)) {
        return $this->$name();
        } else {
            return null;
        }
    }

    public function __set(string $name, mixed $val) : void {
     $this->atts[$name] = $val;
    }

    public function delete() {
        if (isset($this->atts[static::$idColumn]))
        {
            $ligne = static::$idColumn . ' = ' . $this->atts[static::$idColumn];
            return Query::table(static::$table)
                ->where( static::$idColumn, '=',
                    $this->atts[static::$idColumn] )
                ->delete($ligne);
        }
        return null;
    }

    public static function first(int $id): Model {
        $row=Query::table(static::$table)
            ->where(static::$idColumn, '=', $id)
            ->one();
        return new static($row);
    }

    public function insert()  {
        $this->atts[static::$idColumn] = Query::table(static::$table)
            ->insert($this->atts);
        return $this->atts[static::$idColumn];
    }

    public static function all() : array {
        $all = Query::table(static::$table)->get();
        $return=[];
        foreach( $all as $m) {
            $return[] = new static($m);
        }
        return $return;
    }
}