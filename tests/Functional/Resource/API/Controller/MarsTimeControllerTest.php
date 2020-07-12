<?php
declare(strict_types=1);

namespace App\Tests\Functional\Resource\API\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MarsTimeControllerTest extends WebTestCase
{
    public function testConvertAction()
    {
        $client = static::createClient();

        $validUTCTime = '2020-07-11T16:34:40+00:00';
        $inValidUTCTime = '2-71E16:34';

        $client->request('GET', "/mars-time/convert/{$validUTCTime}");

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{
            "marsSolDate": 52088.21834250023,
            "martianCoordinatedTime": "05:14:25"
        }', $client->getResponse()->getContent());

        $client->request('GET', "/mars-time/convert/{$inValidUTCTime}");

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{
            "error": "Invalid earth time stamp in UTC format"
        }',
            $client->getResponse()->getContent()
        );
    }
}
