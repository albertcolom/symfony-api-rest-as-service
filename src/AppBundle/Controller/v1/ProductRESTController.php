<?php

namespace AppBundle\Controller\v1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use AppBundle\Controller\BaseRESTBundle;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations;

/**
 * Product controller.
 * @RouteResource("Product")
 */
class ProductRESTController extends BaseRESTBundle
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
     * @param Product $entity
     * @return Response
     */
    public function getAction(Product $entity)
    {
        return $this->get($entity);
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
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many pages to return ie. limit=20")
     * @Annotations\QueryParam(name="sort", nullable=true, array=true, description="Order by fields. Must be an array ie. &sort[name]=ASC&sort[description]=DESC")
     *
     *
     * @param Request $request
     * @param ParamFetcherInterface $paramFetcher
     * @return Response
     */
    public function cgetAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->cget($request, $paramFetcher, Product::class);
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
        return $this->post(new Product(), ProductType::class, $request);
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
        return $this->put($entity, ProductType::class, $request);
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
        return $this->delete($entity);
    }
}
