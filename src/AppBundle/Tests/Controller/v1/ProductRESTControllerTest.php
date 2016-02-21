<?php

namespace AppBundle\Tests\Controller\v1;

use AppBundle\Entity\Product;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use AppBundle\Tests\Fixtures\Entity\ProductData;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Product
 */
class ProductRESTControllerTest extends WebTestCase
{
    const HTTP_HOST = 'localhost';

    /** @var \Symfony\Bundle\FrameworkBundle\Client */
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient(array(), array(
            'HTTP_HOST' => self::HTTP_HOST,
        ));
    }

    public function testJsonGetProductAction()
    {
        $products = $this->prepareFixtures();

        /** @var  $product Product */
        $product = end($products);

        $route = $this->getUrl('api_v1_get_product', ['entity'=>$product->getId()]);
        $this->client->request('GET', $route);

        $this->assertStatusCode(Response::HTTP_OK, $this->client);

        $content = $this->client->getResponse()->getContent();

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

    public function testJsonPostProductAction()
    {
        $new = '{"name":"name post","description":"description post","active":true}';

        $route = $this->getUrl('api_v1_post_product');
        $this->client->request('POST', $route, [], [], ['CONTENT_TYPE' => 'application/json'], $new);

        $this->assertStatusCode(Response::HTTP_CREATED, $this->client);
    }

    public function testJsonPutProductActionShouldModifyAndHeaderLocation()
    {
        $products = $this->prepareFixtures();
        /** @var  $product Product */
        $product = end($products);

        $modify = '{"name":"test put","description":"description put","active":true}';

        $route = $this->getUrl('api_v1_put_product', ['entity'=>$product->getId()]);
        $this->client->request('PUT', $route, [], [], ['CONTENT_TYPE' => 'application/json'], $modify);
        $head_location = $this->client->getResponse()->headers->get('location');

        $this->assertStatusCode(Response::HTTP_NO_CONTENT, $this->client);

        $route = $this->getUrl('api_v1_get_product', ['entity'=>$product->getId()]);
        $this->client->request('GET', $route);

        $content = $this->client->getResponse()->getContent();
        $modify = str_replace('{', '{"id":'.$product->getId().',', $modify);

        $this->assertEquals($modify, $content);
        $this->assertEquals('http://'.self::HTTP_HOST.$route, $head_location);
    }

    public function testDeleteProduct()
    {
        $products = $this->prepareFixtures();
        /** @var  $product Product */
        $product = end($products);

        $route = $this->getUrl('api_v1_delete_product', ['entity'=>$product->getId()]);
        $this->client->request('DELETE', $route);

        $this->assertStatusCode(Response::HTTP_NO_CONTENT, $this->client);
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
