<?php

use iutnc\hellokant\factory\ConnectionFactory;
use iutnc\hellokant\model\Article;
use iutnc\hellokant\model\Categorie;

require __DIR__ . '/../vendor/autoload.php';

$conf = parse_ini_file('../src/conf/db.conf.ini') ;
ConnectionFactory::makeConnection($conf);

//$a = new Article();
//$a->id_categ = 1;
//$a->nom = 'test';
//$a->tarif = 10;
//$a->descr = 'un article de qualité';
//$a->insert();
////print $a->id;
//
//$liste = Article::all();
//foreach($liste as $a) {
//    print "nom : ". $a->nom . "\n";
//    print "descr : " . $a->descr . "\n";
//    print "tarif : ". $a->tarif . "\n";
//}
//try {
//    print "nb ligne(s) suppr : ". $a->delete() . "\n";
//} catch (Exception $e) {
//    print $e->getMessage();
//}

//$articles = Article::find(64);
//$ar = $articles[0];
//print "nom : ". $ar->nom . "\n";
//print "descr : " . $ar->descr . "\n";
//print "tarif : ". $ar->tarif . "\n";

$ar = Article::first(['nom', 'like', '%velo%'])->categorie();
//print "nom : ". $ar->nom . "\n";
//print "descr : " . $ar->descr . "\n";
//print "tarif : ". $ar->tarif . "\n";
//print "nom categ : ". $ar->nom . "\n";


$c = Categorie::first(1);
//print "nom : ". $c->nom . "\n";
$list_articles = $c->articles;
foreach ($list_articles as $a) {
    print "nom : ". $a->nom . "\n";
    print "descr : " . $a->descr . "\n";
    print "tarif : ". $a->tarif . "\n";
}

$a = Article::first(64);
$c = $a->categorie;
print "nom : ". $c->nom . "\n";
