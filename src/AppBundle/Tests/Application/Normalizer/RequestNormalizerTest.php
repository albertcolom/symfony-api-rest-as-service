<?php

namespace AppBundle\Tests\Application\Normalizer;

use AppBundle\Application\Exception\InvalidTypeException;
use AppBundle\Application\Normalizer\RequestNormalizer;
use AppBundle\Application\Normalizer\NormalizeSort;
use AppBundle\Application\Normalizer\RequestNormalizerData;
use AppBundle\Application\Test\BaseTestCase;

class RequestNormalizerTest extends BaseTestCase
{
    /** @var  RequestNormalizer */
    private $requestNormalizer;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $sortMock = $this->getMockBuilder(NormalizeSort::class)
            ->disableOriginalConstructor()
            ->getMock();

        $requestNormalizerData = $this->getMockBuilder(RequestNormalizerData::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestNormalizer = new RequestNormalizer($sortMock, $requestNormalizerData);
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

    /**
     * @dataProvider providerExpectedValidType
     */
    public function testCheckExpectedValidType($var, $expectedType)
    {
        $checkType = $this->invokePrivateMethod($this->requestNormalizer, 'checkExpectedType', [$var, $expectedType]);
        $this->assertTrue($checkType);
    }

    public function providerExpectedValidType()
    {
        return [
            ['foobar', 'string'],
            [1, 'integer'],
            [1.1, 'double'],
            [['foobar'], 'array'],
            [true, 'boolean'],
            [null, 'null'],
        ];
    }

    /**
     * @dataProvider providerExpectedInvalidType
     */
    public function testCheckInvalidTypeException($var, $expectedType)
    {
        $this->expectException(InvalidTypeException::class);
        $this->invokePrivateMethod($this->requestNormalizer, 'checkExpectedType', [$var, $expectedType]);
    }

    public function providerExpectedInvalidType()
    {
        return [
            [1, 'string'],
            ['1', 'integer'],
            ['foobar', 'bar'],
        ];
    }
}