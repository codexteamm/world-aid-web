<?php

namespace AssociationBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class campementControllerTest extends WebTestCase
{
    public function testShowall()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showAll');
    }

    public function testShowmine()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showMine');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/edit');
    }

}
