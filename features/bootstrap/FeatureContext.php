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
use Silex\ckan\client;

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
    private $datasets;

    /**
     * @Given /^I have set the client to use http:\/\/ckan\.net\/api as the base url$/
     */
    public function iHaveSetTheClientToUseHttpCkanNetApiAsTheBaseUrl()
    {

       $this->ckanClient = Guzzle\Service\Builder\ServiceBuilder::factory(array(
		'dev.ckan' => array(
				'class' => 'Silex\ckan\CkanClient',
				'params' => array(
					'baseUrl' => 'http://co-prod2.dh.bytemark.co.uk/api/',
                    'apiKey' => 'ee95fd59-3990-4e89-8142-a962d6005ab6',
				)
		)))->get('dev.ckan');
       
       
    }

    /**
     * @When /^I call the client->dataset->list method$/
     */
    public function iCallTheClientDatasetListMethod()
    {
        $this->result = $this->ckanClient->GetDatasets();
    }

    /**
     * @Then /^I should see a list of results$/
     */
    public function iShouldSeeAListOfResults()
    {
         $this->datasets = $this->result->toArray();
         assert(0 < count($this->datasets));
    }

    /**
     * @Given /^the results should include the fishes-of-texas dataset$/
     */
    public function theResultsShouldIncludeTheFishesOfTexasDataset()
    {
        assert( in_array('fishes-of-texas', $this->datasets));
    }

    /**
     * @When /^I call the get\.package_search method with a query of police$/
     */
    public function iCallTheGetPackageSearchMethodWithAQueryOfPolice()
    {
      $this->result = $this->ckanClient->PackageSearch(array('q' => 'police'));

    }

    /**
     * @Given /^the search results should include the hellenic-police dataset$/
     */
    public function theSearchResultsShouldIncludeTheHellenicPoliceDataset()
    {
      $result = $this->result->toArray();
      PHPUnit_Framework_Assert::assertTrue(recursive_array_search('hellenic-police', $result['result']));
    }

    /**
     * @When /^I call the get\.package_create method$/
     */
    public function iCallTheGetPackageCreateMethod()
    {
      $packageJson = <<<'EOD'
{"name":"organogram-test", "title": "Organogram of Roles & Salaries", "owner_org": "department-for-education",
"license_id": "uk-ogl", "notes": "Organogram (organisation chart) showing all staff roles. Names and salaries are also listed for the Senior Civil Servants.\r\n\r\nOrganogram data is released by all central government departments and their agencies since 2010. Snapshots for 31st March and 30th September are published by 6th June and 6th December each year. The published data is validated and released in CSV and RDF format and OGL-licensed for reuse.",
"tags":[{"name": "organograms"}], "extras": [{"key": "geographic_coverage",
"value": "111100: United Kingdom (England, Scotland, Wales, Northern Ireland)"},
{"key": "mandate", "value":"https://www.gov.uk/government/news/letter-to-government-departments-on-opening-up-data"},
{"key": "update_frequency", "value": "biannually"}, {"key": "temporal_coverage-from", "value": "2010"}, {"key": "theme-primary",
"value": "Government"}, {"key": "import_source", "value":
"organograms_v2"}]}
EOD;

      try {
        $result = $this->ckanClient->PackageCreate(array('data' =>  $packageJson));
        $package = $result->toArray();
      }
      catch (Exception $e){

        $result = $this->ckanClient->PackageSearch(array('fq' => 'publisher:department-for-education import_source:organograms_v2'));
        $model = $result->toArray();
        $package = $model['result']['results'][0];
      }


     $resource  = array(
          'package_id' => $package['id'],
          'date' => '2014-09-30',
          'description' => 'Organogram',
          'url' => 'http://data.gov.uk/organograms/department-of-education/staff-and-salary---Sept-2013-senior.xml',
          'format' => 'XML',
        );
      $resourceJson = json_encode($resource);
      $result = $this->ckanClient->ResourceCreate(array('data' => $resourceJson));
      $resource = $result->toArray();

      $this->ckanClient->PackageDelete(array('id' => $package['result']['id']));
    }

    /**
     * @Then /^my new package should be created$/
     */
    public function myNewPackageShouldBeCreated()
    {
      throw new PendingException();
    }



}
function recursive_array_search($needle,$haystack) {
  foreach($haystack as $key=>$value) {
    $current_key=$key;
    if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
      return $current_key;
    }
  }
  return false;
}
