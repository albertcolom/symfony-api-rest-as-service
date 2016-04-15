<?php

namespace AppBundle\Tests\Application\Normalizer;

use AppBundle\Application\Exception\InvalidTypeException;
use AppBundle\Application\Normalizer\NormalizeType;
use AppBundle\Application\Test\BaseTestCase;

class NormalizeTypeTest extends BaseTestCase
{
    /**
     * @var NormalizeType
     */
    private $normalizeType;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->normalizeType = new NormalizeType();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->normalizeType);
    }

    public function testGetType()
    {
        $varType = $this->normalizeType->getVarType('foo');
        $this->assertEquals($varType, 'string');
    }

    public function testSetAvailableType()
    {
        $setVarType = $this->normalizeType->setVarType('0', 'integer');
        $this->assertInternalType('integer', $setVarType);
    }

    public function testSetUnavailableType()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage('Unavailable data type');
        $this->normalizeType->setVarType('0', 'foo');
    }

    /**
     * @dataProvider providerExpectedValidType
     */
    public function testCheckExpectedValidType($var, $expectedType)
    {
        $checkType = $this->normalizeType->checkExpectedType($var, $expectedType);
        $this->assertTrue($checkType);
    }

    public function providerExpectedValidType()
    {
        return [
            ['foobar', ['string','integer']],
            [1, 'integer'],
            [1.1, 'double'],
            [['foobar'], 'array'],
            [true, ['boolean']],
            [null, 'null'],
        ];
    }

    /**
     * @dataProvider providerExpectedInvalidType
     */
    public function testCheckInvalidTypeException($var, $expectedType)
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage('Invalid submitted data type');
        $this->normalizeType->checkExpectedType($var, $expectedType);
    }

    public function providerExpectedInvalidType()
    {
        return [
            [1, ['string','boolean']],
            ['1', 'integer'],
            ['foobar', 'bar'],
        ];
    }

    /**
     * @dataProvider providerAvailableTypes
     */
    public function checkAvailableTypes($type)
    {
        $availableType = $this->normalizeType->checkAvailableType($type);
        $this->assertTrue($availableType);
    }

    public function providerAvailableTypes()
    {
        return [
            'boolean',
            'integer',
            'float',
            'string',
            'array',
            'object',
            'null'
        ];
    }
}