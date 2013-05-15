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
    
    function testThatDatasetGetReturnsData(){
    	$sut = $this->getServiceBuilder()->get('test.ckan');
    	$this->setMockResponse($sut, array(
    			"dataset_get_success",
    		)
    	);
    	$model = $sut->GetDataset(array("id"=>"boo"));
    	$dataset = $model->toArray();
    	$this->assertEquals("UK Open Government Licence (OGL)", $dataset['license_title']);
    	$this->assertEquals("00055483-dd79-4ada-b4be-eb54eeaec19b", $dataset['id']);
    	$this->assertEquals(1, count($dataset['resources']));
    	$this->assertEquals("http://opendata.s3.amazonaws.com/public-weighbridges.xls", $dataset['resources'][0]['url']);
    	
    }
    
    function testThatGroupListReturnsData(){
    	$sut = $this->getServiceBuilder()->get('test.ckan');
    	$this->setMockResponse($sut, array(
    			'group_list_success'
    		)
    	);
    	$model = $sut->GetGroups();
    	$groups = $model->toArray();
    	$this->assertEquals(10, count($groups));
    }
    
    function testThatGroupGetReturnsData(){
    	$sut = $this->getServiceBuilder()->get('test.ckan');
    	$this->setMockResponse($sut, array(
    			'group_get_success'
    	)
    	);
    	$model = $sut->GetGroup(array("group_id"=>"1234"));
    	$group = $model->toArray();
    	$this->assertEquals("user_d7180", $group["users"][0]["name"]);
    	$this->assertEquals("2gether NHS Foundation Trust", $group["display_name"]);
    }
}