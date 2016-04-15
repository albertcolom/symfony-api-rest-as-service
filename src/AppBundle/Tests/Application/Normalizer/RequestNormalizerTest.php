<?php

namespace AppBundle\Tests\Application\Normalizer;

use AppBundle\Application\Normalizer\NormalizeType;
use AppBundle\Application\Normalizer\RequestNormalizer;
use AppBundle\Application\Normalizer\NormalizeSort;
use AppBundle\Application\Normalizer\RequestNormalizerData;
use AppBundle\Application\Test\BaseTestCase;

class RequestNormalizerTest extends BaseTestCase
{
    /**
     * @var RequestNormalizer
     */
    private $requestNormalizer;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $sortMock = $this->getMockBuilder(NormalizeSort::class)
            ->disableOriginalConstructor()
            ->getMock();

        $typeMock = $this->getMockBuilder(NormalizeType::class)
            ->disableOriginalConstructor()
            ->getMock();

        $requestNormalizerData = $this->getMockBuilder(RequestNormalizerData::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestNormalizer = new RequestNormalizer($sortMock, $typeMock, $requestNormalizerData);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->requestNormalizer);
    }

    /**
     * @dataProvider providerCheckAndGet
     */
    public function testGetAndCheckValue($params, $index, $default, $expected)
    {
        $getVar = $this->invokePrivateMethod($this->requestNormalizer, 'checkAndGet', [$params, $index, $default]);
        $this->assertEquals($getVar, $expected);
    }

    public function providerCheckAndGet()
    {
        return [
            [['foo' => 'bar'], 'foo', 'bar', 'bar'],
            [['foo' => 'bar'], 'foz', 'foobar', 'foobar'],
            [['foo' => 'bar'], 'foz', '', null],
            [['foo'], 0, '', 'foo'],
            [[], '', '', null],
        ];
    }
}