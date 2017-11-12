<?php 
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
	public function setUp()
	{
		
	}

	/**
     * @test
     */
	public function sum()
	{
		$a = 1;
		$b = 2;

		$this->assertEquals(2, ($a+$b));
	}

	
}

 