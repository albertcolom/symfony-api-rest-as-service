<?php

namespace AppBundle\Application\Serializer;

use JMS\Serializer\Exclusion\ExclusionStrategyInterface;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\Context;

class FieldsListExclusionStrategy implements ExclusionStrategyInterface
{
    /**
     * @var array
     */
    private $fields;

    public function __construct()
    {
        $this->fields = [];
    }

    /**
     * {@inheritDoc}
     */
    public function shouldSkipClass(ClassMetadata $metadata, Context $navigatorContext)
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function shouldSkipProperty(PropertyMetadata $property, Context $navigatorContext)
    {
        if (empty($this->fields)) {
            return false;
        }

        $entityName = $this->getEntityNameFromClass($property->class);
        $propertyName = strtolower($property->serializedName ?: $property->name);

        return !$this->propertyExists($entityName, $propertyName);
    }

    /**
     * @param $class
     * @return string
     */
    public function getEntityNameFromClass($class)
    {
        $entityName = explode('\\', $class);
        return strtolower(array_pop($entityName));
    }

    /**
     * @param $entityName
     * @param $propertyName
     * @return bool
     */
    public function propertyExists($entityName, $propertyName)
    {
        if(isset($this->fields[$entityName])) {
            $fields = explode(',', $this->fields[$entityName]);
            return in_array($propertyName, $fields);
        }
        return false;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }
}