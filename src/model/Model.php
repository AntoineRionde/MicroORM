<?php
namespace iutnc\hellokant\model;
use InvalidArgumentException;
use iutnc\hellokant\query\Query;

abstract class Model
{
    protected static string $table;
    protected static string $idColumn;
    protected array $atts = [];

    public function __construct(array $t = null) {
        if (!is_null($t)) $this->atts = $t;
    }

    public function __get(string $name) : mixed {
        if (array_key_exists($name, $this->atts)) {
            return $this->atts[$name];
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


    /**
     * @throws \Exception
     */
    public function delete() {
        if (isset($this->atts[static::$idColumn]))
        {
            return Query::table(static::$table)
                ->where( static::$idColumn, '=',
                    $this->atts[static::$idColumn] )
                ->delete();
        } else {
            throw new \Exception("La clé primaire n'est pas définie");
        }
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

    public static function find($idOrCriteria = null, array $selectColumns = null): array {
        $query = Query::table(static::$table);

        if ($selectColumns !== null) {
            $query->select($selectColumns);
        }

        if (is_int($idOrCriteria)) {
            $query->where(static::$idColumn, '=', $idOrCriteria);
        } elseif (is_array($idOrCriteria)) {
            if (isset($idOrCriteria[0]) && is_array($idOrCriteria[0]) && count($idOrCriteria[0]) === 3) {
                // Si le premier élément est un tableau de critères multiples
                foreach ($idOrCriteria as $criterion) {
                    [$column, $operator, $value] = $criterion;

                    if (!in_array($operator, ['=', '<', '>', '<=', '>=', 'like'])) {
                        throw new InvalidArgumentException("Invalid operator provided");
                    }

                    $query->where($column, $operator, $value);
                }
            } else {
                // Si le tableau ne contient qu'un seul critère
                [$column, $operator, $value] = $idOrCriteria;

                if (!in_array($operator, ['=', '<', '>', '<=', '>=', 'like'])) {
                    throw new InvalidArgumentException("Invalid operator provided");
                }

                $query->where($column, $operator, $value);
            }
        } elseif ($idOrCriteria !== null) {
            throw new InvalidArgumentException("Invalid criteria provided");
        }

        $items = $query->get();
        $results = [];

        foreach ($items as $item) {
            $results[] = new static($item);
        }

        return $results;
    }

    public static function first($idOrCriteria = null, array $selectColumns = null) {
        $results = self::find($idOrCriteria, $selectColumns);

        if (!empty($results)) {
            return $results[0];
        }

        return null;
    }



}