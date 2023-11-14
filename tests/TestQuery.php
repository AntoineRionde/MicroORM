<?php
namespace iutnc\hellokant\tests;
use iutnc\hellokant\query\Query;
use PHPUnit\Framework\Attributes\DataProvider;

class TestQuery extends \PHPUnit\Framework\TestCase
{
    public function testAccederCommande(){
        $q = Query::table('commande');
        $q->select(['id', 'numero', 'date', 'client_id']);
        $res = $q->get();
        echo $res;
    }

}