<?php 
namespace ckan\Test;

use ckan\ckan\client;


class ckanTest extends \PHPUnit_Framework_TestCase
{

	function testClient(){
    	$sut = new Client('localhost');
    	$this->assertInstanceOf("ckan\ckan\Client", $sut);
    }

}