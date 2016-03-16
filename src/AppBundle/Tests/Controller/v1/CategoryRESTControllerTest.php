<?php

namespace AppBundle\Tests\Controller\v1;

use AppBundle\Entity\Category;
use AppBundle\Application\Test\ControllerTestCase;
use AppBundle\Tests\Fixtures\Entity\CategoryData;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Category
 */
class CategoryRESTControllerTest extends ControllerTestCase
{
    public function testJsonCategoryAction()
    {
        $categories = $this->prepareFixtures();

        /** @var  $category Category */
        $category = end($categories);

        $route = $this->getUrl('api_v1_get_category', ['entity'=>$category->getId()]);
        $this->client->request('GET', $route, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);

        $content = $this->client->getResponse()->getContent();

        $this->assertJson($content);
    }

    public function testJsonPostProductActionShouldCreateWithHeaderLocation()
    {

        $new = [
            'name' => 'name post',
            'description' => 'description post'
        ];

        $route = $this->getUrl('api_v1_post_category');
        $this->client->request('POST', $route, [], [], $this->getJsonHeaders(), json_encode($new));

        $this->assertStatusCode(Response::HTTP_CREATED, $this->client);

        $head_location = $this->client->getResponse()->headers->get('location');
        $this->client->request('GET', $head_location, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);
        $content = $this->client->getResponse()->getContent();

        $this->assertEquals($new['name'], $this->getValueFromJson($content,'name'));
    }

    public function testJsonGetCategoriesAction()
    {
        $categories = $this->prepareFixtures();

        $route = $this->getUrl('api_v1_get_categories');
        $this->client->request('GET', $route, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);

        $content = $this->client->getResponse()->getContent();

        $this->assertJson($content);
        $this->assertCount(count($categories), json_decode($content));
    }

    public function testJsonDeleteProductAction()
    {
        $categories = $this->prepareFixtures();

        /** @var  $category Category */
        $category = end($categories);

        $route = $this->getUrl('api_v1_delete_category', ['entity'=>$category->getId()]);
        $this->client->request('DELETE', $route, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_NO_CONTENT, $this->client);

        $route = $this->getUrl('api_v1_get_category', ['entity'=>$category->getId()]);
        $this->client->request('GET', $route, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_NOT_FOUND, $this->client);
    }


    /**
     * @return array
     */
    public function prepareFixtures()
    {
        $fixtures = ['AppBundle\Tests\Fixtures\Entity\CategoryData'];

        $this->loadFixtures($fixtures);
        return CategoryData::$categories;
    }
}
