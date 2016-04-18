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

        $this->assertEquals($new['name'], $this->getValueFromJson($content, 'name'));
    }

    public function testJsonPutCategoryActionShouldModifyWithHeaderLocation()
    {
        $categories = $this->prepareFixtures();
        /** @var  $category Category */
        $category = end($categories);

        $modify = '{"name":"category test put"}';

        $route = $this->getUrl('api_v1_put_category', ['entity'=>$category->getId()]);
        $this->client->request('PUT', $route, [], [], $this->getJsonHeaders(), $modify);

        $this->assertStatusCode(Response::HTTP_NO_CONTENT, $this->client);

        $head_location = $this->client->getResponse()->headers->get('location');
        $this->client->request('GET', $head_location, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);
        $content = $this->client->getResponse()->getContent();

        $this->assertEquals($this->getValueFromJson($content, 'id'), $category->getId());
        $this->assertEquals($this->getValueFromJson($modify, 'name'), $this->getValueFromJson($content, 'name'));
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

    public function testJsonGetCategoriesActionWithFilterLimitAndOffset()
    {
        $this->prepareFixtures();
        $route = $this->getUrl('api_v1_get_categories', ['limit'=>1, 'offset'=>1]);
        $this->client->request('GET', $route, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);

        $content = $this->client->getResponse()->getContent();
        $this->assertCount(1, json_decode($content));

        $decodeContent = json_decode($content);
        $this->assertEquals(2, $decodeContent['0']->id);
    }

    public function testJsonGetCategoriesActionWithFilterFieldsAndSort()
    {
        $this->prepareFixtures();
        $route = $this->getUrl('api_v1_get_categories', ['fields[category]'=>'id', 'sort'=>'-id']);
        $this->client->request('GET', $route, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);

        $content = $this->client->getResponse()->getContent();
        $expected = [
            ['id' => 2],
            ['id' => 1]
        ];
        $this->assertEquals($content, json_encode($expected));
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
