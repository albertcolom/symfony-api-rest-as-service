<?php

namespace AppBundle\Tests\Application\Normalizer;

use AppBundle\Application\Normalizer\RequestNormalizerData;
use AppBundle\Application\Test\BaseTestCase;

/**
 * @group Normalize
 */
class RequestNormalizeDataTest extends BaseTestCase
{
    /**
     * @var RequestNormalizerData
     */
    private $requestNormalizeData;

    protected function setUp()
    {
        $this->requestNormalizeData = new RequestNormalizerData();
    }

    public function tearDown()
    {
        unset($this->requestNormalizeData);
    }

    public function testRequestNormalizerDataDefaultValues()
    {
        $this->assertEquals($this->requestNormalizeData->getOffset(), 0);
        $this->assertEquals($this->requestNormalizeData->getLimit(), 20);
        $this->assertEquals($this->requestNormalizeData->getFields(), []);
        $this->assertEquals($this->requestNormalizeData->getSort(), []);
        $this->assertEquals($this->requestNormalizeData->getGroups(), ['Default']);
    }

    public function testSetGetOffset()
    {
        $this->requestNormalizeData->setOffset(2);
        $this->assertEquals($this->requestNormalizeData->getOffset(), 2);
    }

    public function testSetGetLimit()
    {
        $this->requestNormalizeData->setLimit(50);
        $this->assertEquals($this->requestNormalizeData->getLimit(), 50);
    }

    public function testSetGetSort()
    {
        $this->requestNormalizeData->setSort(['foo'=>'ASC']);
        $this->assertEquals($this->requestNormalizeData->getSort(), ['foo'=>'ASC']);
    }

    public function testSetGetFields()
    {
        $this->requestNormalizeData->setFields(['entity'=>'foo,bar']);
        $this->assertEquals($this->requestNormalizeData->getFields(), ['entity'=>'foo,bar']);
    }

    public function testGetGroups()
    {
        $this->requestNormalizeData->setGroups(['Default']);
        $this->assertEquals($this->requestNormalizeData->getGroups(), ['Default']);
    }
}