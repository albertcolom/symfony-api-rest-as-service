Symfony API REST as Service
===========================

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
$ git clone git@github.com:albertcolom/...
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

### Example method
Get a generic collection with QueryParam and ApiDoc
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