<?php


namespace Tests\Core\Database;


use Core\Database\Connector;
use PHPUnit\Framework\TestCase;

class ConnectorTest extends TestCase
{
	public function testGetInstance()
	{
		$instance = Connector::getInstance();

		$this->assertInstanceOf(Connector::class, $instance);
	}
}