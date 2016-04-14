<?php

namespace AppBundle\Tests\Application\Exception;

use AppBundle\Application\Exception\InvalidTypeException;
use AppBundle\Application\Test\BaseTestCase;

class InvalidTypeExceptionTest extends BaseTestCase
{
    /**
     * @var InvalidTypeException
     */
    private $invalidTypeException;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->invalidTypeException = new InvalidTypeException('Foo message', 0, 'foo', 'bar');
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->invalidTypeException);
    }

    public function testGetVar()
    {
        $this->assertEquals($this->invalidTypeException->getVar(), 'foo');
    }

    public function testGetVarType()
    {
        $this->assertEquals($this->invalidTypeException->getType(), 'string');
    }

    public function testGetExpectedType()
    {
        $this->assertEquals($this->invalidTypeException->getExpectedType(), 'bar');
    }
}