<?php
namespace iutnc\hellokant\tests;
use iutnc\hellokant\factory\ConnectionFactory;
use iutnc\hellokant\query\Query;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TestQuery extends TestCase
{
    public function testAfficherSelect(){
        // une seule fois au lancement de l'application
        $conf = parse_ini_file('src/conf/db.conf.ini') ;
        ConnectionFactory::makeConnection($conf);

        $q = Query::table('commande');
        $q->select(['id', 'numero', 'date', 'client_id']);
        $q->get();
    }

}