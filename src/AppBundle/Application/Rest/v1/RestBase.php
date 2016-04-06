<?php

namespace AppBundle\Application\Rest\v1;

use AppBundle\Application\Normalizer\RequestNormalizer;
use AppBundle\Application\Normalizer\RequestNormalizerData;
use AppBundle\Application\Serializer\FieldsListExclusionStrategy;
use AppBundle\Exception\InvalidFormException;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RestBase implements RestBaseInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var RestView
     */
    private $restView;

    /**
     * @var RequestNormalizer
     */
    private $requestNormalizer;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var FieldsListExclusionStrategy
     */
    private $fieldsListExclusionStrategy;

    /**
     * @var SerializationContext
     */
    private $serializerContext;

    public function __construct(EntityManager $em, RestView $restView, RequestNormalizer $requestNormalizer, FormFactory $formFactory, FieldsListExclusionStrategy $fieldsListExclusionStrategy, SerializationContext $serializerContext)
    {
        $this->em = $em;
        $this->restView = $restView;
        $this->requestNormalizer = $requestNormalizer;
        $this->formFactory = $formFactory;
        $this->fieldsListExclusionStrategy = $fieldsListExclusionStrategy;
        $this->serializerContext = $serializerContext;
    }

    /**
     * {@inheritdoc}
     */
    public function get($entity, array $params)
    {
        /** @var $normalizedData RequestNormalizerData */
        $normalizedData = $this->requestNormalizer->normalize($params);
        return $this->restView->createView($entity)->setSerializationContext($this->getSerializationContext($normalizedData));
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection($entity, array $params)
    {
        /** @var $normalizedData RequestNormalizerData */
        $normalizedData = $this->requestNormalizer->normalize($params);

        $result =$this->em->getRepository($entity)
            ->findBy([], $normalizedData->getSort(), $normalizedData->getLimit(), $normalizedData->getOffset());

        return $this->restView->createView($result)->setSerializationContext($this->getSerializationContext($normalizedData));
    }

    /**
     * {@inheritdoc}
     */
    public function post($entity, $formType, Request $request, $redirect = null)
    {
        return $this->saveData('POST', $entity, $formType, $request, $redirect, Response::HTTP_CREATED);
    }

    /**
     * {@inheritdoc}
     */
    public function put($entity, $formType, Request $request, $redirect = null)
    {
        return $this->saveData('PUT', $entity, $formType, $request, $redirect, Response::HTTP_NO_CONTENT);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();

        return $this->restView->createView(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $type
     * @param $entity
     * @param $formType
     * @param Request $request
     * @param $redirect
     * @param $HttpResponse
     * @return array|View|null
     */
    private function saveData($type, $entity, $formType, Request $request, $redirect, $HttpResponse)
    {
        try {
            $data =  $this->processForm($entity, $formType, $request, $type);

            if($redirect) {
                return $this->restView->createRedirect($redirect, ['entity'=>$data->getId()], $HttpResponse);
            }else{
                return $entity;
            }

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * @param $entity
     * @param $formType
     * @param Request $request
     * @param $method
     * @return mixed
     */
    private function processForm($entity, $formType, Request $request, $method){

        $form = $this->formFactory->create($formType, $entity, ["method" => $method]);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $data = $form->getData();
            $this->em->persist($data);
            $this->em->flush();

            return $data;
        }

        throw new InvalidFormException('Invalid submitted data', Response::HTTP_BAD_REQUEST, $form);
    }

    /**
     * @param RequestNormalizerData $normalizedData
     * @return SerializationContext
     */
    public function getSerializationContext(RequestNormalizerData $normalizedData)
    {
        $this->fieldsListExclusionStrategy->setFields($normalizedData->getFields());

        $this->serializerContext->setGroups($normalizedData->getGroups());
        $this->serializerContext->addExclusionStrategy($this->fieldsListExclusionStrategy);

        return $this->serializerContext;
    }
}