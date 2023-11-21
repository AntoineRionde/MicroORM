<?php

use iutnc\hellokant\model\Article;

$a = new Article();
$a->nom = 'test';
$a->prix = 10;
$a->descr = 'un article de qualité';
$a->insert();
print $a->id;

$liste = Article::all();
foreach($liste as $a) {
    print $a->nom . "\n";
}