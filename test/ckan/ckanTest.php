<?php 
namespace ckan\Test;

use ckan\ckan\Ckan;

class ckanTest extends \PHPUnit_Framework_TestCase
{

	function testClient(){
		$httpClient = $this->getMock('Guzzle\Http\Client');
    	$sut = new Ckan($httpClient);
    	$this->assertInstanceOf("ckan\ckan\Ckan", $sut);
    }

    function testThatCkanReturnsDataset(){
    	$httpClient = $this->getMock('Guzzle\Http\Client');
    	$sut = new Ckan($httpClient);
    	$this->assertInstanceOf("ckan\ckan\Dataset", $sut->dataset);
    }

    function testThatCkanDatasetHasCorrectRegisterUri(){
    	$httpClient = $this->getMock('Guzzle\Http\Client', array('get'));
    	$httpClient->expects($this->once())
                 ->method('get')
                 ->with($this->equalTo('http://localhost/api/2/dataset'));
     	$sut = new Ckan($httpClient);
    	$sut->dataset->lists();
    }
}