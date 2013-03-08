<?php 
namespace ckan\Test;

use ckan\ckan\Ckan;
use Guzzle\Http\Client as httpClient;

class ckanTest extends \Guzzle\Tests\GuzzleTestCase
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
    	$httpClient = new httpClient("http://localhost");
    	$this->setMockResponse($httpClient, "rest/dataset");
    	$sut = new Ckan($httpClient);
    	$sut->dataset->lists();
    }
}