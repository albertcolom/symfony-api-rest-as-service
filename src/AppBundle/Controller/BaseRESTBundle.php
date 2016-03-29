<?php

namespace AppBundle\Controller;

use AppBundle\Application\Normalizer\RequestNormalizerData;
use AppBundle\Application\Normalizer\RequestNormalizer;
use AppBundle\Application\Serializer\FieldsListExclusionStrategy;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Exception\InvalidFormException;

class BaseRESTBundle extends FOSRestController
{
    public function sget($entity, ParamFetcherInterface $paramFetcher)
    {
        $normalizedData = $this->getRequestNormalizeData($paramFetcher->all());

        return $this->view($entity)->setSerializationContext($this->getSerializationContext($normalizedData));
    }

    public function cget(Request $request, ParamFetcherInterface $paramFetcher, $entity)
    {
        $normalizedData = $this->getRequestNormalizeData($paramFetcher->all());

        $result = $this->getDoctrine()
            ->getRepository($entity)
            ->findBy([], $normalizedData->getSort(), $normalizedData->getLimit(), $normalizedData->getOffset());

        return $this->getViewResultSerializationContext($result, $normalizedData);
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

    public function getViewResultSerializationContext($content, RequestNormalizerData $normalizedData)
    {
        if (empty($content)) {
            throw new NotFoundHttpException('Not Found');
        }

        return $this->view($content)->setSerializationContext($this->getSerializationContext($normalizedData));
    }

    public function getSerializationContext(RequestNormalizerData $normalizedData)
    {
        $context = new SerializationContext();
        $context->setGroups($normalizedData->getGroups());
        $context->addExclusionStrategy(new FieldsListExclusionStrategy($normalizedData->getFields()));

        return $context;
    }

    public function getRequestNormalizeData(array $params)
    {
        /** @var $normalizer RequestNormalizer */
        $normalizer = $this->container->get('app.request.normalize');
        /** @var RequestNormalizerData $normalizeData */
        $normalizeData = $normalizer->normalize($params);

        return $normalizeData;
    }
}