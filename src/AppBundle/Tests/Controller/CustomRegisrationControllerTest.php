<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomRegisrationControllerTest extends WebTestCase
{
    public function testRegisterassociation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/registerAssociation');
    }

    public function testRegisterneedy()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/registerNeedy');
    }

    public function testRegisterdonor()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/registerDonor');
    }

}
