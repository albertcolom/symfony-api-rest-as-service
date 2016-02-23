<?php

namespace AppBundle\Application\Test;

use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class ControllerTestCase extends WebTestCase
{
    const HTTP_HOST = 'localhost';

    /** @var \Symfony\Bundle\FrameworkBundle\Client */
    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient(array(), array(
            'HTTP_HOST' => self::HTTP_HOST,
        ));
    }

    /**
     * @return array
     */
    protected function getJsonHeaders()
    {
        return [
            'HTTP_ACCEPT' => 'application/json',
            'CONTENT_TYPE' => 'application/json',
        ];
    }

    /**
     * @param string $json
     * @param string $key
     * @return null|string
     */
    public function getValueFromJson($json, $key)
    {
        $decode = json_decode($json, true);
        return array_key_exists($key, $decode) ? $decode[$key] : null;
    }

    /**
     * @param string $json
     * @param array $array
     * @return string
     */
    public function addJsonValue($json, array $array)
    {
        $decode = json_decode($json, true);
        $merge = array_merge($array, $decode);
        return json_encode($merge);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->client);
    }
}