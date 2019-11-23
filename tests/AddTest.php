<?php


namespace App\Tests;

use App\Entity\Member;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class AddTest extends WebTestCase
{
      public function testUserLogin() {

       $client = static::createClient();
       $crawler = $client->request('GET', '/login');

       $form = $crawler->selectButton('submit')->form(array(
         'username'  => 'Antanas',
         'password'  => 'antanas',
       ));

       $client->submit($form);
       $crawler = $client->followRedirect();
       }


}