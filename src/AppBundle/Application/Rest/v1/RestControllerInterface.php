<?php

namespace AppBundle\Application\Rest\v1;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface RestControllerInterface
{

    /**
     * @param $entity
     * @param array $params
     * @return View
     */
    public function get($entity, array $params = []);

    /**
     * @param $entity
     * @param array $params
     * @return View
     */
    public function getCollection($entity, array $params = []);

    /**
     * @param $entity
     * @param $formType
     * @param Request $request
     * @param string $redirect
     * @return array|View|null
     */
    public function post($entity, $formType, Request $request, $redirect = null);

    /**
     * @param $entity
     * @param $formType
     * @param Request $request
     * @param string $redirect
     * @return array|View|null
     */
    public function put($entity, $formType, Request $request, $redirect = null);

    /**
     * @param $entity
     * @param $formType
     * @param Request $request
     * @param string $redirect
     * @return array|View|null
     */
    public function patch($entity, $formType, Request $request, $redirect = null);

    /**
     * @param $entity
     * @return View
     */
    public function delete($entity);
}
