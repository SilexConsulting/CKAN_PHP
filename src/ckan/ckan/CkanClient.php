<?php

namespace ckan\ckan;


use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

class CkanClient extends Client {	

    /**
     * Factory method to create a new CkanClient
     *
     * The following array keys and values are available options:
     * - base_url: Base URL of web service
     * - scheme:   URI scheme: http or https
     * - username: API username
     * - password: API password
     *
     * @param array|Collection $config Configuration data
     *
     * @return self
     */
    public static function factory($config = array())
    {
        $default = array(
            'base_url' => '{scheme}://{username}.test.com/',
            'scheme'   => 'https'
        );
        $required = array('base_url');
        $config = Collection::fromConfig($config, $default, $required);

        $client = new self($config->get('base_url'), $config);
        // Attach a service description to the client
        $description = ServiceDescription::factory(__DIR__ . '/service.json');
        $client->setDescription($description);

        return $client;
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
}
