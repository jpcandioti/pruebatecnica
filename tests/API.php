<?php
//require_once __DIR__.'/../vendor/autoload.php';
//
//use Silex\WebTestCase;

//class API extends WebTestCase
class API extends PHPUnit_Framework_TestCase
{
    //public function createApplication()
    //{
    //    return require __DIR__ . '/../web/index.php';
    //}

    public function testApi()
    {
        //$client = $this->createClient();
        //$crawler = $client->request('GET', '/api/favorites');
        //
        //$this->assertTrue($client->getResponse()->isOk());

        $dominio = 'prueba.com.ar';
        $url = 'http://' . $dominio . '/index.php/api/favorites';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_exec($ch);

        // No hubo errores en curl.
        $this->assertEquals(0, curl_errno($ch));
        // Fue exitoso.
        $this->assertEquals(200, curl_getinfo($ch, CURLINFO_HTTP_CODE));

        curl_close($ch);
    }
}