Symfony API REST as Service
===========================
[![Build Status](https://travis-ci.org/albertcolom/symfony-api-rest-as-service.svg?branch=master)](https://travis-ci.org/albertcolom/symfony-api-rest-as-service)

### Development environment (optional)
Vagrant & Ansible:

- [https://github.com/albertcolom/custom-ansible-vagrant](https://github.com/albertcolom/custom-ansible-vagrant)


### Bundles
- [FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle)
- [JMSSerializerBundle](https://github.com/schmittjoh/JMSSerializerBundle)
- [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle)
- [NelmioCorsBundle](https://github.com/nelmio/NelmioCorsBundle)
- [LiipFunctionalTestBundle](https://github.com/liip/LiipFunctionalTestBundle)

### Installation
Clone this repository
```sh
$ git clone git@github.com:albertcolom/symfony-api-rest-as-service
```
Install dependencies
```sh
$ composer install
```
Config parameters
```sh
$ app/config/parameters.yml
```
Create Database
```sh
$ app/console doctrine:database:create
```
Load Fixtures
```sh
$ app/console doctrine:fixtures:load
``` 

### List of services
[src/AppBundle/Resources/config/services.yml](https://github.com/albertcolom/symfony-api-rest-as-service/blob/master/src/AppBundle/Resources/config/services.yml)
```php
services:
    util.inflector:
      class: AppBundle\Util\Inflector\NoPluralize

    app.request.normalize.sort:
      class: AppBundle\Application\Normalizer\NormalizeSort

    app.request.normalize.type:
      class: AppBundle\Application\Normalizer\NormalizeType

    app.request.normalize.data:
      class: AppBundle\Application\Normalizer\RequestNormalizerData

    app.request.normalize:
      class: AppBundle\Application\Normalizer\RequestNormalizer
      arguments: ['@app.request.normalize.sort', '@app.request.normalize.type','@app.request.normalize.data']

    app.fos_rest.view.view:
      class: FOS\RestBundle\View\View
      factory: [FOS\RestBundle\View\View, create]

    app.rest.view:
      class: AppBundle\Application\Rest\v1\RestView
      arguments: ['@fos_rest.view_handler','@app.fos_rest.view.view']

    app.serializer.fields.exclusion:
      class: AppBundle\Application\Serializer\FieldsListExclusionStrategy

    app.jms.serializer.context:
      class: JMS\Serializer\SerializationContext

    app.rest.base:
      class: AppBundle\Application\Rest\v1\RestBase
      arguments: ['@doctrine.orm.entity_manager','@app.rest.view','@app.request.normalize','@form.factory','@app.serializer.fields.exclusion','@app.jms.serializer.context']
```

### Example methods
GET Entity
```php
<?php
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get entity instance",
     *  statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when not found"
     *  }
     * )
     *
     * @Annotations\QueryParam(name="fields", nullable=true, array=true,
     *     description="Fields to return. Must be an array ie. &fields[entityA]=id,name&fields[entityB]=id")
     *
     * @param Entity $entity
     * @param ParamFetcherInterface $paramFetcher
     * @return Response
     */
    public function getAction(Entity $entity, ParamFetcherInterface $paramFetcher)
    {
        /** @var $base RestBase */
        $base = $this->container->get('app.rest.base');
        return $base->get($entity, $paramFetcher->all());
    }
```

GET Collection
```php
<?php

    /**
     *
     * @ApiDoc(
     *   resource = true,
     *   description="Get Collection",
     *   statusCodes = {
     *     200 = "Returned when successful",
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
        /** @var $base RestBase */
        $base = $this->container->get('app.rest.base');
        return $base->getCollection(Entity::class, $paramFetcher->all());
    }
``` 

POST
```php
<?php

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Create entity",
     *  input = "AppBundle\Form\EntityType",
     *  statusCodes = {
     *      201 = "Returned when is created",
     *      400 = "Returned when the form has errors"
     *  }
     * )
     *
     * @param Request $request
     * @return Response
     */
    public function postAction(Request $request)
    {
        /** @var $base RestBase */
        $base = $this->container->get('app.rest.base');
        return $base->post(new Entity(), EntityType::class, $request, 'url_redirect');
    }
``` 

PUT
```php
<?php

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Update entity",
     *  input = "AppBundle\Form\EntityType",
     *  statusCodes = {
     *      201 = "Returned when is created",
     *      204 = "Returned when successful",
     *      400 = "Returned when the form has errors"
     *  }
     * )
     *
     *
     * @param Request $request
     * @param $entity
     * @return Response
     */
    public function putAction(Request $request, Entity $entity)
    {
        /** @var $base RestBase */
        $base = $this->container->get('app.rest.base');
        return $base->put($entity, EntityType::class, $request, 'url_redirect');
    }
``` 

PATCH
```php
<?php

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Update entity",
     *  input = "AppBundle\Form\EntityType",
     *  statusCodes = {
     *      201 = "Returned when is created",
     *      204 = "Returned when successful",
     *      400 = "Returned when the form has errors"
     *  }
     * )
     *
     *
     * @param Request $request
     * @param $entity
     * @return Response
     */
    public function putAction(Request $request, Entity $entity)
    {
        /** @var $base RestBase */
        $base = $this->container->get('app.rest.base');
        return $base->patch($entity, EntityType::class, $request, 'url_redirect');
    }
``` 

### API documentation
URL
```
http://domain/web/app_dev.php/api/doc
``` 

### Test
```sh
$ bin/phpunit -c  app
```

### CodeSniffer PSR-2
```sh
$ bin/phpcs --standard=PSR2 src
```