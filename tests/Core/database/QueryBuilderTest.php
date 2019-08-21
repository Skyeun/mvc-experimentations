<?php


namespace Tests\Core\Database;


use Core\Database\QueryBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    public function testSimpleQuery()
    {
        $query = (new QueryBuilder(true))
            ->select('name')
            ->from('posts')
            ->getQuery();

        $this->assertEquals('SELECT name FROM posts', $query);
    }

	public function testWithAlias()
	{
		$query = (new QueryBuilder(true))
			->select('name')
			->from('posts', 'p')
			->getQuery();

		$this->assertEquals('SELECT name FROM posts as p', $query);
    }

    public function testSelectWithDistinct()
    {
        $query = (new QueryBuilder(true))
            ->select('name')
            ->distinct(true)
            ->from('posts')
            ->getQuery();

        $this->assertEquals('SELECT DISTINCT name FROM posts', $query);
    }

    public function testSelectAllQuery()
    {
        $query = (new QueryBuilder(true))
            ->from('posts')
            ->getQuery();

        $this->assertEquals('SELECT * FROM posts', $query);
    }

    public function testSelectWithWhere()
    {
        $query = (new QueryBuilder(true))
            ->from('posts')
            ->where('name = "John"')
            ->getQuery();

        $this->assertEquals('SELECT * FROM posts WHERE (name = "John")', $query);
    }

    public function testSelectWithAndWhere()
    {
        $query = (new QueryBuilder(true))
            ->from('posts')
            ->where('name = "John"', 'age > 41')
            ->getQuery();

        $this->assertEquals('SELECT * FROM posts WHERE (name = "John") AND (age > 41)', $query);
    }

    public function testSelectWithOrWhere()
    {
        $query = (new QueryBuilder(true))->from('posts')
            ->where('name = "John" OR age > 41')
            ->getQuery();

        $this->assertEquals('SELECT * FROM posts WHERE (name = "John" OR age > 41)', $query);
    }

	public function testSelectWithComplexWhere()
	{
		$query = (new QueryBuilder(true))->from('posts')
			->where('name = "John" OR age > 41')
			->where('city = "New-York"')
			->getQuery();

		$query2 = (new QueryBuilder(true))->from('posts')
			->where('name = "John" OR age > 41', 'city = "New-York"')
			->getQuery();

		$this->assertEquals('SELECT * FROM posts WHERE (name = "John" OR age > 41) AND (city = "New-York")', $query);
		$this->assertEquals($query, $query2);
    }

    public function testSelectWithHaving()
    {
		$query = (new QueryBuilder(true))
			->select('client')
			->select('SUM(price)')
			->from('invoice')
			->having('SUM(price) > 40')
			->groupBy('client')
			->getQuery();

		$this->assertEquals('SELECT client, SUM(price) FROM invoice GROUP BY (client) HAVING (SUM(price) > 40)', $query);
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