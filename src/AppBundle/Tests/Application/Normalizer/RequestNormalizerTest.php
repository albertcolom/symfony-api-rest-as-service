<?php

namespace AppBundle\Tests\Application\Normalizer;

use AppBundle\Application\Normalizer\RequestNormalizer;
use AppBundle\Application\Normalizer\NormalizeSort;

class RequestNormalizerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  RequestNormalizer */
    private $normalizer;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $sortMock = $this->getMock(NormalizeSort::class);
        $sortMock
            ->expects($this->any())
            ->method('normalize')
            ->will($this->returnValue([]));

        $this->normalizer = new RequestNormalizer($sortMock);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->normalizer);
    }

    public function testRequestNormalizerDefaultValues()
    {
        $data = $this->normalizer->normalize([]);

        $this->assertEquals($data->getOffset(), 0);
        $this->assertEquals($data->getLimit(), 20);
        $this->assertEquals($data->getFields(), []);
        $this->assertEquals($data->getSort(), []);
        $this->assertEquals($data->getGroups(), ['Default']);
    }

    public function testNormalizeOffset()
    {
        $data = $this->normalizer->normalize(['offset' => 10]);
        $this->assertEquals($data->getOffset(), 10);
    }

    public function testRequestNormalizerLimit()
    {
        $data = $this->normalizer->normalize(['limit' => 50]);
        $this->assertEquals($data->getLimit(), 50);
    }

    public function testRequestNormalizerFields()
    {
        $data = $this->normalizer->normalize(['fields'=>['foo' => 'bar']]);
        $this->assertEquals($data->getFields(), ['foo' => 'bar']);
    }

    public function testRequestNormalizerGroups()
    {
        $data = $this->normalizer->normalize(['groups'=>['foo','bar']]);
        $this->assertEquals($data->getGroups(), ['foo','bar']);
    }
}