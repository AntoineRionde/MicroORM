<?php

require __DIR__ . '/../vendor/autoload.php';

use iutnc\hellokant\factory\ConnectionFactory;
use iutnc\hellokant\query\Query;

$conf = parse_ini_file('../src/conf/db.conf.ini') ;
ConnectionFactory::makeConnection($conf);

$q = Query::table('article');
$q->select(['id', 'nom', 'descr', 'tarif']);
var_dump($q->get());

$q = Query::table('article');
$q->select(['id', 'nom', 'descr', 'tarif']);
$q->where('id', '=', 65);
$res = $q->get();


$q = Query::table('article');
$q->select(['id', 'nom', 'descr', 'tarif']);
$q->where('id', '=', 65);
$q->where('nom', 'LIKE', '%clo%');
var_dump($q->get() ? $res[0]['id'] : false);
