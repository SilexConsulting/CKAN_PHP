<?php 
namespace ckan\Test;

use ckan\ckan\Ckan;
use Guzzle\Http\Client;

class ckanTest extends \PHPUnit_Framework_TestCase
{

	function testClient(){
		$httpClient = $this->getMock('Client', array('get'));
    	$sut = new Ckan($httpClient);
    	$this->assertInstanceOf("ckan\ckan\Ckan", $sut);
    }

    function testThatCkanReturnsDataset(){
    	$httpClient = $this->getMock('Client', array('get'));
    	$sut = new Ckan($httpClient);
    	$this->assertInstanceOf("ckan\ckan\Dataset", $sut->dataset);
    }

    function testThatCkanDatasetHasCorrectRegisterUri(){
    	$httpClient = $this->getMock('Client', array('get'));
    	$httpClient->expects($this->once())
                 ->method('get')
                 ->with($this->equalTo('api/2/rest/dataset'));
     	$sut = new Ckan($httpClient);
    	$sut->dataset->lists();
    }
}