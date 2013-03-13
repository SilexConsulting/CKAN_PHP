<?php 
namespace ckan\Test;

use ckan\ckan\CkanClient;

class ckanTest extends \Guzzle\Tests\GuzzleTestCase
{

	function testClient(){
        $sut = $this->getServiceBuilder()->get('test.ckan');
    	$this->assertInstanceOf("ckan\ckan\CkanClient", $sut);
    }

    function testThatDatasetRegistryReturnsCorrectData(){
        $sut = $this->getServiceBuilder()->get('test.ckan');
        $this->setMockResponse($sut, array(
                "dataset_registry_success",
            )
        );
        $model = $sut->GetDatasets();
        $datasets = $model->toArray();
        $this->assertEquals(2, count($datasets));
        $this->assertEquals("00055483-dd79-4ada-b4be-eb54eeaec19b", $datasets[0]);
        $this->assertEquals("0046a95c-56b0-4bb9-9451-9071fbdcec15", $datasets[1]);
    }
    

}