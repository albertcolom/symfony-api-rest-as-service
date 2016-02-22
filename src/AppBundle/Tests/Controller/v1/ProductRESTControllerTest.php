<?php

namespace AppBundle\Tests\Controller\v1;

use AppBundle\Entity\Product;
use AppBundle\Application\Test\ControllerTestCase;
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
        $this->client->request('GET', $route);

        $this->assertStatusCode(Response::HTTP_OK, $this->client);

        $content = $this->client->getResponse()->getContent();

        dump(json_decode(json_encode($product)));

        $this->assertJson($content);
    }

    public function testJsonGetProductsAction()
    {
        $products = $this->prepareFixtures();

        $route = $this->getUrl('api_v1_get_products');
        $this->client->request('GET', $route);

        $this->assertStatusCode(Response::HTTP_OK, $this->client);

        $content = $this->client->getResponse()->getContent();

        $this->assertJson($content);
        $this->assertCount(count($products), json_decode($content));
    }

    public function testJsonPostProductActionShouldCreateWithHeaderLocation()
    {
        $new = '{"name":"name post","description":"description post","active":true}';

        $route = $this->getUrl('api_v1_post_product');
        $this->client->request('POST', $route, [], [], ['CONTENT_TYPE' => 'application/json'], $new);

        $this->assertStatusCode(Response::HTTP_CREATED, $this->client);

        $head_location = $this->client->getResponse()->headers->get('location');
        $this->client->request('GET', $head_location);

        $this->assertStatusCode(Response::HTTP_OK, $this->client);
        $content = $this->client->getResponse()->getContent();

        $new = $this->addJsonValue($new, ['id' => $this->getValueFromJson($content,'id')]);

        $this->assertEquals($content, $new);
    }

    public function testJsonPutProductActionShouldModifyWithHeaderLocation()
    {
        $products = $this->prepareFixtures();
        /** @var  $product Product */
        $product = end($products);

        $modify = '{"name":"test put"}';

        $route = $this->getUrl('api_v1_put_product', ['entity'=>$product->getId()]);
        $this->client->request('PUT', $route, [], [], ['CONTENT_TYPE' => 'application/json'], $modify);

        $this->assertStatusCode(Response::HTTP_NO_CONTENT, $this->client);

        $head_location = $this->client->getResponse()->headers->get('location');
        $this->client->request('GET', $head_location);

        $this->assertStatusCode(Response::HTTP_OK, $this->client);
        $content = $this->client->getResponse()->getContent();

        $this->assertEquals($this->getValueFromJson($content,'id'), $product->getId());
        $this->assertEquals($this->getValueFromJson($modify,'name'), $this->getValueFromJson($content,'name'));
    }

    public function testDeleteProductAction()
    {
        $products = $this->prepareFixtures();
        /** @var  $product Product */
        $product = end($products);

        $route = $this->getUrl('api_v1_delete_product', ['entity'=>$product->getId()]);
        $this->client->request('DELETE', $route);

        $this->assertStatusCode(Response::HTTP_NO_CONTENT, $this->client);

        $route = $this->getUrl('api_v1_get_product', ['entity'=>$product->getId()]);
        $this->client->request('GET', $route);

        $this->assertStatusCode(Response::HTTP_NOT_FOUND, $this->client);
    }

    /**
     * @return array
     */
    public function prepareFixtures()
    {
        $fixtures = array('AppBundle\Tests\Fixtures\Entity\ProductData');
        $this->loadFixtures($fixtures);
        return ProductData::$products;
    }
}
