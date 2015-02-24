<?php
require_once __DIR__.'/../vendor/autoload.php';

use Silex\WebTestCase;

class API extends WebTestCase
{
    public function createApplication()
    {
        return require __DIR__ . '/../web/index.php';
    }

    public function testApi()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/api/favorites');
        
        $this->assertTrue($client->getResponse()->isOk());
    }
}