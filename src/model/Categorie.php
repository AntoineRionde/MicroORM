<?php

namespace iutnc\hellokant\model;

class Categorie extends Model
{
    protected static string $table = 'categorie';
    protected static string $idColumn = 'id';

    public function articles() : array
    {
        return $this->has_many('Article', 'id_categ');
    }

}