<?php
namespace iutnc\hellokant\tests;
use iutnc\hellokant\factory\ConnectionFactory;
use iutnc\hellokant\query\Query;
use PHPUnit\Framework\TestCase;

class TestQuery extends TestCase
{

    //setup connection before each test

    public function setUp(): void
    {
        $conf = parse_ini_file('../src/conf/db.conf.ini') ;
        ConnectionFactory::makeConnection($conf);
    }
    public function selectAll(){
        $q = Query::table('article');
        $q->select(['id', 'nom', 'descr', 'tarif']);

        $this->assertCount(3, $q->get());
    }

    public function singleWhere(){
        $q = Query::table('article');
        $q->select(['id', 'nom', 'descr', 'tarif']);
        $q->where('id', '=', 65);
        $res = $q->get();
        $this->assertCount(1, $res);
        $this->assertEquals(65, $res[0]['id']);
    }

    public function multipleWhere(){
        $q = Query::table('article');
        $q->select(['id', 'nom', 'descr', 'tarif']);
        $q->where('id', '=', 65);
        $q->where('nom', 'LIKE', '%clo%');
        $res = $q->get();
        $this->assertCount(1, $res);
        $this->assertEquals(65, $res[0]['id']);
    }

    public function selectOne(){
        $q = Query::table('article');
        $q->select(['id', 'nom', 'descr', 'tarif']);
        $q->where('id', '=', 65);
        $res = $q->one();
        $this->assertEquals(65, $res['id']);
    }

    public function selectOneWithMultipleWhere(){
        $q = Query::table('article');
        $q->select(['id', 'nom', 'descr', 'tarif']);
        $q->where('id', '=', 65);
        $q->where('nom', 'LIKE', '%clo%');
        $res = $q->one();
        $this->assertEquals(65, $res['id']);
    }
}