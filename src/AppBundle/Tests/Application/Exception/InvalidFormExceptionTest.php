<?php

namespace AppBundle\Tests\Application\Exception;

use AppBundle\Application\Exception\InvalidFormException;
use AppBundle\Application\Test\BaseTestCase;

class InvalidFormExceptionTest extends BaseTestCase
{
    /**
     * @var InvalidFormException
     */
    private $invalidFormException;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->invalidFormException = new InvalidFormException('Foo message', 0, ['form' => 'foo']);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->invalidFormException);
    }

    public function testGetForm()
    {
        $this->assertEquals($this->invalidFormException->getForm(), ['form' => 'foo']);
    }
}