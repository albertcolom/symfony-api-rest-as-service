<?php

namespace AppBundle\Application\Rest\v1;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface RestViewInterface
{
    /**
     * @param View $view
     * @return Response
     */
    public function handler(View $view);

    /**
     * @param mixed $data
     * @param int $statusCode
     * @param array $headers
     * @return View
     */
    public function createView($data = null, $statusCode = null, array $headers = []);

    /**
     * @param string $route
     * @param array $parameters
     * @param int $statusCode
     * @param array $headers
     * @return View
     */
    public function createRedirect($route, array $parameters = [], $statusCode = Response::HTTP_FOUND, array $headers = []);
}