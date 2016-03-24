<?php

namespace AppBundle\Tests\Serializer;

use AppBundle\Entity\Product;
use AppBundle\Application\Test\SerializerTestCase;

/**
 * @group Product
 */
class ProductSerializerTest extends SerializerTestCase
{
    public function testProductDefaultGroupJsonSerializer()
    {
        $entity = new Product();
        $this->context->setGroups('Default');
        $serializer = $this->serializer->serialize($entity, 'json', $this->context);

        $expectedSerializer = [
            'id',
            'name',
            'description',
            'active',
            'category'
        ];

        $this->assertSerializedEntityColumnsAreEquals($serializer, $expectedSerializer);
    }
}