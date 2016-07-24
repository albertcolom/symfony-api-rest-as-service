<?php

namespace AppBundle\Controller\v1;

use AppBundle\Application\Rest\v1\RestControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations;

/**
 * Category controller.
 * @RouteResource("Category")
 */
class CategoryRESTController
{
    /**
     * @var RestControllerInterface
     */
    private $restController;

    public function __construct(RestControllerInterface $restController)
    {
        $this->restController = $restController;
    }

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
     * @Annotations\QueryParam(name="fields", nullable=true, array=true,
     *     description="Fields to return. Must be an array ie. &fields[entityA]=id,name&fields[entityB]=id")
     *
     * @param Category $entity
     * @param ParamFetcherInterface $paramFetcher
     * @return Response
     */
    public function getAction(Category $entity, ParamFetcherInterface $paramFetcher)
    {
        return $this->restController->get($entity, $paramFetcher->all());
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
     * @Annotations\QueryParam(name="offset", requirements="\d+", default=0, nullable=true,
     *     description="Offset from which to start listing pages ie. offset=1")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default=20,
     *     description="How many pages to return ie. limit=20")
     * @Annotations\QueryParam(name="sort", nullable=true,
     *     description="JsonApi: Order by fields ie. &sort=-field1,field2 (-field1: DESC | field2: ASC)")
     * @Annotations\QueryParam(name="fields", nullable=true, array=true,
     *     description="Fields to return. Must be an array ie. &fields[entityA]=id,name&fields[entityB]=id")
     *
     * @param ParamFetcherInterface $paramFetcher
     * @return Response
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->restController->getCollection(Category::class, $paramFetcher->all());
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Create entity",
     *  input = "AppBundle\Form\CategoryType",
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
        return $this->restController->post(new Category(), CategoryType::class, $request, 'api_v1_get_category');
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Update entity",
     *  input = "AppBundle\Form\CategoryType",
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
    public function putAction(Request $request, Category $entity)
    {
        return $this->restController->put($entity, CategoryType::class, $request, 'api_v1_get_category');
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Update Partial entity",
     *  input = "AppBundle\Form\CategoryType",
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
    public function patchAction(Request $request, Category $entity)
    {
        return $this->restController->patch($entity, CategoryType::class, $request, 'api_v1_get_category');
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
     * @param Category $entity
     * @return Response
     */
    public function deleteAction(Category $entity)
    {
        return $this->restController->delete($entity);
    }
}
