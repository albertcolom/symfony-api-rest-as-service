<?php

namespace AppBundle\Controller\v1;

use AppBundle\Application\Rest\v1\RestBase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations;

/**
 * Product controller.
 * @RouteResource("Product")
 */
class ProductRESTController extends Controller
{
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get entity instance",
     *  statusCodes = {
     *      200 = "Returned when successful",
     *      401 = "Returned when unauthorized access",
     *      404 = "Returned when not found"
     *  }
     * )
     *
     * @Annotations\QueryParam(name="fields", nullable=true, array=true, description="Fields to return. Must be an array ie. &fields[entityA]=id,name&fields[entityB]=id")
     *
     * @param Product $entity
     * @param ParamFetcherInterface $paramFetcher
     * @return Response
     */
    public function getAction(Product $entity, ParamFetcherInterface $paramFetcher)
    {
        /** @var $base RestBase */
        $base = $this->container->get('app.rest.base');
        return $base->get($entity, $paramFetcher->all());
    }

    /**
     *
     * @ApiDoc(
     *   resource = true,
     *   description="Get action",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     401 = "Returned when unauthorized access",
     *     404 = "Returned when not found"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", default=0, nullable=true, description="Offset from which to start listing pages ie. offset=1")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default=20, description="How many pages to return ie. limit=20")
     * @Annotations\QueryParam(name="sort", nullable=true,  description="JsonApi: Order by fields ie. &sort=-field1,field2 (-field1: DESC | field2: ASC)")
     * @Annotations\QueryParam(name="fields", nullable=true, array=true, description="JsonApi: Fields to return. Must be an array ie. &fields[entityA]=id,name&fields[entityB]=id")
     *
     * @param ParamFetcherInterface $paramFetcher
     * @return Response
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher)
    {
        /** @var $base RestBase */
        $base = $this->container->get('app.rest.base');
        return $base->getCollection(Product::class, $paramFetcher->all());
    }


    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Create entity",
     *  input = "AppBundle\Form\ProductType",
     *  statusCodes = {
     *      201 = "Returned when is created",
     *      400 = "Returned when the form has errors",
     *      401 = "Returned when unauthorized access"
     *  }
     * )
     *
     * @param Request $request
     * @return Response
     */
    public function postAction(Request $request)
    {
        /** @var $base RestBase */
        $base = $this->container->get('app.rest.base');
        return $base->post(new Product(), ProductType::class, $request, 'api_v1_get_product');
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Update entity",
     *  input = "AppBundle\Form\ProductType",
     *  statusCodes = {
     *      201 = "Returned when is created",
     *      204 = "Returned when successful",
     *      400 = "Returned when the form has errors",
     *      401 = "Returned when unauthorized access"
     *  }
     * )
     *
     *
     * @param Request $request
     * @param $entity
     * @return Response
     */
    public function putAction(Request $request, Product $entity)
    {
        $base = $this->container->get('app.rest.base');
        return $base->put($entity, ProductType::class, $request, 'api_v1_get_product');
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Update Partial entity",
     *  input = "AppBundle\Form\ProductType",
     *  statusCodes = {
     *      204 = "Returned when successful",
     *      400 = "Returned when the form has errors",
     *      401 = "Returned when unauthorized access"
     *  }
     * )
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
     */
    public function patchAction(Request $request, Product $entity)
    {
        return $this->putAction($request, $entity);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Delete action",
     *  statusCodes = {
     *      204 = "Returned when delete",
     *      401 = "Returned when unauthorized access",
     *      404 = "Returned when not found"
     *  }
     * )
     *
     * @param Product $entity
     * @return Response
     */
    public function deleteAction(Product $entity)
    {
        /** @var $base RestBase */
        $base = $this->container->get('app.rest.base');
        return $base->delete($entity);
    }
}
