<?php

namespace AppBundle\Application\Normalizer;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface RequestNormalizerDataInterface
{
    /**
     * @return int
     */
    public function getOffset();

    /**
     * @param int $offset
     */
    public function setOffset($offset);

    /**
     * @return int
     */
    public function getLimit();

    /**
     * @param int $limit
     */
    public function setLimit($limit);

    /**
     * @return array
     */
    public function getSort();

    /**
     * @param array $sort
     */
    public function setSort(array $sort);

    /**
     * @return array
     */
    public function getFields();

    /**
     * @param array $fields
     */
    public function setFields(array $fields);

    /**
     * @return array
     */
    public function getGroups();

    /**
     * @param array $groups
     */
    public function setGroups(array $groups);
}