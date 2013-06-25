<?php

//Guzzle\Tests\GuzzleTestCase::setServiceBuilder(Aws\Common\Aws::factory($_SERVER['CONFIG']));
Guzzle\Tests\GuzzleTestCase::setServiceBuilder(Guzzle\Service\Builder\ServiceBuilder::factory(array(
    'test.ckan' => array(
        'class' => 'Silex\ckan\CkanClient',
        'params' => array(

        )
    )
)));

Guzzle\Tests\GuzzleTestCase::setMockBasePath(__DIR__ . '/mock');
