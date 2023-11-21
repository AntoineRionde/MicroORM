<?php

require __DIR__ . '/../vendor/autoload.php';
use iutnc\hellokant\query\Query;

$q = Query::table('commande');
$q->select(['id', 'numero', 'date', 'client_id']);
$q->where('numero', '=', 1000);
$q->get();