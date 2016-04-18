<?php

namespace AppBundle\Tests\Serializer;

use AppBundle\Entity\Category;
use AppBundle\Application\Test\SerializerTestCase;

/**
 * @group Category
 */
class CategorySerializerTest extends SerializerTestCase
{
    public function testCategoryDefaultGroupJsonSerializer()
    {
        $entity = new Category();
        $this->context->setGroups('Default');
        $serializer = $this->serializer->serialize($entity, 'json', $this->context);

        $expectedSerializer = [
            'id',
            'name',
            'description'
        ];

        $this->assertSerializedEntityColumnsAreEquals($serializer, $expectedSerializer);
    }
}
