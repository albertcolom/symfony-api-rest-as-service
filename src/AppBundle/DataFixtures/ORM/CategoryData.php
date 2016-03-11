<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $categories;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        self::$categories = [];

        foreach($this->getDataArray() as $reference => $value) {

            $category = new Category();
            $category->setName($value['name']);
            $category->setDescription($value['description']);
            $manager->persist($category);
            $this->addReference($reference, $category);

            self::$categories[] = $category;
        }
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * @return array
     */
    public function getDataArray()
    {
        return
        [
            'category-1' => [
                'name' => 'Category 1',
                'description' => 'Description 1',
                'active' => true
            ],
            'category-2' => [
                'name' => 'Category 2',
                'description' => 'Description 2',
                'active' => false
            ]
        ];
    }
}