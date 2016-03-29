<?php

namespace AppBundle\Tests\Application\Normalizer;

use AppBundle\Application\Normalizer\RequestNormalizerData;

/**
 * @group Normalize
 */
class RequestNormalizeDataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RequestNormalizerData
     */
    private $requestNormalizeData;

    protected function setUp()
    {
        $this->requestNormalizeData = new RequestNormalizerData(2, 50, ['foo'=>'ASC'], ['entity'=>'foo,bar'], ['Default']);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->requestNormalizeData);
    }

    public function testGetOffset()
    {
        $this->assertEquals($this->requestNormalizeData->getOffset(), 2);
    }

    public function testGetLimit()
    {
        $this->assertEquals($this->requestNormalizeData->getLimit(), 50);
    }

    public function testGetSort()
    {
        $this->assertEquals($this->requestNormalizeData->getSort(), ['foo'=>'ASC']);
    }

    public function testGetFields()
    {
        $this->assertEquals($this->requestNormalizeData->getFields(), ['entity'=>'foo,bar']);
    }

    public function testGetGroups()
    {
        $this->assertEquals($this->requestNormalizeData->getGroups(), ['Default']);
    }
}