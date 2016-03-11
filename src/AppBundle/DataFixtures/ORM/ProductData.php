<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach($this->getDataArray() as $reference => $value) {

            $product = new Product();
            $product->setName($value['name']);
            $product->setDescription($value['description']);
            $product->setActive($value['active']);
            $product->setCategory($this->getReference($value['category']));
            $manager->persist($product);
            $this->addReference($reference, $product);
        }
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * @return array
     */
    public function getDataArray()
    {
        return
        [
            'product-1' => [
                'name' => 'Product 1',
                'description' => 'Description 1',
                'active' => true,
                'category' => 'category-1'
            ],
            'product-2' => [
                'name' => 'Product 2',
                'description' => 'Description 2',
                'active' => false,
                'category' => 'category-2'
            ],
            'product-3' => [
                'name' => 'Product 3',
                'description' => 'Description 3',
                'active' => true,
                'category' => 'category-2'
            ]
        ];
    }
}