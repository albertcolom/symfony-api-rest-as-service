<?php

namespace AppBundle\Controller;

use AppBundle\Application\Serializer\FieldsListExclusionStrategy;
use Doctrine\ORM\Mapping\Entity;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Exception\InvalidFormException;

class BaseRESTBundle extends FOSRestController
{
    private $fields = [];

    public function get($entity)
    {
        return $this->view($entity)->setSerializationContext($this->getSerializationContext());
    }

    public function cget(Request $request, ParamFetcherInterface $paramFetcher, $entity)
    {

        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $sort = $paramFetcher->get('sort');

        $this->fields = $paramFetcher->get('fields');

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

    public function post($entity, $formType, Request $request, $redirect = null)
    {
        return $this->saveData('POST', $entity, $formType, $request, $redirect, Response::HTTP_CREATED);

    }

    public function put($entity, $formType, Request $request, $redirect = null)
    {
        return $this->saveData('PUT', $entity, $formType, $request, $redirect, Response::HTTP_NO_CONTENT);

    }

    public function saveData($type, $entity, $formType, Request $request, $redirect, $HttpResponse)
    {
        try {

            $data =  $this->processForm($entity, $formType, $request, $type);

            if($redirect) {
                return $this->routeRedirectView($redirect, ['entity'=>$data->getId()], $HttpResponse);
            }else{
                return $entity;
            }

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

        return $this->view($content)->setSerializationContext($this->getSerializationContext());
    }

    public function getSerializationContext()
    {
        $context = new SerializationContext();
        $groups[] = 'Default';
        $context->setGroups($groups);

        $context->addExclusionStrategy(new FieldsListExclusionStrategy($this->fields));

        return $context;
    }
}