Feature: list dataset
	In order to see a list of the dataset assets in CKAN
	as an API user
	I need to list the datasets in CKAN

Scenario:
	Given I have set the client to use http://ckan.net/api as the base url
	When I call the client->dataset->list method
	Then I should see a list of results