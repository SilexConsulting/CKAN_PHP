<?php 
namespace ckan\Test;

use ckan\ckan\Ckan;
use Guzzle\Http\Client;

class bullshit {
	public function get(){
		print_r("Im the real get");
	}
}

class ckanTest extends \PHPUnit_Framework_TestCase
{

	function testClient(){
		$httpClient = $this->getMock('Client', array('get'));
    	$sut = new Ckan($httpClient);
    	$this->assertInstanceOf("ckan\ckan\Ckan", $sut);
    }

    function testThatCkanReturnsDataset(){
    	$httpClient = $this->getMock('Client', array('get'));
    	//$sut = new Ckan($httpClient);
    	//$this->assertInstanceOf("ckan\ckan\Dataset", $sut->dataset);
    }

    function testThatCkanDatasetHasCorrectRegisterUri(){
    	$httpClient = $this->getMock('bullshit', array('get'));
    	$httpClient->expects($this->once())
                 ->method('get')
                 ->with($this->equalTo('http://localhost/api/2/dataset'));
     	$sut = new Ckan($httpClient);
    	$sut->dataset->lists();
    }
}