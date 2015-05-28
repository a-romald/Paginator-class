<?php

require_once 'paginator.php';

class PaginatorTest extends \PHPUnit_Framework_TestCase
{
	private $paginator;

	public function setUp()
	{
		$this->paginator = new Paginator('10', 'page');
	}

	public function testInstance()
	{
		$this->assertInstanceOf('Paginator', $this->paginator);
	}
}