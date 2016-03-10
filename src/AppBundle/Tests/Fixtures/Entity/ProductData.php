<?php
namespace AppBundle\Tests\Fixtures\Entity;

use AppBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $products;

    public function load(ObjectManager $manager)
    {
        self::$products = [];

        foreach($this->getDataArray() as $reference => $value) {

            $product = new Product();
            $product->setName($value['name']);
            $product->setDescription($value['description']);
            $product->setActive($value['active']);
            $manager->persist($product);
            $this->addReference($reference, $product);

            self::$products[] = $product;
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

    public function getDataArray()
    {
        return
        [
            'product-1' => [
                'name' => 'Product 1',
                'description' => 'Description 1',
                'active' => true
            ],
            'product-2' => [
                'name' => 'Product 2',
                'description' => 'Description 2',
                'active' => false
            ],
            'product-3' => [
                'name' => 'Product 3',
                'description' => 'Description 3',
                'active' => true
            ]
        ];
    }
}