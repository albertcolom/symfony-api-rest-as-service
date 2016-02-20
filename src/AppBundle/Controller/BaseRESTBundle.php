<?php

namespace AppBundle\Controller;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Exception\InvalidFormException;

class BaseRESTBundle extends FOSRestController
{

    public function get($entity)
    {
        return $entity;
    }

    public function cget(Request $request, ParamFetcherInterface $paramFetcher, $entity)
    {

        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $sort = $paramFetcher->get('sort');

        $result = $this->getDoctrine()->getRepository($entity)->findBy(array(), $sort, $limit, $offset);

        return $this->getViewContent($result);
    }

    public function delete($entity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    public function post($entity, $formType, Request $request)
    {
        try {

            $data =  $this->processForm($entity, $formType, $request, 'POST');
            return $this->routeRedirectView('api_v1_get_product', ['entity'=>$data->getId()], Response::HTTP_CREATED);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    public function put($entity, $formType, Request $request)
    {
        try {

            $data =  $this->processForm($entity, $formType, $request, 'PUT');
            return $this->routeRedirectView('api_v1_get_product', ['entity'=>$data->getId()], Response::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    public function processForm($entity, $formType, Request $request, $method){

        $form = $this->createForm($formType, $entity, ["method" => $method]);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $em->persist($data);
            $em->flush();

            return $data;
        }

        throw new InvalidFormException('Invalid submitted data', Response::HTTP_BAD_REQUEST, $form);
    }

    public function getViewContent($content)
    {
        if (empty($content)) {
            throw new NotFoundHttpException('Not Found');
        }

        return $this->view($content);
    }
}