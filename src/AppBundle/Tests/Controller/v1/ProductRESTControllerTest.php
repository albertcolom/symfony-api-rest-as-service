<?php

namespace AppBundle\Tests\Controller\v1;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Application\Test\ControllerTestCase;
use AppBundle\Tests\Fixtures\Entity\CategoryData;
use AppBundle\Tests\Fixtures\Entity\ProductData;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Product
 */
class ProductRESTControllerTest extends ControllerTestCase
{
    public function testJsonGetProductAction()
    {
        $products = $this->prepareFixtures();

        /** @var  $product Product */
        $product = end($products);

        $route = $this->getUrl('api_v1_get_product', ['entity'=>$product->getId()]);
        $this->client->request('GET', $route, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);

        $content = $this->client->getResponse()->getContent();

        $this->assertJson($content);
    }

    public function testJsonGetProductsAction()
    {
        $products = $this->prepareFixtures();

        $route = $this->getUrl('api_v1_get_products');
        $this->client->request('GET', $route, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);

        $content = $this->client->getResponse()->getContent();

        $this->assertJson($content);
        $this->assertCount(count($products), json_decode($content));
    }

    public function testJsonPostProductActionShouldCreateWithHeaderLocation()
    {
        $fixtures = ['AppBundle\Tests\Fixtures\Entity\CategoryData'];
        $this->loadFixtures($fixtures);

        $categories = CategoryData::$categories;
        /** @var $category Category */
        $category = end($categories);

        $new = [
            'name' => 'name post',
            'description' => 'description post',
            'active' => true,
            'category' => $category->getId()
        ];

        $route = $this->getUrl('api_v1_post_product');
        $this->client->request('POST', $route, [], [], $this->getJsonHeaders(), json_encode($new));

        $this->assertStatusCode(Response::HTTP_CREATED, $this->client);

        $head_location = $this->client->getResponse()->headers->get('location');
        $this->client->request('GET', $head_location, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);
        $content = $this->client->getResponse()->getContent();

        $this->assertEquals($new['name'], $this->getValueFromJson($content, 'name'));
    }

    public function testJsonPutProductActionShouldModifyWithHeaderLocation()
    {
        $products = $this->prepareFixtures();
        /** @var  $product Product */
        $product = end($products);

        $modify = [
            'name' => 'name put',
            'description' => 'description put',
            'active' => false,
            'category' => 1
        ];

        $route = $this->getUrl('api_v1_put_product', ['entity'=>$product->getId()]);
        $this->client->request('PUT', $route, [], [], $this->getJsonHeaders(), json_encode($modify));

        $this->assertStatusCode(Response::HTTP_NO_CONTENT, $this->client);

        $head_location = $this->client->getResponse()->headers->get('location');
        $this->client->request('GET', $head_location, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);
        $content = $this->client->getResponse()->getContent();

        $this->assertEquals($this->getValueFromJson($content, 'id'), $product->getId());
        $this->assertEquals($modify['name'], $this->getValueFromJson($content, 'name'));
        $this->assertEquals($modify['description'], $this->getValueFromJson($content, 'description'));
        $this->assertEquals($modify['active'], $this->getValueFromJson($content, 'active'));
    }

    public function testJsonPatchProductActionShouldModifyWithHeaderLocation()
    {
        $products = $this->prepareFixtures();
        /** @var  $product Product */
        $product = end($products);

        $modify = [
            'name' => 'name patch',
        ];

        $route = $this->getUrl('api_v1_patch_product', ['entity'=>$product->getId()]);
        $this->client->request('PATCH', $route, [], [], $this->getJsonHeaders(), json_encode($modify));

        $this->assertStatusCode(Response::HTTP_NO_CONTENT, $this->client);

        $head_location = $this->client->getResponse()->headers->get('location');
        $this->client->request('GET', $head_location, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);
        $content = $this->client->getResponse()->getContent();

        $this->assertEquals($this->getValueFromJson($content, 'id'), $product->getId());
        $this->assertEquals($modify['name'], $this->getValueFromJson($content, 'name'));
    }

    public function testJsonDeleteProductAction()
    {
        $products = $this->prepareFixtures();
        /** @var  $product Product */
        $product = end($products);

        $route = $this->getUrl('api_v1_delete_product', ['entity'=>$product->getId()]);
        $this->client->request('DELETE', $route, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_NO_CONTENT, $this->client);

        $route = $this->getUrl('api_v1_get_product', ['entity'=>$product->getId()]);
        $this->client->request('GET', $route, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_NOT_FOUND, $this->client);
    }

    public function testJsonGetCategoriesActionWithFilterLimitAndOffset()
    {
        $this->prepareFixtures();
        $route = $this->getUrl('api_v1_get_products', ['limit'=>1, 'offset'=>1]);
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
        $route = $this->getUrl('api_v1_get_products', ['fields[product]'=>'id', 'sort'=>'-id']);
        $this->client->request('GET', $route, [], [], $this->getJsonHeaders());

        $this->assertStatusCode(Response::HTTP_OK, $this->client);

        $content = $this->client->getResponse()->getContent();
        $expected = [
            ['id' => 3],
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
        $fixtures = [
            'AppBundle\Tests\Fixtures\Entity\CategoryData',
            'AppBundle\Tests\Fixtures\Entity\ProductData'
        ];

        $this->loadFixtures($fixtures);
        return ProductData::$products;
    }
}
