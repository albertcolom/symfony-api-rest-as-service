<?php

namespace AppBundle\Application\Rest\v1;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
class RestView implements RestViewInterface
{
    /**
     * @var ViewHandlerInterface
     */
    private $viewHandler;

    /**
     * @var View
     */
    private $view;

    public function __construct(ViewHandlerInterface $viewHandler, View $view)
    {
        $this->viewHandler = $viewHandler;
        $this->view = $view;
    }

    /**
     * {@inheritdoc}
     */
    public function handler(View $view)
    {
        return $this->viewHandler->handle($view);
    }

    /**
     * {@inheritdoc}
     */
    public function createView($data = null, $statusCode = null, array $headers = [])
    {
        return $this->view->create($data, $statusCode, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function createRedirect($route, array $parameters = [], $statusCode = Response::HTTP_FOUND, array $headers = [])
    {
        return $this->view->createRouteRedirect($route, $parameters, $statusCode, $headers);
    }
}