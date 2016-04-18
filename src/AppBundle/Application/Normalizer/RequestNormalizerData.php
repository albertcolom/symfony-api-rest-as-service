<?php

namespace AppBundle\Application\Normalizer;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
class RequestNormalizerData implements RequestNormalizerDataInterface
{
    const OFFSET = 0;
    const LIMIT = 20;
    const SORT = [];
    const FIELDS = [];
    const GROUPS = ['Default'];

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var array
     */
    private $sort;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var array
     */
    private $groups;

    public function __construct()
    {
        $this->offset = self::OFFSET;
        $this->limit = self::LIMIT;
        $this->sort = self::SORT;
        $this->fields = self::FIELDS;
        $this->groups = self::GROUPS;
    }

    /**
     * {@inheritdoc}
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * {@inheritdoc}
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * {@inheritdoc}
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * {@inheritdoc}
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * {@inheritdoc}
     */
    public function setSort(array $sort)
    {
        $this->sort = $sort;
    }

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * {@inheritdoc}
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * {@inheritdoc}
     */
    public function setGroups(array $groups)
    {
        $this->groups = $groups;
    }
}
