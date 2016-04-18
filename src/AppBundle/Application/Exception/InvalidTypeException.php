<?php

namespace AppBundle\Application\Exception;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
class InvalidTypeException extends \RuntimeException implements InvalidTypeExceptionInterface
{
    protected $var;
    protected $type;
    protected $expectedType;

    public function __construct($message, $code = 0, $var = null, $expectedType = [])
    {
        parent::__construct($message, $code);
        $this->var = $var;
        $this->type = gettype($var);
        $this->expectedType = $expectedType;
    }

    /**
     * {@inheritdoc}
     */
    public function getVar()
    {
        return $this->var;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpectedType()
    {
        if (!is_array($this->expectedType)) {
            $this->expectedType = (array)$this->expectedType;
        }
        return implode(",", $this->expectedType);
    }
}
