<?php

namespace ckan\ckan;


use nategood\httpful;

class Client {

	private $baseUri;
	private $userName;
	private $password;
	private $apiKey;
	private $apiVersion;
	

	const INVALID_PROPERTY = 101;
	const INVALID_OP_CLONE_DATASET = 102;


	public function __construct($baseUri, $userName='', $password='', $apiKey='', $apiVersion=2){
		$this->baseUri = $baseUri;
		$this->userName = $userName;
		$this->password = $password;
		$this->apiKey = $apiKey;
	}


	/**
	 * as per http://docs.ckan.org/en/ckan-1.8/api-v2.html#model-api
	*/
	private $resources = array(
		"Dataset Register" => "/rest/dataset",
		"Dataset Entity" => "/rest/dataset/@dataset@",
		"Group Register" => "/rest/group",
		"Group Entity" => "/rest/group/@group@",
		"Tag Register" => "/rest/tag",
		"Tag Entity" => "/rest/tag/@tag@",
		"Revision Register" => "/rest/revision",
		"Revision Entity" => "/rest/revision/@revision@",
		"License List" => "/rest/licenses",
	);

	private function getResourceUri($resource){

		$params = $resource['parameters'];
		return str_replace(array_keys($params), $params, $this->resources[$resource['name']]);

	}

	private function buildUri($resource){
		return sprintf("%s/api/%d/%s", $this->baseUri, $this->apiVersion, $this->getResourceUri($resource));
	}

	public function get($resource){
		$uri = buildUrl($resource);
		$response = Request::get($uri);
	}

	public function __get($name){
	    switch ($name) {
	 		case 'dataset':
	 				return Dataset::getInstance($client);
	 			break;
	 		
	 		default:
	 			throw new CKanInvalidProperty("The property: {$name} does not exist.", client::INVALID_PROPERTY);
	 			
	 			break;
	 	}
	 }
}

class Dataset {
	private $client;	
	protected static $instance = null;

    protected function __construct(){
        //This is a singleton
    }

    protected function __clone()
    {
    	throw new CkanInvalidOperation("Attempt to clone Dataset singleton object.", INVALID_OP_CLONE_DATASET);
    }

    public static function getInstance($client)
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
            static::$instance->client = $client;
        }
        return static::$instance;
    }

    public function lists(){

    }
}

class CkanException extends \Exception{};
class CKanInvalidProperty extends CkanException{};
class CkanInvalidOperation extends CkanException{};
