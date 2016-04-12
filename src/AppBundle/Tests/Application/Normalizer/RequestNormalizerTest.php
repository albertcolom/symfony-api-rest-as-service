<?php

namespace AppBundle\Tests\Application\Normalizer;

use AppBundle\Application\Normalizer\RequestNormalizer;
use AppBundle\Application\Normalizer\NormalizeSort;
use AppBundle\Application\Normalizer\RequestNormalizerData;

class RequestNormalizerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  RequestNormalizer */
    private $requestNormalizer;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $sortMock = $this->getMockNormalizeSort();

        /* @todo Need implement with a Mock */
        $requestNormalizerData = new RequestNormalizerData();

        $this->requestNormalizer = new RequestNormalizer($sortMock, $requestNormalizerData);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->requestNormalizer);
    }

    public function testRequestNormalizerDefaultValues()
    {
        $data = $this->requestNormalizer->normalize([]);

        $this->assertEquals($data->getOffset(), 0);
        $this->assertEquals($data->getLimit(), 20);
        $this->assertEquals($data->getFields(), []);
        $this->assertEquals($data->getSort(), []);
        $this->assertEquals($data->getGroups(), ['Default']);
    }

    public function testNormalizeOffset()
    {
        $data = $this->requestNormalizer->normalize(['offset' => 10]);
        $this->assertEquals($data->getOffset(), 10);
    }

    public function testRequestNormalizerLimit()
    {
        $data = $this->requestNormalizer->normalize(['limit' => 50]);
        $this->assertEquals($data->getLimit(), 50);
    }

    public function testRequestNormalizerFields()
    {
        $data = $this->requestNormalizer->normalize(['fields'=>['foo' => 'bar']]);
        $this->assertEquals($data->getFields(), ['foo' => 'bar']);
    }

    public function testRequestNormalizerGroups()
    {
        $data = $this->requestNormalizer->normalize(['groups'=>['foo','bar']]);
        $this->assertEquals($data->getGroups(), ['foo','bar']);
    }

    private function getMockNormalizeSort()
    {
        $sortMock = $this->getMockBuilder(NormalizeSort::class)
            ->setMethods(['normalize'])
            ->disableOriginalConstructor()
            ->getMock();

        $sortMock->expects($this->any())
            ->method('normalize')
            ->will($this->returnValue([]));

        return $sortMock;
    }
}