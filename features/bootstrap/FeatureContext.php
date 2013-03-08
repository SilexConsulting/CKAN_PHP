<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//
use ckan\ckan\client;

require_once("vendor/autoload.php");

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }


    private $ckanClient;
    private $result;

    /**
     * @Given /^I have set the client to use http:\/\/ckan\.net\/api as the base url$/
     */
    public function iHaveSetTheClientToUseHttpCkanNetApiAsTheBaseUrl()
    {

       $this->ckanClient = new client("http://ckan.net/api/");
    }

    /**
     * @When /^I call the client->dataset->list method$/
     */
    public function iCallTheClientDatasetListMethod()
    {
        $this->result = $this->ckanClient->dataset->list();
    }

    /**
     * @Then /^I should see a list of results$/
     */
    public function iShouldSeeAListOfResults()
    {
        throw new PendingException();
    }

}
