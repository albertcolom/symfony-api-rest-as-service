<?php

namespace AppBundle\Application\Exception;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
class InvalidFormException extends \RuntimeException implements InvalidFormExceptionInterface
{
    protected $form;

    /**
     * @param string $message
     * @param int $code
     * @param null $form
     */
    public function __construct($message, $code = 0, $form = null)
    {
        parent::__construct($message, $code);
        $this->form = $form;
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return $this->form;
    }
}
