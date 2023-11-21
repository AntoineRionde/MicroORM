<?php

use iutnc\hellokant\factory\ConnectionFactory;
use iutnc\hellokant\model\Article;
require __DIR__ . '/../vendor/autoload.php';

$conf = parse_ini_file('../src/conf/db.conf.ini') ;
ConnectionFactory::makeConnection($conf);

$a = new Article();
$a->id_categ = 1;
$a->nom = 'test';
$a->tarif = 10;
$a->descr = 'un article de qualité';
$a->insert();
print $a->id;

$liste = Article::all();
foreach($liste as $a) {
    print $a->nom . "\n";
}