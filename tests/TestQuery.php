<?php
namespace iutnc\hellokant\tests;
use iutnc\hellokant\factory\ConnectionFactory;
use iutnc\hellokant\model\Article;
use iutnc\hellokant\query\Query;
use PHPUnit\Framework\TestCase;

class TestQuery extends TestCase
{

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

    public function testInsert()
    {
        $q = Query::table('article');
        $art = new Article();
        $art->nom = 'test';
        $art->descr = 'test';
        $art->tarif = 10;
        $art->id_categ = 1;

        $art->insert();
        $res = $q->where('nom', '=', 'test')->one();
        $this->assertEquals('test', $res['nom']);
    }

    /**
     * @throws \Exception
     */
    public function testDelete()
    {
        $art = new Article();
        $art->nom = 'test';
        $art->descr = 'test';
        $art->tarif = 10;
        $art->id_categ = 1;
        $art->insert();
        $art->delete();

        $q = Query::table('article');
        $res = $q->where('nom', '=', 'test')->one();
        $this->assertNull($res);

    }


    public function testFind()
    {
        $id = 65;
        $article = Article::find($id);
        $this->assertNotNull($article);
        $this->assertEquals($id, $article['id']);
    }

    public function testBelongsTo()
    {
        $id = 65;
        $categoryQuery = Query::table('categorie');
        $category = $categoryQuery->where('id', '=', Article::find($id)['id_categ'])->one();
        $this->assertNotNull($category);

        $this->assertEquals('sport', $category['nom']);
        $this->assertEquals('articles de sport', $category['descr']);
    }

    public function testHasMany()
    {
        $id = 1;
        $articleQuery = Query::table('article');
        $articles = $articleQuery->where('id_categ', '=', $id)->get();
        $this->assertCount(3, $articles);
    }

}