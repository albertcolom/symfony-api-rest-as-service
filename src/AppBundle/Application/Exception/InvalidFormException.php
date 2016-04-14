<?php
namespace AppBundle\Application\Exception;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
class InvalidFormException extends \RuntimeException
{
    protected $form;

    /**
     * @param string $message
     * @param null $form
     */
    public function __construct($message, $form = null)
    {
        parent::__construct($message);
        $this->form = $form;
    }

    /**
     * @return array|null
     */
    public function getForm()
    {
        return $this->form;
    }
}