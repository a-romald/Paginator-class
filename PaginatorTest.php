<?php

require_once 'paginator.php';

class PaginatorTest extends \PHPUnit_Framework_TestCase
{
	
	public function testInstance()
	{
		//$this->assertInstanceOf('Paginator', $this->paginator);
		$paginator = $this->getMockBuilder('Paginator')
			->disableOriginalConstructor()
            ->setMethods(array('set_total'))
            ->getMock();

        $paginator->expects($this->any())
            ->method('set_total')
            ->with(100);
            //->will($this->returnValue(''));        
        
        $start = $paginator->set_start();
        $expect=0;
        $this->assertEquals($expect, $start);
	}
}