<?php

namespace iutnc\hellokant\model;

class Article extends Model
{
    protected static string $table = 'article';
    protected static string $idColumn = 'id';

    public function categorie(): Model
    {
        return $this->belongs_to('Categorie', 'id_categ');
    }

}