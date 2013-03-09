<?php

namespace ckan\ckan;

class Ckan {

	private $baseUri;
	private $userName;
	private $password;
	private $apiKey;
	private $apiVersion;
	private $httpClient;

	private $dataset;
	

	const INVALID_PROPERTY = 101;
	const INVALID_OP_CLONE_DATASET = 102;


	public function __construct($httpClient, $userName='', $password='', $apiKey='', $apiVersion='2'){
		$this->httpClient = $httpClient;
		$this->userName = $userName;
		$this->password = $password;
		$this->apiKey = $apiKey;
		$this->apiVersion = $apiVersion;
	}


	/**
	 * as per http://docs.ckan.org/en/ckan-1.8/api-v2.html#model-api
	*/
	private $resources = array(
		"Dataset Register" => "rest/dataset",
		"Dataset Entity" => "rest/dataset/@dataset@",
		"Group Register" => "rest/group",
		"Group Entity" => "rest/group/@group@",
		"Tag Register" => "rest/tag",
		"Tag Entity" => "rest/tag/@tag@",
		"Revision Register" => "rest/revision",
		"Revision Entity" => "rest/revision/@revision@",
		"License List" => "rest/licenses",
	);

	private function getResourceUri($resource){
		$params = $resource['parameters'];
		return str_replace(array_keys($params), $params, $this->resources[$resource["name"]]);

	}

	private function buildUri($resource){
		return sprintf("api/%s/%s", $this->apiVersion, $this->getResourceUri($resource));
	}

	public function get($resource){

		$uri = $this->buildUri($resource);

		$response = $this->httpClient->get($uri);
		return $response;
	}

	private function getDataset(){

        if (!isset($this->dataset)) {
            $this->dataset = new Dataset($this);
        }
        return $this->dataset;

	}

	public function __get($name){
	    switch ($name) {
	 		case 'dataset':
	 				return $this->getDataset();
	 			break;
	 		
	 		default:
	 			throw new CKanInvalidProperty("The property: {$name} does not exist.", client::INVALID_PROPERTY);
	 			
	 			break;
	 	}
	 }
}

class Dataset {
	private $ckan;	
	protected static $instance = null;

    public function __construct($ckan){
        $this->ckan = $ckan;
    }

    protected function __clone()
    {
    	throw new CkanInvalidOperation("Attempt to clone Dataset singleton object.", INVALID_OP_CLONE_DATASET);
    }
    public function lists(){
		$resource = array("name" => "Dataset Register", "parameters" => array());
    	return $this->ckan->get($resource);

    }
}

class CkanException extends \Exception{};
class CKanInvalidProperty extends CkanException{};
class CkanInvalidOperation extends CkanException{};
