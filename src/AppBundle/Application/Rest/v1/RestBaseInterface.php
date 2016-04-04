<?php

namespace AppBundle\Application\Rest\v1;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface RestBaseInterface
{

    /**
     * @param $entity
     * @param array $params
     * @return View
     */
    public function get($entity, array $params);

    /**
     * @param $entity
     * @param array $params
     * @return View
     */
    public function getCollection($entity, array $params);

    /**
     * @param $entity
     * @param $formType
     * @param Request $request
     * @param null $redirect
     * @return array|View|null
     */
    public function post($entity, $formType, Request $request, $redirect = null);

    /**
     * @param $entity
     * @param $formType
     * @param Request $request
     * @param null $redirect
     * @return array|View|null
     */
    public function put($entity, $formType, Request $request, $redirect = null);

    /**
     * @param $entity
     * @return View
     */
    public function delete($entity);

    /**
     * @param null $data
     * @param null $statusCode
     * @param array $headers
     * @return View
     */
    public function createView($data = null, $statusCode = null, array $headers = []);

    /**
     * @param $route
     * @param array $parameters
     * @param int $statusCode
     * @param array $headers
     * @return View
     */
    public function createRedirect($route, array $parameters = [], $statusCode = Response::HTTP_FOUND, array $headers = []);
}