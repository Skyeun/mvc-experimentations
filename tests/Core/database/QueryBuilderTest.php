<?php


namespace Tests\Core\Database;


use Core\Database\QueryBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    public function testSelectQuery()
    {
        $query = (new QueryBuilder())
            ->select('name')
            ->from('posts')
            ->getQuery();

        $this->assertEquals('SELECT name FROM posts', $query);
    }

    public function testSelectDistinctQuery()
    {
        $query = (new QueryBuilder())
            ->select('name')
            ->distinct(true)
            ->from('posts')
            ->getQuery();

        $this->assertEquals('SELECT DISTINCT name FROM posts', $query);
    }

    public function testSelectAllQuery()
    {
        $query = (new QueryBuilder())
            ->from('posts')
            ->getQuery();

        $this->assertEquals('SELECT * FROM posts', $query);
    }

    public function testSelectWhereQuery()
    {
        $query = (new QueryBuilder())
            ->from('posts')
            ->where('name = "John"')
            ->getQuery();

        $this->assertEquals('SELECT * FROM posts WHERE name = "John"', $query);
    }

    public function testSelectAndWhereQuery()
    {
        $query = (new QueryBuilder())
            ->from('posts')
            ->where('name = "John"')
            ->andWhere('age > 41')->getQuery();

        $this->assertEquals('SELECT * FROM posts WHERE name = "John" AND age > 41', $query);
    }

    public function testSelectOrWhereQuery()
    {
        $query = (new QueryBuilder())->from('posts')
            ->where('name = "John"')
            ->orWhere('age > 41')
            ->getQuery();

        $this->assertEquals('SELECT * FROM posts WHERE name = "John" OR age > 41', $query);
    }

    public function testSelectHavingQuery()
    {
        $this->markTestSkipped('TODO: Implement this test!');
    }

    public function testSelectAndHaving()
    {
        $this->markTestSkipped('TODO: Implement this test!');
    }

    public function testSelectOrHaving()
    {
        $this->markTestSkipped('TODO: Implement this test!');
    }

    public function testGroupByQuery()
    {
        $this->markTestSkipped('TODO: Implement this test!');
    }

    public function testOrderByQuery()
    {
        $this->markTestSkipped('TODO: Implement this test!');
    }

    public function testLimitQuery()
    {
        $this->markTestSkipped('TODO: Implement this test!');
    }

    public function testLeftJoinQuery()
    {
        $this->markTestSkipped('TODO: Implement this test!');
    }

    public function testRightJoinQuery()
    {
        $this->markTestSkipped('TODO: Implement this test!');
    }

    public function testInnerJoinQuery()
    {
        $this->markTestSkipped('TODO: Implement this test!');
    }

    public function testJoinQuery()
    {
        $this->markTestSkipped('TODO: Implement this test!');
    }
}