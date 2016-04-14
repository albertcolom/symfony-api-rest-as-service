<?php

namespace AppBundle\Application\Test;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
abstract class SerializerTestCase extends WebTestCase
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var SerializationContext
     */
    protected $context;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();
        $this->context = new SerializationContext();
        $this->context->setSerializeNull(true);
        $this->serializer = $this->getContainer()->get('jms_serializer');
    }

    /**
     * @inheritdoc
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->context, $this->serializer);
    }

    /**
     * @param $serializerEntity
     * @param array $expected
     */
    public function assertSerializedEntityColumnsAreEquals($serializerEntity, array $expected)
    {
        $entityKey = array_keys(json_decode($serializerEntity, true));
        $this->assertEquals($entityKey, $expected);
    }
}